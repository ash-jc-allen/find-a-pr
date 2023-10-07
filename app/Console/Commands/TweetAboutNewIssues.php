<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataTransferObjects\Issue;
use App\Jobs\TweetNewIssue;
use App\Models\SocialPost;
use App\Services\IssueService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

use function Termwind\terminal;

final class TweetAboutNewIssues extends Command
{
    protected $signature = 'issues:tweet';

    protected $description = 'Tweet about issues that haven\'t been tweeted about';

    public function handle(): int
    {
        if (! config('find-a-pr.tweet_issues')) {
            $this->components->info('Tweeting about issues is disabled');

            return 0;
        }

        $issues = $this->getUntweetedIssues();

        if ($issues->count() === 0) {
            $this->components->info('There are no new issues to tweet about');

            return 0;
        }

        foreach ($issues as $issue) {
            $this->components->task(
                "Dispatching job to tweet about {$issue->repoName} #{$issue->number}",
                fn () => dispatch(new TweetNewIssue($issue))
            );
        }

        $this->outputJobCount($issues->count());

        return 0;
    }

    private function outputJobCount(int $count): void
    {
        $jobCountText = 'Showing ['.$count.'] routes';

        $offset = min(terminal()->width() - mb_strlen($jobCountText) - 2, 128);
        $spaces = str_repeat(' ', $offset);

        $this->newLine();

        $this->line($spaces.'<fg=blue;options=bold>Dispatched ['.$count.'] jobs</>');
    }

    /**
     * @return Collection<Issue>
     */
    public function getUntweetedIssues(): Collection
    {
        $this->components->info('Fetching issues');
        $issues = app(IssueService::class)->getAll();

        $this->components->info('Filtering out already tweeted issues');

        $tweetedIssueIds = SocialPost::query()
            ->whereNotNull('twitter_sent_at')
            ->pluck('issue_id');

        return $issues->filter(fn (Issue $issue) => $tweetedIssueIds->doesntContain($issue->id));
    }
}
