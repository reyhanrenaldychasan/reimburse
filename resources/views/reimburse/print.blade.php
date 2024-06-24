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
        <div>Gojek</div>
        <div style="width: 840px">
            @forelse ($gorides as $key => $item)
                @include('reimburse.gojek', ['item' => $item])
                <br>
                @if (($key + 1) % 3 == 0)
                    <div class="pagebreak"> </div>
                @endif
            @empty
            @endforelse
        </div>

        <div class="pagebreak"> </div>

        <div>MRT</div>
        <div style="width: 740px">
            @forelse ($mrts as $key => $item)
                @include('reimburse.mrt', ['item' => $item])
                <br>
                @if (($key + 1) % 9 == 0)
                    <div class="pagebreak"> </div>
                @endif
            @empty
            @endforelse
        </div>

        <div class="pagebreak"> </div>

        <div>Makan Siang</div>
        @forelse ($lunchs as $key => $item)
            @include('reimburse.lunch', ['item' => $item])
            <br>
            @if (($key + 1) % 2 == 0 && ($key + 1) != count($lunchs))
                <div class="pagebreak"> </div>
            @endif
        @empty
        @endforelse

        <div class="pagebreak"></div>

        @if ($dinners)
            <div>Makan Lembur</div>
            @forelse ($dinners as $key => $item)
                @include('reimburse.dinner', ['item' => $item])
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
