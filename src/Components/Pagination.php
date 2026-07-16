<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 10,
        public int $total = 0,
        public string $baseUrl = '#',
        public string $label = 'results',
    ) {}

    public function lastPage(): int
    {
        return max(1, (int) ceil($this->total / max(1, $this->perPage)));
    }

    public function from(): int
    {
        return $this->total === 0 ? 0 : (($this->page - 1) * $this->perPage) + 1;
    }

    public function to(): int
    {
        return min($this->total, $this->page * $this->perPage);
    }

    /**
     * @return array<int, int|null>
     */
    public function pages(): array
    {
        $last = $this->lastPage();

        if ($last <= 7) {
            return range(1, $last);
        }

        $window = array_filter(
            [$this->page - 1, $this->page, $this->page + 1],
            fn (int $p) => $p > 1 && $p < $last,
        );

        $pages = [1];

        if (min($window) > 2) {
            $pages[] = null;
        }

        foreach ($window as $p) {
            $pages[] = $p;
        }

        if (max($window) < $last - 1) {
            $pages[] = null;
        }

        $pages[] = $last;

        return $pages;
    }

    public function urlFor(int $page): string
    {
        return $this->baseUrl.(str_contains($this->baseUrl, '?') ? '&' : '?').'page='.$page;
    }

    public function render()
    {
        return view('frietzakje::components.pagination');
    }
}
