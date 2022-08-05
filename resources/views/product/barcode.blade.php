<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>
</head>
<body>
    <table width="100%" style="text-align: center">
        <tr>
            @foreach ($dataproduct as $key => $product)
                <td style="border: 1px solid">
                    <p>{{ $product->product_name }} - Rp. {{ format_uang($product->sell_price) }}</p>
                    <img src="data:image/png;base64,{{ DNS1D::getBarCodePNG($product->product_code, "C39") }}" alt="{{$product->product_code}}" width="180" height="60">
                    <br>
                    <p>{{ $product->product_code }} </p>
                </td>
                @if ($no++ % 3 == 0)
                    </tr><tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>