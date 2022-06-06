<?php

namespace App\Http\Livewire;

use App\DataTransferObjects\Issue;
use App\Services\IssueService;
use App\Services\RepoService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ListIssues extends Component
{
    private const SORTS = [
        'random' => [
            'friendly' => 'Random', 'field' => 'random',
        ],
        'created_at' => [
            'friendly' => 'Created At (Oldest First)', 'field' => 'createdAt', 'direction' => 'asc',
        ],
        'created_at_desc' => [
            'friendly' => 'Created At (Newest First)', 'field' => 'createdAt', 'direction' => 'desc',
        ],
        'title' => [
            'friendly' => 'Title (A-Z)', 'field' => 'title', 'direction' => 'asc',
        ],
        'title_desc' => [
            'friendly' => 'Title (Z-A)', 'field' => 'title', 'direction' => 'desc',
        ],
        'repo_name' => [
            'friendly' => 'Repo Name (A-Z)', 'field' => 'repoName', 'direction' => 'asc',
        ],
        'repo_name_desc' => [
            'friendly' => 'Repo Name (Z-A)', 'field' => 'repoName', 'direction' => 'desc',
        ],
    ];

    public array $labels;

    public Collection $repos;

    /**
     * A collection of the issues when the component was first mounted.
     *
     * @var Collection
     */
    public Collection $originalIssues;

    public array $ignoredUrls = [];

    public ?string $sortField = null;

    public string $sortDirection = 'asc';

    public ?string $sort = null;

    public ?string $searchTerm = null;

    public bool $shouldDisplayFirstTimeNotice;

    public function mount(): void
    {
        $this->labels = config('repos.labels');
        $this->repos = app(RepoService::class)->reposToCrawl()->sort();

        $this->originalIssues = app(IssueService::class)->getAll()->shuffle();

        $this->shouldDisplayFirstTimeNotice = ! Cookie::get('firstTimeNoticeClosed');
    }

    public function render(): View
    {
        $issues = $this->originalIssues
            ->when($this->searchTerm, $this->applySearch())
            ->when($this->sort, $this->applySort());

        return view('livewire.list-issues', [
            'issues' => $issues,
            'sorts' => self::SORTS,
        ]);
    }

    /**
     * When the component re-renders, the items in the 'originalIssues' will be
     * an array. So, hydrate these arrays back into Issue objects before we
     * try working with them.
     *
     * @return void
     */
    public function hydrate(): void
    {
        $this->originalIssues = $this->originalIssues->map(
            fn ($issueArray): Issue => Issue::fromArray($issueArray)
        );
    }

    public function updatedSort(string $newSort): void
    {
        if (array_key_exists($newSort, self::SORTS)) {
            $this->sortField = self::SORTS[$newSort]['field'];
            $this->sortDirection = self::SORTS[$newSort]['direction'] ?? 'asc';
        }
    }

    public function updatedIgnoredUrls(array $urls)
    {
        $this->ignoredUrls = $urls;
        $this->originalIssues = $this->originalIssues->filter(function ($value) {
            return ! in_array($value->url, $this->ignoredUrls);
        });
    }

    private function applySearch(): \Closure
    {
        return static function (Collection $issues, string $searchTerm): Collection {
            $searchTerm = strtolower($searchTerm);

            return $issues->filter(function (Issue $issue) use ($searchTerm): bool {
                return str_contains(strtolower($issue->repoName), $searchTerm)
                    || str_contains(strtolower($issue->title), $searchTerm);
            });
        };
    }

    private function applySort(): \Closure
    {
        return function (Collection $issues): Collection {
            return $issues->sortBy($this->sortField, descending: $this->sortDirection === 'desc');
        };
    }

    public function hideFirstTimeNotice(): void
    {
        $this->shouldDisplayFirstTimeNotice = false;

        // 4 weeks = 40,320 minutes
        Cookie::queue('firstTimeNoticeClosed', true, 40_320);
    }
}
