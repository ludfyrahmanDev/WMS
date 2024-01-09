<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<style>
    table {
        widows: 100%;
        width: 100%;
        border-collapse: collapse;
    }

    table thead th {
        background-color: #46ce5f;
        color: #000;
        padding: 5px;
        text-align: center;

    }
</style>

<body>
    <h1>{{ $title }}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Harga/Kg</th>
                <th>Stok Awal</th>
                <th>Stok Pakai</th>
                <th>Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->purchase_date }}</td>
                    <td>{{ $item->product->product ?? '-' }}</td>
                    <td>{{ toThousand($item->price_kg) ?? '0' }}</td>
                    <td>{{ $item->first_stock ?? '0' }}</td>
                    <td>{{ $item->stock_in_use ?? '0' }}</td>
                    <td>{{ $item->last_stock ?? '0' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
