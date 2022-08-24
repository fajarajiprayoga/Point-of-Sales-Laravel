@extends('layouts.master')

@section('title')
    Transaksi Pembelian
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
    <li class="breadcrumb-item active">Pembelian</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group">
                            {{-- <button class="btn btn-success btn-sm 
                            btn-flat" onclick="addForm()"><i class="fa fa-plus-circle pr-1"></i>New Transaction</button> --}}
                            <table>
                                <tr>
                                    <td>Supplier</td>
                                    <td>: {{ $suppliers->name }}</td>
                                </tr>
                                <tr>
                                    <td>Telephone</td>
                                    <td>: {{$suppliers->telephone}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{$suppliers->address}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-bodyb">
                        
                            <form class="form-product">
                                @csrf
                                <div class="form-group row">
                                <label for="product_code" class="col-lg-2">Product Code</label>
                                <div class="col-lg-5">
                                    <div class="input-group">
                                        <input type="hidden" name="id_buyying" id="id_buyying" value="{{$id_buyying}}">
                                        <input type="hidden" name="id_product" id="id_product">
                                        <input type="hidden" name="product_code" id="product_code">

                                        <input type="text" class="form-control" name="product_code", id="product_code">
                                        <span class="input-group-btn">
                                            <button onclick="tampil_product()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </form>

                            <table class="table table-striped table-bordered table-buyying">
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
                                <div class="col-lg-8">
                                    <div class="tampil-bayar bg-primary"></div>
                                    <div class="tampil-terbilang">Seratus Ribu Rupiah</div>
                                </div>
                                <div class="col-lg-4">
                                    <form action="{{route('buyying.store')}}" class="form-pembelian" method="post">
                                        @csrf
                                        <input type="hidden" name="id_buyying" value="{{ $id_buyying }}">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">

                                        <div class="form-group row">
                                            <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="totalrp" id="totalrp" class="form-control" value="{{"Rp. ".format_uang($total)}}" readonly>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <label for="discount" class="col-lg-2 control-label">Disc (%)</label>
                                            <div class="col-lg-8">
                                                <input type="number" name="discount" id="discount" class="form-control" value="0" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="tes" class="col-lg-2 control-label">Bayar</label>
                                            <div class="col-lg-8">
                                                <input type="text" name="bayarrp" id="bayarrp" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat float-right btn-simpan"><i class="fa fa-floopy-o">Simpan Transaksi</i></button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('buyying_detail.product')
@endsection

@push('scripts')
    <script>
    let table, table2;
        $(function() {
            table = $('.table-buyying').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('buyying_detail.data', $id_buyying)}}'
                },
                columns: [
                    {data: "DT_RowIndex"},
                    {data: "product_code"},
                    {data: "product_name"},
                    {data: "buy_price"},
                    {data: "count"},
                    {data: "subtotal"},
                    {data: "action", searchable: false, sortable: false}
                ],
                dom: 'Brt',
                bSort: false,
            })
            .on('draw.dt', function () {
            })

            table2 = $('.table-product').DataTable()

            $(document).on('input', '.quantity', function(){
                let id = $(this).data('id');
                let count = parseInt($(this).val());

                $.post(`{{url('buyying_detail/')}}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'count': count
                })
                .done(response => {
                    table.ajax.reload();
                })
                .fail(errors => {
                    // alert('Cannot update data');
                    return;
                })

                getTotal();
            });

            getTotal();

            $('.btn-simpan').on('click', function(){
                $('.form-pembelian').submit();
            });
        });

        function tampil_product(){
            $('#modal-product').modal('show');

        }

        function hide_product(){
            $('#modal-product').modal('hide');

        }

        function addProduct(){
            $.post('{{route('buyying_detail.store')}}', $('.form-product').serialize())
            .done((response) => {
                $('#product_code').focus();
                table.ajax.reload();
            })
            .fail((errors) => {
                alert('Cannot add data');
                return;
            });

            getTotal();
        } 

        function pilihProduct(id, kode){
            $('#id_product').val(id);
            $('#product_code').val(kode);
            hide_product();
            addProduct();
        }

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

                getTotal();
            }
           }       
           
        function getTotal() { 
            $.get('{{route('buyying_detail.gettotal', $id_buyying)}}', function(data,status){
                    $('#total').val(data['total']);
                    $('#total_item').val(data['total_item']);
                    $('#bayar').val(data['bayar']);
                    $('#totalrp').val("Rp. "+data['totalrp']);
                    $('#discount').val(data['discount']);
                    $('#bayarrp').val(data['bayarrp']);
                    $('.tampil-bayar').text("Rp. "+data['totalrp']);
                    $('.tampil-terbilang').text("Rp. "+data['terbilang']);
                });
         }
    </script>    
@endpush

