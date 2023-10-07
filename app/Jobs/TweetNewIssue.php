<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\Issue;
use App\Facades\Twitter;
use App\Models\SocialPost;
use Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use RateLimiter;

final class TweetNewIssue implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Issue $issue)
    {
        //
    }

    public function handle(): void
    {
        Cache::lock('twitter-lock')->block(10, function () {
            $this->tweetAboutIssue();
        });
    }

    protected function tweetAboutIssue(): void
    {
        $socialPost = SocialPost::firstOrNew(
            ['issue_id' => $this->issue->id],
            [
                'issue_repo' => $this->issue->repoName,
                'issue_number' => $this->issue->number,
            ]
        );

        if ($socialPost->tweetWasSent()) {
            return;
        }

        $response = Twitter::tweet("An issue in {$this->issue->repoName} may need your help: {$this->issue->title}".PHP_EOL.$this->issue->url);

        if (empty($response['data']->id)) {
            RateLimiter::clear('twitter');

            return;
        }

        $socialPost->fill([
            'twitter_sent_at' => now(),
            'tweet_id' => $response['data']->id,
        ]);

        $socialPost->save();
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [(new RateLimited('twitter'))->dontRelease()];
    }

    public function uniqueId(): string
    {
        return (string) $this->issue->id;
    }
}
