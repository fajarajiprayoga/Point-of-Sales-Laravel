@extends('layouts.master')

@section('title')
    Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengeluaran</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                {{-- <button class="btn btn-success btn-sm btn-float" onclick="addForm({{ route('category.store') }})"><i class="fa fa-plus-circle pr-1"></i>Tambah</button> --}}
                <button class="btn btn-success btn-sm btn-float" onclick="addForm('{{route('pengeluaran.store')}}')"><i class="fa fa-plus-circle pr-1"></i>Tambah</button>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width='5%'>No</th>
                        <th>Description</th>
                        <th>Nominal</th>
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
    
    @include('pengeluaran.form')

@endsection

@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('pengeluaran.data')}}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'description'},
                    {data: 'nominal'},
                    {data: 'action'}
                ]
            });

            $('#modal-form').on('submit', function(event){
                event.preventDefault();
                
                $.ajax({
                    type: 'post',
                    url: $('#modal-form form').attr('action'),
                    data: $('#modal-form form').serialize()
                })
                .done((response) => {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();
                })
            })
        })

        function addForm(url){
            $('#modal-form').modal('show');
            $('.modal-title').text('Tambah Pengeluaran');

            $('#modal-form form').attr('action', url);
            $('#modal-form form [name=description]').val('');
            $('#modal-form form [name=nominal]').val('');
        }

        function editForm(url) { 
            $('#modal-form').modal('show');

            $('#modal-form form').attr('action', url);
            $('#modal-form form [name=_method]').val('put');

            $.get(url)
            .done((response) => {
                $('#modal-form form [name=description]').val(response.description);
                $('#modal-form form [name=nominal]').val(response.nominal);
            })
            .fail((errors) => {
                alert('Data is null');
                return;
            })
         }

         function deleteData(url){
            if(confirm("Delete this data?")){
                $.ajaxSetup({
                    headers: {
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
                    alert('Cannot delete data');
                    return;
                });
            }
         }
    </script>
@endpush