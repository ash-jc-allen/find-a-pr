<?php

namespace App\Http\Livewire;

use App\DataTransferObjects\Issue;
use App\Services\IssueService;
use App\Services\RepoService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ListIssues extends Component
{
    public array $labels;

    public Collection $repos;

    /**
     * A collection of the issues when the component was first mounted.
     *
     * @var Collection
     */
    public Collection $originalIssues;

    public ?string $sortField = null;

    public string $sortDirection = 'asc';

    public ?string $searchTerm = null;

    public function mount(): void
    {
        $this->labels = config('repos.labels');
        $this->repos = app(RepoService::class)->reposToCrawl()->sort();

        $this->originalIssues = app(IssueService::class)->getAll()->shuffle();
    }

    public function render(): View
    {
        $issues = $this->originalIssues
            ->when($this->searchTerm, function (Collection $issues, string $searchTerm): Collection {
                $searchTerm = strtolower($searchTerm);

                return $issues->filter(function (Issue $issue) use ($searchTerm): bool {
                    return str_contains(strtolower($issue->repoName), $searchTerm)
                        || str_contains(strtolower($issue->title), $searchTerm);
                });
            });


        return view('livewire.list-issues', [
            'issues' => $issues,
        ]);
    }

    public function hydrate(): void
    {
        $this->originalIssues = $this->originalIssues->map(
            fn ($issueArray): Issue => Issue::fromArray($issueArray)
        );
    }

    public function updatedSortField(): void
    {

    }

    // todo handle update direction
    // todo handle update field
}
