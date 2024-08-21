<div class="struk struk-bensin p-2" style="background-color: #f4f4f4">
    <div>
        <span style="font-size: 30px;">SPBU 34-12302</span><br>
        <span class="fs-23">JLN. SULTAN ISKANDAR MUDA</span>
    </div>
    <br>
    <div class="row arial fs-23">
        <div class="col">{{ $item->dateDesc }}</div>
        <div class="col text-end">{{ $item->time }}</div>
    </div>
    <div class="arial fs-23 mt-min-8">
        Receipt No. : {{ $item->no }} [copy]
    </div>
    <br>
    <div class="fs-23">
        <div class="row">
            <div class="col">Pump No.</div>
            <div class="col text-end">9</div>
        </div>
        <div class="row mt-min-8">
            <div class="col">Grade</div>
            <div class="col text-end">PERTAMAX</div>
        </div>
        <div class="row mt-min-8">
            <div class="col">Volume (L)</div>
            <div class="col text-end arial">{{ number_format($item->amount / $item->costPerLiter, 2) }}</div>
        </div>
        <div class="row mt-min-8">
            <div class="col">Unit Price(Rp./L)</div>
            <div class="col text-end arial">{{ $item->costPerLiter }}</div>
        </div>
        <div class="row mt-min-8">
            <div class="col">Amount(Rp.)</div>
            <div class="col text-end arial">{{ $item->amount }}</div>
        </div>
    </div>
    <br>
    <div class="fs-23">TERIMA KASIH & SELAMAT JALAN</div>
</div>