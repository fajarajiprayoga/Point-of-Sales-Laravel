<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>
    <style>
        * {
            font-family: 'consolas', sans-serif
        }

        p {
            display: block;
            margin: 3;
            font-size: 10pt;
        }

        table td {
            font-size: 9pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm;
            }
        }

        .btn-print {
            /* display: none; */
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3>{{ strtoupper($setting->company_name) }}</h3>
        <p>{{ strtoupper($setting->address) }}</p>
    </div>
    <br>
    <div>
        <p style="float:left;">{{ date('d-m-Y') }}</p>
        <p style="float: right;">{{ strtoupper(auth()->user()->name) }} </p>
    </div>
    <div class="clear-bot" style="clear: both"></div>
    <p>No: {{tambah_nol_didepan($selling->id_selling, 6)}}</p>
    <p class="text-center">=============================</p>

    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->product->product_name }}</td>
            </tr>
            <tr>
                <td>{{$item->count}} x {{format_uang($item->sell_price)}}</td>  
                <td></td>
                <td class="text-right">{{ format_uang($item->count * $item->sell_price) }}</td> 
            </tr>
        @endforeach
    </table>
    <p class="text-center">=============================</p>

    <table width="100%" style="border: 0">
    <tr>
        <td>Total Harga:</td>
        <td class="text-right">{{format_uang($selling->price_total)}}</td>
    </tr>
    <tr>
        <td>Total Item:</td>
        <td class="text-right">{{$selling->item_total}}</td>
    </tr>
    <tr>
        <td>Discount:</td>
        <td class="text-right">{{$selling->discount}}%</td>
    </tr>
    <tr>
        <td>Diterima:</td>
        <td class="text-right">{{format_uang($selling->diterima)}}</td>
    </tr>
    <tr>
        <td>Kembali:</td>
        <td class="text-right">{{format_uang(($selling->diterima - $selling->price_total))}}</td>
    </tr>
    </table>

    <p class="text-center">=============================</p>

    <p class="text-center">-- TERIMA KASIH --</p>
</body>
</html>

<script>
    
</script>