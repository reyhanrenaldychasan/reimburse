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
                @if (($key + 1) % 2 == 0)
                    <div class="pagebreak"> </div>
                @endif
            @empty
            @endforelse
        </div>

        <div class="pagebreak"> </div>

        <div>Parkir</div>
        <div style="width: 740px">
            @forelse ($reimburses->parkings as $key => $item)
                @include('reimburse.parking', ['item' => $item])
                <br>
                @if (($key + 1) % 5 == 0)
                    <div class="pagebreak"> </div>
                @endif
            @empty
            @endforelse
        </div>

        <div class="pagebreak"> </div>

        <div>Makan Siang</div>
        @forelse ($reimburses->lunchs as $key => $item)
            @include('reimburse.gofood', ['item' => $item])
            <br>
            @if (($key + 1) % 2 == 0 && ($key + 1) != count($reimburses->lunchs))
                <div class="pagebreak"> </div>
            @endif
        @empty
        @endforelse

        <div class="pagebreak"></div>

        @if ($reimburses->dinners)
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
