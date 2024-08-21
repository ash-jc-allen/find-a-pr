<?php

declare(strict_types=1);

namespace App\Livewire;

use App\DataTransferObjects\Issue;
use App\DataTransferObjects\Label;
use App\DataTransferObjects\Repository;
use App\Exceptions\GitHubRateLimitException;
use App\Services\IssueService;
use App\Services\RepoService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

final class ListIssues extends Component
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
        'interactions' => [
            'friendly' => 'Interactions (Least first)', 'field' => 'interactionsCount', 'direction' => 'asc',
        ],
        'interactions_desc' => [
            'friendly' => 'Interactions (Most first)', 'field' => 'interactionsCount', 'direction' => 'desc',
        ],
    ];

    protected $queryString = [
        'sortField' => ['except' => 'random'],
        'sortDirection' => ['except' => 'asc'],
        'searchTerm' => ['except' => ''],
        'showIgnoredIssues' => ['except' => false],
    ];

    public array $labels;

    /**
     * @var Collection<Repository>
     */
    public Collection $repos;

    /**
     * A collection of the issues when the component was first mounted.
     *
     * @var Collection<Issue>
     */
    public Collection $originalIssues;

    /**
     * @var array<string>
     */
    public array $ignoredUrls = [];

    public ?string $sortField = null;

    public string $sortDirection = 'asc';

    public ?string $sort = null;

    public array $searchLabels = [];

    public ?string $searchTerm = null;

    public bool $shouldDisplayFirstTimeNotice;

    public bool $showIgnoredIssues = false;

    public function mount(): void
    {
        $this->setSortOrderOnPageLoad();

        $this->repos = app(RepoService::class)->reposToCrawl()->sort();

        try {
            $this->originalIssues = app(IssueService::class)->getAll()->shuffle();
        } catch (GitHubRateLimitException $e) {
            abort(503, $e->getMessage());
        }

        $this->shouldDisplayFirstTimeNotice = ! Cookie::get('firstTimeNoticeClosed');
    }

    public function render(): View
    {
        $this->initialiseLabels();

        $issues = $this->originalIssues
            ->filter(fn (Issue $issue): bool => $this->showIgnoredIssues === in_array($issue->url, $this->ignoredUrls, true))
            ->when($this->searchLabels, $this->applySearchLabel())
            ->when($this->searchTerm, $this->applySearch())
            ->when($this->sort, $this->applySort());

        foreach ($issues as $issue) {
            $this->incrementLabelCounts($issue);
        }

        return view('livewire.list-issues', [
            'issues' => $issues,
            'sorts' => self::SORTS,
        ]);
    }

    public function updatedSort(string $newSort): void
    {
        if (array_key_exists($newSort, self::SORTS)) {
            $this->sortField = self::SORTS[$newSort]['field'];
            $this->sortDirection = self::SORTS[$newSort]['direction'] ?? 'asc';
        }
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

    private function applySearchLabel(): \Closure
    {
        return static function (Collection $issues, array $searchLabels): Collection {
            return $issues->filter(function (Issue $issue) use ($searchLabels): bool {
                foreach ($searchLabels as $searchLabel) {
                    if (collect($issue->labels)->contains('name', $searchLabel)) {
                        return true;
                    }
                }

                return false;
            });
        };
    }

    public function toggleSearchLabel(string $label): void
    {
        $key = array_search($label, $this->searchLabels, strict: true);

        if ($key !== false) {
            unset($this->searchLabels[$key]);
        } else {
            $this->searchLabels[] = $label;
        }
    }

    private function applySort(): \Closure
    {
        return function (Collection $issues): Collection {
            return $issues->sortBy($this->sortField, descending: $this->sortDirection === 'desc');
        };
    }

    public function updatedShouldDisplayFirstTimeNotice(): void
    {
        // 4 weeks = 40,320 minutes
        Cookie::queue('firstTimeNoticeClosed', true, 40_320);
    }

    public function updateIgnoredUrls(array $urls): void
    {
        $this->ignoredUrls = collect($urls)
            ->filter(function (string $url): bool {
                return $this->originalIssues->contains(fn (Issue $issue): bool => $url === $issue->url);
            })
            ->toArray();

        if (! $this->ignoredUrls) {
            $this->showIgnoredIssues = false;
        }
    }

    private function setSortOrderOnPageLoad(): void
    {
        if ($this->sortField) {
            $this->sort = collect(self::SORTS)
                ->where('field', $this->sortField)
                ->where('direction', $this->sortDirection)
                ->keys()
                ->first();
        }
    }

    /**
     * Initialise each of the labels with counts of 0.
     *
     * @return void
     */
    private function initialiseLabels(): void
    {
        foreach (config('repos.labels') as $label) {
            $this->labels[$label] = 0;
        }
    }

    /**
     * Loop through each of the labels on the issue and increment the count
     * for each label that we're tracking in Find A PR.
     *
     * @param  Issue  $issue
     * @return void
     */
    private function incrementLabelCounts(Issue $issue): void
    {
        foreach ($issue->labels as $label) {
            if (! $this->isValidLabel($label)) {
                continue;
            }

            $this->labels[$label->name]++;
        }
    }

    /**
     * Assert whether the label is one that we're tracking in Find A PR.
     */
    private function isValidLabel(Label $label): bool
    {
        return array_key_exists($label->name, $this->labels);
    }
}
