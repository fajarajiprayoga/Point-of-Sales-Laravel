@extends('layouts.master')

@section('title')
Transaksi Penjualan
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
                </div>
                <div class="card-bodyb">
                    <form class="form-product">
                        @csrf
                        <div class="form-group row">
                            <label for="product_code" class="col-lg-2 ml-2 mt-2 ">Product Code</label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="hidden" name="id_selling" id="id_selling" value="{{$id_selling}}">
                                    {{-- <input type="text" value="{{$id_selling}}"> --}}
                                    <input type="hidden" name="id_product" id="id_product">
                                    <input type="hidden" name="product_code" id="product_code">

                                    <input type="text" class="form-control" name="product_code" , id="product_code">
                                    <span class="input-group-btn">
                                        <button onclick="tampil_product()" class="btn btn-info btn-flat"
                                            type="button"><i class="fa fa-arrow-right"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-selling">
                        <thead>
                            <th width=5%>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="10%">Jumlah</th>
                            <th>Subtotal</th>
                            <th width=9%><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="tampil-bayar bg-primary" id="tampil-bayar"></div>
                            <div class="tampil-kembali text-center bg-success"></div> 
                            <div class="tampil-terbilang">Seratus Ribu Rupiah</div>
                        </div>
                        <div class="col-lg-5">
                            <form action="{{route('transaction.newtransaction')}}" class="form form-penjualan" method="POST"> 
                                @csrf
                                <input type="hidden" name="id_selling" value="{{ $id_selling }}">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">


                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="totalrp" id="totalrp" class="form-control"
                                            value="{{"Rp. ".format_uang($total)}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Jumlah</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="total_count" id="total_count" class="form-control"
                                            value="{{$total_item}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="discount" class="col-lg-2 control-label">Disc (%)</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            value="0" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="discount" class="col-lg-2 control-label">Terima</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diterima" id="diterima" class="form-control"
                                            value="0">
                                    </div>
                                </div>
                                <a href="javascript:cekKembalian()" class="btn btn-sm btn-flat float-riht btn-success">Cek Kembalian</a>
                                <button class="btn btn-primary btn-sm btn-flat btn-simpan" type="submit">Simpan & Cetak Transaksi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('selling_detail.product')

@endsection

@push('scripts')
<script>
    let table;
    $(function() {
        table = $('.table-selling').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaction.data', $id_selling) }}'
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'product_code'},
                {data: 'product_name'},
                {data: 'sell_price'},
                {data: 'count'},
                {data: 'subtotal'},
                {data: 'action'}
            ]
        });

        gettotal();

        $(document).on('change', '.quantity', function() {
            let id = $(this).data('id')
            let count = parseInt($(this).val())
            
            $.post(`{{url('transaction/')}}/${id}`, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'put',
                'id': id,
                'count': count
            })
            .done(response => {
                table.ajax.reload()
            })
            .fail(errors => {
                return;
            })

            gettotal();
        })

    });

    function tampil_product() {
        $('#modal-product').modal('show');
    }

    function hide_product() {
        $('#modal-product').modal('hide');

    }

    function addProduct() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            url: '{{route('transaction.store')}}', 
            type: 'POST',
            data: $('.form-product').serialize()
        })
        .done((response) => {
            $('#product_code').focus();
            table.ajax.reload()
        })
        .fail((errors) => {
            alert('cannot add data');
            return;
        })

        gettotal()
    }

    function pilihProduct(id,code) {
        $('#id_product').val(id);
        $('#product_code').val(code);
        hide_product();
        addProduct();
    };

    function deleteData(url) { 
            if (confirm("Delete this data?")){
                $.ajaxSetup({
                headers: 
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {method: '_DELETE', submit: true}
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((erros) => {
                    alert('Cannot Delete Data');
                    return;
                });

                gettotal();
            }
           }  

    function gettotal() {
        $.get('{{route('transaction.gettotal', $id_selling)}}',
        function(data){
            $('.tampil-bayar').text("Rp. " + data.bayarrp)
            $('#totalrp').val(data['total']);
            $('#total_count').val(data['total_item']);
            $('#bayar').val(data['bayar']);
            $('#bayarrp').val(data['bayarrp']);
            $('.tampil-terbilang').text(data.terbilang);
            // $('#bayar').val(data['bayar']);
            $('#total').val(data['total']);
            $('#total_item').val(data['total_item']);
            $('#diterima').val(data['diterima']);
        });
    }

    function cekKembalian(){
        let total = $('#totalrp').val()
        let diterima = $('#diterima').val()
        let kembalian = diterima - total

        $('.tampil-bayar').text("Rp. " + kembalian)
        $('.tampil-kembali').text("Kembali")
        $('.tampil-terbilang').hide()
    }
    
</script>
@endpush
