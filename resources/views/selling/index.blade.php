@extends('layouts.master')

@section('title')
Daftar Transaksi Penjualan
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
                    <div class="btn-group">
                        <a href="{{route('transaction.new')}}" class="btn btn-primary btn-sm btn-flat">Transaksi Baru</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <th width="5%">No.</th>
                            <th width="17%">Tanggal</th>
                            <th>Kode</th>
                            <th width="6%">Jumlah</th>
                            <th>Harga</th>
                            <th>Disc</th>
                            <th>Bayar</th>
                            <th>Diterima</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table

    $(function() {
        table = $('.table').DataTable({
            ajax: {
                url: '{{route('transactionlist.data')}}'
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'created_at'},
                {data: 'id_selling'},
                {data: 'item_total'},
                {data: 'price_total'},
                {data: 'discount'},
                {data: 'bayar'},
                {data: 'diterima'},
                {data: 'action'},
            ]
        })
    })

    function showDetail(){
        alert('Comming Soon!!!');
    }
</script>
@endpush
