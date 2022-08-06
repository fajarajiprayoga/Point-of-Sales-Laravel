@extends('layouts.master')

@section('title')
    Supplier
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-success btn-sm btn-float" onclick="addForm('{{route('supplier.store')}}')"><i class="fa fa-plus-circle pr-1"></i>Tambah</button>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width='5%'>No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th width='15%'><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>  

    @include('supplier.form')
@endsection

@push('scripts')
    <script>
        let table;
        $(function(){
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('supplier.data')}}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'address'},
                    {data: 'telephone'},
                    {data: 'action', searchable: false, sortable:false}
                ]
            })

            $('#modal-form').on('submit', function(event){
                event.preventDefault()
                $.ajax({
                    type: "post",
                    url: $('#modal-form form').attr('action'),
                    data: $('#modal-form form').serialize(),
                    success: function (response) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    }
                });
                
            });

        });

        function addForm(url){
            $('#modal-form').modal('show');
            $('.modal-title').text('Tambah Supplier');

            $('#modal-form').attr('action', url)
        }

        function editForm(url){
            // console.log(url);
            $('#modal-form').modal('show');
            $('.modal-title').text('Edit Supplier');

            $('#modal-form form').attr('action', url);
            $('#modal-form form  [name=_method]').val('put')

            $.get(url)
            .done((response) => {
                $('#modal-form form [name=name]').val(response.name);
                $('#modal-form form [name=address]').val(response.address);
                $('#modal-form form [name=telephone]').val(response.telephone);
            })
            .fail((errors) => {
                alert('Cannot edit data');
                return;
            });
        }

        function deleteData(url){
            if(confirm('Delete this data?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {method: '_DELETE', submit: true}
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Cannot delete this data');
                    return;
                });
            }
        }
    </script>
@endpush