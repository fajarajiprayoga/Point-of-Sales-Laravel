@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-info btn-sm btn-float" onclick="updatePeriode()"><i class="fa fa-plus-circle pr-1"></i>Ubah Periode</button>
                <a href="{{route('laporan.exportPDF', [$tanggalAwal, $tanggalAkhir])}}" target="_blank" class="btn btn-success btn-sm btn-float" onclick="updatePeriode()"><i class="fa fa-file-excel pr-1"></i>Cetak Laporam</a>

                <div class="form-group">

              </div>
              <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width='5%'>No</th>
                        <th width="18%">Tanggal</th>
                        <th>Penjualan</th>
                        <th>Pembelian</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    @include('laporan.form')

@endsection

@push('scripts')
    <script>
        let table;
        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{route('laporan.data', [$tanggalAwal, $tanggalAkhir])}}'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'tanggal'},
                    {data: 'penjualan'},
                    {data: 'pembelian'},
                    {data: 'pengeluaran'},
                    {data: 'pendapatan'}
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false,
            });

            //Date picker
            $('.datepicker').datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            $('#reservationdate2').datetimepicker({
                format: 'L'
            });
        })

        function updatePeriode(){
            $('#modal-form').modal('show');
        }

        
    </script>
@endpush