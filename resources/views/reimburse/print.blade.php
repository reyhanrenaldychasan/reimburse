@extends('layouts.print')

@push('css-scripts')
    <style>
        .parkir-img {
            width: 130px;
        }

        .makan-img {
            width: 70px;
        }

        .lunch-border {
            border-bottom: 1px dashed #e4e4e4;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .logo-goride {
            width: 100px;
        }

        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
@endpush

@section('content')
    <div>
        <div>Transport</div>
        <div style="width: 840px">
            @forelse ($reimburses->transports as $key => $item)
                @include('reimburse.transport', ['item' => $item])
                <br>
                <br>
                <br>
                {{-- page break every 2 --}}
                @if (($key + 1) % 2 == 0)
                    <div class="pagebreak"></div>
                @endif
                {{-- page break if key is odd and last --}}
                @if (($key + 1) == count($reimburses->transports) && ($key + 1) % 2 != 0)
                    <div class="pagebreak"></div>
                @endif
            @empty
            @endforelse
        </div>

        <div>Parkir</div>
        <div style="width: 740px">
            @forelse ($reimburses->parkings as $key => $item)
                @include('reimburse.parking', ['item' => $item])
                <br>
                {{-- page break every 10 --}}
                @if (($key + 1) % 10 == 0)
                    <div class="pagebreak"> </div>
                @endif
                {{-- page break if key is not every 10 and last --}}
                @if (($key + 1) == count($reimburses->parkings) && ($key + 1) % 10 != 0)
                    <div class="pagebreak"></div>
                @endif
            @empty
            @endforelse
        </div>

        <div>Makan Siang</div>
        @forelse ($reimburses->lunchs as $key => $item)
            @include('reimburse.gofood', ['item' => $item])
            <br>
            {{-- page break every 2 --}}
            @if (($key + 1) % 2 == 0)
                <div class="pagebreak"> </div>
            @endif
            {{-- page break if key is odd and last --}}
            @if (($key + 1) == count($reimburses->lunchs) && ($key + 1) % 2 != 0)
            <div class="pagebreak"></div>
        @endif
        @empty
        @endforelse

        @if ($reimburses->dinners->isNotEmpty())
            <div>Makan Lembur</div>
            @forelse ($reimburses->dinners as $key => $item)
                @include('reimburse.gofood', ['item' => $item])
                <br>
                @if (($key + 1) % 2 == 0)
                    <div class="pagebreak"> </div>
                @endif
            @empty
            @endforelse
        @endif
    </div>
@endsection

@push('js-scripts')
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
@endpush
