<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null sort
 * @property null|string sortField
 * @property null|string sortDirection
 */
class ListIssuesRequest extends FormRequest
{
    private const ALLOWED_SORTS = [
        'title',
        'repoName',
        'createdAt',
    ];

    protected function prepareForValidation(): void
    {
        $explodedSort = explode('|', $this->sort);

        $this->merge([
            'sortField' => $explodedSort[0],
            'sortDirection' => $explodedSort[1] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    public function determineSortField(): ?string
    {
        return $this->sortField && in_array($this->sortField, static::ALLOWED_SORTS, true)
            ? $this->sortField
            : null;
    }

    public function determineSortDirection(): string
    {
        return in_array($this->sortDirection, ['asc', 'desc'], true)
            ? $this->sortDirection
            : 'asc';
    }
}
