@extends('layouts.master')

@section('title')
Status Transaksi
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }

</style>

@endpush

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="alert alert-success alert-dismissible">
                        <i class="fa fa-check icon"></i>
                        Transaksi Berhasil
                    </div>
                </div>
                <div class="card-body">
                    <button onclick="cetakNota('{{route('transaction.cetakNota')}}', 'Nota PDF')"
                        class="btn btn-warning btn-flat text-white">Cetak Nota</button>
                    <a href="{{route('transaction.new')}}" class="btn btn-flat btn-primary">Transaksi Baru</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function cetakNota(url, title) {
        popupCenter(url, title, 720, 675);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? documennt
            .documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? documennt
            .documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft;
        const top = (height - h) / 2 / systemZoom + dualScreenTop;
        const newWindow = window.open(url, title,
            `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      `
        )

        if (window.focus) newWindow.focus();
    }

</script>
@endpush
