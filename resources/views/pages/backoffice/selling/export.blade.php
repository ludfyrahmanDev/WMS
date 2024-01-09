<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<style>
    table{
        widows: 100%;
        width: 100%;
        border-collapse: collapse;
    }
    table thead tr th{
        background-color: #46ce5f;
        color: #000;
        padding: 5px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    
    }
    .text-right{
        text-align: right;
    
    }
</style>
<body>
    <h1>{{$title}}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th><th>Customer</th><th>Supir</th><th>Metode Pembayaran</th><th>Tipe Pembayaran</th>
                
                <th rowspan="2">Nama Barang</th><th rowspan="2">Jumlah</th><th rowspan="2">Harga</th><th rowspan="2">Subtotal</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{$item->created_at->format('Y/m/d')}}</td>
                    <td>{{$item->customer->name ?? '-'}}</td>
                    <td>{{$item->driver->name ?? '-'}}</td>
                    <td>{{$item->purchasing_method == 'kontan' ? 'Kontan' : ($item->purchasing_method == 'titipan' ? 'Titipan' : 'Tempo') ?? '-'}}</td>
                    <td>{{$item->payment_type == 'cash' ? 'Cash' : 'Transfer'}}</td>
                    <td rowspan="{{$item->selling_detail->count() + 1}}" data-format="#,##0.00">{{$item->grand_total ?? 0}}</td>
                </tr>
                @foreach ($item->selling_detail as $detail)
                    <tr>
                        <td colspan="5"></td>
                        <td>{{$detail->stock->product->product ?? '-'}}</td>
                        <td>{{ $detail->qty }}</td>
                        <td class="text-right" data-format="#,##0.00">{{ $detail->price_sell }}</td>
                        <td class="text-right" data-format="#,##0.00">{{ $detail->subtotal }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>