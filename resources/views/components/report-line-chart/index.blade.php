@props(['width' => 'w-auto', 'height' => 'h-auto','data' => [
        'label' => [],
        'value' => []
        ],
        'name' => 'Grafik Penjualan',
])

<div class="{{ $width }} {{ $height }}">
    <x-base.chart
        id="report-line-chart"
        {{ $attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
    >
    </x-base.chart>
</div>

@once
    @push('scripts')
        <script>
            var labels = '{!! json_encode($data['label']) !!}';
            var values = '{!! json_encode($data['value']) !!}';
            label = JSON.parse(labels);
            value = JSON.parse(values);
            var nameChart = '{{$name}}';
        </script>
        @vite('resources/js/components/report-line-chart/index.js')
    @endpush
@endonce
