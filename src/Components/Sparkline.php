<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Sparkline extends Component
{
    /**
     * @param  array<int, int|float>  $series
     */
    public function __construct(
        public array $series = [],
        public string $variant = 'primary',
        public int $height = 40,
        public int $width = 120,
        public bool $area = true,
    ) {
    }

    /**
     * Map the series onto the viewBox. A flat series has no range to normalise against,
     * so it is pinned to the middle instead of dividing by zero.
     *
     * @return array<int, array{0: float, 1: float}>
     */
    public function points(): array
    {
        $count = count($this->series);

        if ($count === 0) {
            return [];
        }

        if ($count === 1) {
            return [[0.0, $this->height / 2]];
        }

        $min = min($this->series);
        $max = max($this->series);
        $range = $max - $min;

        $points = [];

        foreach (array_values($this->series) as $i => $value) {
            $x = ($i / ($count - 1)) * $this->width;
            $y = $range == 0
                ? $this->height / 2
                : $this->height - (($value - $min) / $range) * $this->height;

            $points[] = [round($x, 2), round($y, 2)];
        }

        return $points;
    }

    public function polyline(): string
    {
        return implode(' ', array_map(fn (array $p) => $p[0].','.$p[1], $this->points()));
    }

    public function areaPath(): string
    {
        $points = $this->points();

        if ($points === []) {
            return '';
        }

        $first = $points[0];
        $last = $points[count($points) - 1];

        return 'M '.$first[0].','.$this->height
            .' L '.implode(' L ', array_map(fn (array $p) => $p[0].','.$p[1], $points))
            .' L '.$last[0].','.$this->height.' Z';
    }

    public function render()
    {
        return view('frietzakje::components.sparkline');
    }
}
