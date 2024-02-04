<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Courier New'
        }

        td {
            font-size: 14px;
        }

        .hr1 {
            border: 2px dashed black;
        }

        table thead tr th {
        background-color: #46ce5f;
        color: #000;
        padding: 5px;
        text-align: center;

    }
    </style>
</head>

<body>

    <div class="mt-4">
        <div class="row">
            <h3 class="text-center fw-bold">{{ $title }}</h3>
            <hr class="hr1 mt-2">
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tanggal Pengambilan DO</th>
                            <th scope="col">Tipe Transaksi</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Nopol</th>
                            <th scope="col">Driver</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Harga/Kg</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Grand Total</th>
                            <th scope="col">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @foreach ($item->delivery_order_detail as $key => $childItem)
                                <tr class="text-center">
                                    @if ($key == 0)
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ date('d-m-Y', strtotime($item->purchase_date)) }}
                                        </td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">{{ $item->pick_up_date }}
                                        </td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ $item->transaction_type }}</td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ $item->supplier->name }}</td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ $item->vehicle->license_plate }}</td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ $item->driver->name }}</td>
                                    @endif

                                    <td>{{ $childItem->stock->product->product ?? '-' }}</td>
                                    <td>{{ $childItem->purchase_amount ?? '0' }}</td>
                                    <td>{{ toThousand($childItem->stock->price_kg ?? '0') }}</td>
                                    <td>{{ toThousand($childItem->subtotal ?? '0') }}</td>

                                    @if ($key == 0)
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ toThousand($item->grand_total) }}</td>
                                        <td rowspan="{{ COUNT($item->delivery_order_detail) }}"
                                            style="vertical-align: middle;">
                                            {{ toThousand($item->total_payment) }}</td>
                                    @endif

                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
