<?php

namespace Tests\Feature\Commands;

use App\Facades\Twitter;
use App\Models\SocialPost;
use App\Services\IssueService;
use Config;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TweetNewIssuesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Twitter::fake();

        Http::preventStrayRequests();

        $githubResponse = file_get_contents(base_path('tests/Data/github-response.json'));

        Http::fake([
            'github.com/repos/ash-jc-allen/find-a-pr/issues' => json_decode($githubResponse),
        ]);

        Config::set('repos.repos', ['ash-jc-allen' => ['find-a-pr']]);
        Config::set('repos.orgs', []);
        Config::set('find-a-pr.tweet_issues', true);
    }

    public function test_tweets_new_issues()
    {
        Twitter::assertNoTweetsSent();

        $this->artisan('issues:tweet');

        Twitter::assertTweetCount(1);
    }

    public function test_does_not_tweet_issues_that_are_already_tweeted()
    {
        SocialPost::factory()->tweeted()->state([
            'issue_repo' => 'ash-jc-allen/find-a-pr',
            'issue_number' => 102,
            'issue_id' => 1306817207,
        ])->create();

        $this->artisan('issues:tweet');

        Twitter::assertNoTweetsSent();
    }

    public function test_the_text_of_the_tweet()
    {
        $this->artisan('issues:tweet');

        $issue = app(IssueService::class)->getAll()->first();

        Twitter::assertLastTweet("An issue in {$issue->repoName} may need your help: {$issue->title}".PHP_EOL.$issue->url);
    }

    public function test_correctly_sets_tweeted_timestamp()
    {
        $socialPost = SocialPost::factory()->state([
            'issue_repo' => 'ash-jc-allen/find-a-pr',
            'issue_number' => 102,
            'issue_id' => 1306817207,
        ])->create();

        $this->assertFalse($socialPost->tweetWasSent());

        $this->artisan('issues:tweet');

        $this->assertTrue($socialPost->refresh()->tweetWasSent());
    }

    public function test_only_tweets_issues_once()
    {
        Twitter::assertNoTweetsSent();

        $this->artisan('issues:tweet');

        Twitter::assertTweetCount(1);

        $this->artisan('issues:tweet');

        Twitter::assertTweetCount(1);
    }

    /** @test */
    public function tweets_are_not_sent_if_the_feature_is_disabled(): void
    {
        Config::set('find-a-pr.tweet_issues', false);

        $this->artisan('issues:tweet')
            ->expectsOutputToContain('Tweeting about issues is disabled');

        Twitter::assertNoTweetsSent();
    }
}
