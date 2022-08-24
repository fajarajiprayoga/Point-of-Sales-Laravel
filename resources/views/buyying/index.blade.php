@extends('layouts.master')

@section('title')
    Pembelian
@endsection

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
                            <button class="btn btn-success btn-sm 
                            btn-flat" onclick="addForm()"><i class="fa fa-plus-circle pr-1"></i>New Transaction</button>
                            @empty(! session('id_buyying'))
                                <a href="{{route('buyying_detail.index')}}" class="btn btn-info btn-sm 
                            btn-flat"><i class="fa fa-edit pr-1"></i>Active Transaction</a>
                            @endempty
                            <a href="{{route('buyying.showdata')}}" class="btn btn-danger btn-flat">Data</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <form class="form-member" method="post">
                            @csrf
                            <table class="table table-striped table-bordered table-pembelian">
                                <thead>
                                    <th width=5%>No</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Discount</th>
                                    <th>Total Bayar</th>
                                    <th width=9%><i class="fa fa-cog"></i></th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('buyying.supplier')
@endsection

@push('scripts')
    <script>
    let table;
        $(function() {
            table = $('.table-pembelian').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('buyying.showdata')}}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'created_at'},
                    {data: 'name'},
                    {data: 'item_total'},
                    {data: 'price_total'},
                    {data: 'discount'},
                    {data: 'bayar'},
                    {data: 'action'},
                ]
            });
            
            $('.table-supplier').DataTable();
        });

        function addForm(){
            $('#modal-supplier').modal('show');
        }

        function detail(url){
            window.location.href = url;
        }
    </script>    
@endpush

