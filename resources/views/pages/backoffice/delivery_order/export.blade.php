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
    table thead th{
        background-color: #46ce5f;
        color: #000;
        padding: 5px;
        text-align: center;
    
    }
</style>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th><th>DO/Harga</th><th>Tgl pengambilan DO</th><th>NOPOL</th><th>Driver</th><th>Penerima</th><th>Berat (kg)</th><th>Sisa DO (kg)</th><th>Harga DO</th><th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{$item->created_at->format('Y/m/d')}}</td>
                    <td>{{$item->pick_up_date ?? '-'}}</td>
                    <td>{{$item->purchase_date ?? '-'}}</td>
                    <td>{{$item->vehicle->license_plate ?? '-'}}</td>
                    <td>{{$item->driver->name ?? '-'}}</td>
                    <td>{{$item->who_create ?? '-'}}</td>
                    <td>{{$item->delivery_order_detail->sum('purchase_amount') ?? '-'}}</td>
                    <td>{{$item->delivery_order_detail->sum('last_stock') ?? '-'}}</td>
                    <td>{{toThousand($item->delivery_order_detail->avg('price_kg') ?? '0')}}</td>
                    <td>{{toThousand($item->grand_total)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>