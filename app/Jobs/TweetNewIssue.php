<?php

namespace App\Jobs;

use App\DataTransferObjects\Issue;
use App\Facades\Twitter;
use App\Models\SocialPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TweetNewIssue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Issue $issue)
    {
        //
    }

    public function handle(): void
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

        $response = Twitter::tweet("An issue in {$this->issue->repoName} may need your help: {$this->issue->title}" . PHP_EOL . $this->issue->url);

        if (empty($response['data']->id)) {
            return;
        }

        $socialPost->fill([
            'twitter_sent_at' => now(),
            'tweet_id' => $response['data']->id,
        ]);

        $socialPost->save();
    }
}
