@php
    $size = $getSize() ?? 'lg';
    $ring = $getRing() ?? 3;

    $imageClasses = \Illuminate\Support\Arr::toCssClasses([
        match ($ring) {
            0 => 'ring-0',
            1 => 'ring-1',
            2 => 'ring-2',
            4 => 'ring-4',
            5 => 'ring-5',
            default => 'ring',
        },
        match ($size) {
            'xs' => 'h-4 w-4',
            'sm' => 'h-5 w-5',
            'md' => 'h-6 w-6',
            'lg' => 'h-7 w-7',
            'xl' => 'h-8 w-8',
            '2xl' => 'h-10 w-10',
            '3xl' => 'h-12 w-12',
            default => null,
        },
    ]);
    
    $imageCount = 0;
@endphp

<div {{ $attributes->merge($getExtraAttributes())->class([
    'filament-tables-avatar-group-column',
    'px-4 py-3' => ! $isInline(),
]) }}>
    <div 
    
    class="flex items-center space-x-2">
        <div @class([
            'flex',
            match ($getOverlap()) {
                'sm' => '-space-x-1',
                'md' => '-space-x-2',
                'lg' => '-space-x-3',
                'xl' => '-space-x-4',
                default => '-space-x-1',
            },
        ])>
            @foreach (array_slice($getImages(), 0, $getLimit()) as $image)
                @if ($path = $getImagePath($image))
                    @php
                        $imageCount ++;
                    @endphp
                    <img
                        src="{{ $path }}"
                        {{ $getExtraImgAttributeBag()->class([
                            'max-w-none rounded-full ring-white rounded-full dark:ring-gray-800',
                            $imageClasses => $imageClasses,
                        ]) }}
                    >
                @endif
            @endforeach

            @if ($shouldShowRemaining() && ! $shouldShowRemainingAsText() && ($imageCount < count($getImages())))
                <div @class([
                    'flex items-center justify-center bg-gray-100 text-gray-500 ring-white rounded-full dark:bg-gray-600 dark:text-gray-300 dark:ring-gray-800',
                    $imageClasses => $imageClasses,
                    match ($getRemainingTextSize()) {
                        'xs' => 'text-xs',
                        'sm' => 'text-sm',
                        'md' => 'text-md',
                        'lg' => 'text-lg',
                        default => 'text-sm',
                    },
                ])>
                    <span class="-ml-1">
                        +{{ count($getImages()) - $imageCount }}
                    </span>
                </div>
            @endif

        </div>

        @if ($shouldShowRemaining() && $shouldShowRemainingAsText() && ($imageCount < count($getImages())))
            <div @class([
                'text-gray-500 dark:text-gray-300',
                match ($getRemainingTextSize()) {
                    'xs' => 'text-xs',
                    'sm' => 'text-sm',
                    'md' => 'text-md',
                    'lg' => 'text-lg',
                    default => 'text-sm',
                },
            ])>
                +{{ count($getImages()) - $imageCount }}
            </div>
        @endif
    </div>
</div>