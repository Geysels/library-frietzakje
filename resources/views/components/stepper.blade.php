@php
    $total = count($steps);
@endphp

@if ($orientation === 'vertical')
    <ol {{ $attributes->class('space-y-1') }}>
        @foreach ($steps as $i => $step)
            @php
                $number = $i + 1;
                $done = $number < $current;
                $active = $number === $current;
            @endphp

            <li class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div @class([
                        'grid size-9 flex-shrink-0 place-items-center rounded-full border-2 font-display text-sm font-bold transition-colors duration-150',
                        'border-success bg-success text-bg' => $done,
                        'border-primary bg-primary text-bg' => $active,
                        'border-secondary text-text/40' => ! $done && ! $active,
                    ])>
                        @if ($done)
                            <x-frietzakje-icon name="check" class="text-lg" />
                        @else
                            {{ $number }}
                        @endif
                    </div>

                    @if (! $loop->last)
                        <div @class([
                            'my-1 w-0.5 flex-1',
                            'bg-success' => $done,
                            'bg-secondary' => ! $done,
                        ])></div>
                    @endif
                </div>

                <div class="{{ $loop->last ? 'pb-0' : 'pb-6' }} pt-1.5">
                    <p @class([
                        'font-display font-semibold',
                        'text-primary' => $active,
                        'text-text/50' => ! $active && ! $done,
                    ])>{{ $step['label'] }}</p>

                    @if (! empty($step['description']))
                        <p class="text-sm text-text/60">{{ $step['description'] }}</p>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
@else
    <ol {{ $attributes->class('flex items-center gap-2') }}>
        @foreach ($steps as $i => $step)
            @php
                $number = $i + 1;
                $done = $number < $current;
                $active = $number === $current;
            @endphp

            <li @class(['flex items-center gap-3', 'flex-1' => ! $loop->last])>
                <div class="flex items-center gap-3">
                    <div @class([
                        'grid size-9 flex-shrink-0 place-items-center rounded-full border-2 font-display text-sm font-bold transition-colors duration-150',
                        'border-success bg-success text-bg' => $done,
                        'border-primary bg-primary text-bg' => $active,
                        'border-secondary text-text/40' => ! $done && ! $active,
                    ])>
                        @if ($done)
                            <x-frietzakje-icon name="check" class="text-lg" />
                        @else
                            {{ $number }}
                        @endif
                    </div>

                    {{-- Labels would wrap the row on small screens, so only the active step keeps
                         its label there; the rest are dots until there is room. --}}
                    <div @class([
                        'min-w-0',
                        'hidden sm:block' => ! $active,
                    ])>
                        <p @class([
                            'whitespace-nowrap font-display text-sm font-semibold',
                            'text-primary' => $active,
                            'text-text' => $done,
                            'text-text/50' => ! $active && ! $done,
                        ])>{{ $step['label'] }}</p>
                    </div>
                </div>

                @if (! $loop->last)
                    <div @class([
                        'h-0.5 flex-1',
                        'bg-success' => $done,
                        'bg-secondary' => ! $done,
                    ])></div>
                @endif
            </li>
        @endforeach
    </ol>
@endif
