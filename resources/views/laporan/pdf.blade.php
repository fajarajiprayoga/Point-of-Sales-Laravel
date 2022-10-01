<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

    </style>
</head>

<body>
    <h1 class="text-center">Laporan Pendapatan</h1>
    <h4 class="text-center">
        Tanggal {{tanggal_indonesia($awal, false)}}
        s/d
        Tanggal {{tanggal_indonesia($akhir, false)}}
    </h4>

    <table class="table table-stripped">
        <thead>
            <tr>
                <th width=5%>No</th>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                @foreach ($row as $col)
                <td>{{$col}}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
