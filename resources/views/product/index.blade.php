@extends('layouts.master')

@section('title')
    Product
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Product</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="btn-group">
                    <button class="btn btn-success btn-sm btn-float" onclick="addForm('{{ route('product.store') }}')"><i class="fa fa-plus-circle pr-1"></i>Tambah</button>
                    <button class="btn btn-danger btn-sm btn-flat" onclick="deleteSelected('{{ route('product.deleteselected') }}')" ><i class="fa fa-trash"></i> Delete</button>
                    <button class="btn btn-warning btn-sm btn-flat" onclick="cetakBarcode('{{ route('product.cetakbarcode') }}')" ><i class="fa fa-print"></i> Cetak Barcode</button>
                </div>
              </div>
              <div class="card-body table-responsive">
                <form class="form-product" method="post">
                    @csrf
                    <table class="table table-striped table-bordered">
                    <thead>
                        <th width='5%'>No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Merk</th>
                        <th>Buy Price</th>
                        <th>Disc</th>
                        <th>Sell Price</th>
                        <th>Stock</th>
                        <th width="9%"><i class="fa fa-cog"></i></th>
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

    @includeIf('product.form')

@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                   url: '{{ route('product.data') }}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'product_code'},
                    {data: 'product_name'},
                    {data: 'category_name'},
                    {data: 'merk'},
                    {data: 'buy_price'},
                    {data: 'discount'},
                    {data: 'sell_price'},
                    {data: 'stock'},
                    {data: 'action', searchable: false, sortable: false}
                ]
            });

            $('#modal-form').validator().on('submit', function (e){
                if (! e.preventDefault()){
                    $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: "post",
                        data: $('#modal-form form').serialize()
                    })
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        return response;
                    })
                    .fail((errors) => {
                        alert('Cannot Save Data');
                        return;
                    });
                }
            });

            $('#select_all').on('click', function(){
                $(':checkbox').prop('checked', this.checked);
            });
        });

        function addForm(url){
                $('#modal-form').modal('show');
                $('.modal-title').text('Add Product');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url)
            }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('.modal-title').text('Edit Product');

            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');

            $.get(url)
            .done((response) => {
                $('#modal-form [name=product_name]').val(response.product_name);
                $('#modal-form [name=id_category]').val(response.id_category);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=buy_price]').val(response.buy_price);
                $('#modal-form [name=discount]').val(response.discount);
                $('#modal-form [name=sell_price]').val(response.sell_price);
                $('#modal-form [name=stock]').val(response.stock);
            })
            .fail((erros) => {
                alert('Cannot display data');
                return;
            })
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
                })
            }
           }
    </script>
@endpush