@extends('layouts.master')

@section('title')
    Member
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Member</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm 
                            btn-flat" onclick="addForm()"><i class="fa fa-plus-circle pr-1"></i>Tambah</button>
                            <button class="btn btn-danger btn-sm btn-flat" onclick="deleteSelected('{{ route('member.deleteselected') }}')" ><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <form class="form-member" method="post">
                            @csrf
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th width=5%>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Telephone</th>
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
    @include('member.form')
@endsection

@push('scripts')
    <script>
    let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('member.data') }}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'member_code'},
                    {data: 'name'},
                    {data: 'address'},
                    {data: 'telephone'},
                    {data: 'action', searchable: false, sortable: false}
                ]
            })
            
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
        });

        function addForm(){
            var url = '{{route('member.store')}}'
            $('#modal-form').modal('show');
            $('.modal-title').text('Add Member');
            $('#modal-form').attr('action', url);
            $('#modal-form')[0].reset();
        };
        
        function editForm(url){
            $('#modal-form').modal('show');
            $('.modal-title').val('Edit Member');
            
            $('#modal-form form').attr('action', url);
            $('#modal-form form  [name=_method]').val('put')

            $.get(url)
            .done((response) => {
                $('#modal-form form [name=name]').val(response.name);
                $('#modal-form form [name=address]').val(response.address);
                $('#modal-form form [name=telephone]').val(response.telephone);
            })
            .fail((errors) => {
                alert('Cannot Show Data');
                return;
            });
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

