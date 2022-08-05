@extends('layouts.master')

@section('title')
    Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                {{-- <button class="btn btn-success btn-sm btn-float" onclick="addForm({{ route('category.store') }})"><i class="fa fa-plus-circle pr-1"></i>Tambah</button> --}}
                <button class="btn btn-success btn-sm btn-float" onclick="addForm('{{route('category.store')}}')"><i class="fa fa-plus-circle pr-1"></i>Tambah</button>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width='5%'>No</th>
                        <th>Category</th>
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

    @includeIf('category.form')

@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{route('category.data')}}'
            },
            columns: [
                {data: "id_category"},
                {data: "category_name"},
                {data: "action", searchable: false, sortable: false}
            ]
            })

            $('#modal-form').validator().on('submit', function (e){
                if (! e.preventDefault()){
                    $.ajax({
                        url: $('#modal-form form').attr('action'),
                        type: "post",
                        data: $('#modal-form form').serialize()
                    })
                    .done((response, data) => {
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
        });

        function addForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Add Category");

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url)
            // $('#modal-form [name=_method]').val('post');
            // $('#modal-form [name=category_name]').focus();
        }

        function editForm(url){
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text("Edit Category");

            // $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('put');
            // $('#modal-form [name=category_name]').focus();

            $.get(url)
            .done((response) => {
                $('#modal-form [name=category_name]').val(response.category_name);
            })
            .fail((errors) => {
                alert('Cannot display data');
                return;
            })
        }

        function deleteData(url){
            if (confirm('Delete this data?')){
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
            .fail((errors) => {
                alert('Cannot Delete Data');
                return;
            })
            }
        }
        
    </script>
@endpush