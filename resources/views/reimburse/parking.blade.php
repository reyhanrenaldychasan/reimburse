<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-sm-2 text-center">
                <div style="font-size: 28px; font-weight: 700; color: #212121">{{ date_create_from_format("Y-m-d", $item->date)->format('d') }}</div>
                <div style="font-size: 18px; font-weight: 500; color: #212121">{{ date_create_from_format("Y-m-d", $item->date)->format('M') }}</div>
                <div style="font-size: 16px; color: #212121">{{ date_create_from_format("Y-m-d", $item->date)->format('Y') }}</div>
            </div>
            <div class="col">
                <div style="font-size: 20px; font-weight: 700; margin-top: 2px; margin-bottom: 4px; color: #055298">Parkir
                </div>
                <div style="font-size: 18px; font-weight: 600; margin-bottom: 5px; color: #c85b60">IDR {{ number_format($item->amount, 2) }}</div>
                <div style="font-size 16px; color: #232323">{{ $item->endTime }}</div>
            </div>
        </div>
    </div>
</div>
