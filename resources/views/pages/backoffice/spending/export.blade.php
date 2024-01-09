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
    <h1>{{$title}}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Mutasi</th>
                <th>Metode Pembayaran</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->spendingCategory->spending_category ?? '-' }}</td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->mutation ?? '-' }}</td>
                    <td>{{ $item->payment_method ?? '-' }}</td>
                    <td>{{ toThousand($item->nominal) ?? '0' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
