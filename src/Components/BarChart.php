<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class BarChart extends Component
{
    /**
     * A dependency-free bar chart: CSS heights against the series maximum, no canvas,
     * no chart library. Good for the "how did this week go" panel every dashboard has.
     *
     * @param  array<int, array{label: string, value: int|float, variant?: string}>  $series
     */
    public function __construct(
        public array $series = [],
        public string $variant = 'primary',
        public int $height = 160,
        public ?string $prefix = null,
        public ?string $suffix = null,
        public bool $sensitive = false,
    ) {
    }

    public function max(): float
    {
        $values = array_map(fn (array $d) => $d['value'], $this->series);

        return $values === [] ? 0.0 : (float) max($values);
    }

    public function percentFor(array $datum): float
    {
        $max = $this->max();

        return $max <= 0 ? 0.0 : round(($datum['value'] / $max) * 100, 2);
    }

    public function formatted(array $datum): string
    {
        $value = is_float($datum['value'])
            ? number_format($datum['value'], 2, ',', '.')
            : number_format($datum['value'], 0, ',', '.');

        return ($this->prefix ?? '').$value.($this->suffix ?? '');
    }

    public function render()
    {
        return view('frietzakje::components.bar-chart');
    }
}
