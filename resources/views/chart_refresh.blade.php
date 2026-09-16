@php /** @var \Fidum\ChartTile\Charts\Chart $chart */ @endphp

<div class="hidden" wire:poll.{{$refreshIntervalInSeconds}}s></div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('{{$eventName}}', ({0: newData}) => {
                var chartObj = window.{{$chart->id}};

                // The event dispatched during the initial Livewire mount replays at
                // livewire:initialized (DOMContentLoaded), but the chart global is only
                // assigned on window "load" — skip it; the initial chart script already
                // renders the same data. Later poll refreshes find the chart and update.
                if (!chartObj || !chartObj.data) return;

                chartObj.data.labels = newData.labels;
                chartObj.data.datasets = JSON.parse(newData.datasets);
                chartObj.options = newData.options;
                chartObj.update();
            });
        });
    </script>
@endpush
