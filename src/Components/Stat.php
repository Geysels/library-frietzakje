<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class Stat extends Component
{
    public function __construct(
        public string $label,
        public ?string $value = null,
        public ?string $icon = null,
        public string $variant = 'neutral',
        public ?string $trend = null,
        public string $trendDirection = 'flat',
        public ?string $caption = null,
        public ?string $href = null,
        public bool $sensitive = false,
    ) {
    }

    /**
     * Trend colour follows the direction, not the variant: a rising number is not
     * automatically good news, so callers pass the direction they mean.
     */
    public function trendVariant(): string
    {
        return match ($this->trendDirection) {
            'up' => 'success',
            'down' => 'danger',
            default => 'neutral',
        };
    }

    public function trendIcon(): string
    {
        return match ($this->trendDirection) {
            'up' => 'trending_up',
            'down' => 'trending_down',
            default => 'trending_flat',
        };
    }

    public function render()
    {
        return view('frietzakje::components.stat');
    }
}
