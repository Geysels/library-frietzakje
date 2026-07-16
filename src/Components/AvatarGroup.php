<?php

namespace Frietzakje\Ui\Components;

use Illuminate\View\Component;

class AvatarGroup extends Component
{
    /**
     * @param  array<int, array{name: string, src?: string|null}>  $users
     */
    public function __construct(
        public array $users = [],
        public int $max = 4,
        public string $size = 'sm',
    ) {
    }

    /** @return array<int, array{name: string, src?: string|null}> */
    public function visible(): array
    {
        return array_slice($this->users, 0, $this->max);
    }

    public function overflow(): int
    {
        return max(0, count($this->users) - $this->max);
    }

    public function render()
    {
        return view('frietzakje::components.avatar-group');
    }
}
