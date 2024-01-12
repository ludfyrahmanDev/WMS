<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>laporan_penjualan_{{ date('d-m-Y', strtotime($data[0]->date)) }}</title>
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

        @media print {
            .bungkus {
                page-break-before: auto; /* atau always, atau avoid */
                page-break-after: auto; /* atau always, atau avoid */
            }
        }
    </style>
</head>

<body>
    <div class="mt-4 bungkus">
        <div class="row">
            <h3 class="text-center fw-bold">Laporan Penjualan {{ date('d-m-Y', strtotime($data[0]->date)) }}</h3>
            <hr class="hr1 mt-2">
            <div class="d-flex align-content-between">
                <div class="col-md-6">
                    <table>
                        <tr>
                            <td>Tanggal</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ date('d-m-Y', strtotime($data[0]->date)) }}</td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ $data[0]->customer->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Driver</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ $data[0]->driver->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. Pol</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ $data[0]->vehicle->license_plate ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Uang Saku Driver</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">Rp. {{ number_format($data[0]->drivers_pocket_money) }}</td>
                        </tr>
                        <tr>
                            <td>Metode Penjualan</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ ucfirst($data[0]->purchasing_method) }}</td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ ucfirst($data[0]->payment_type) }}</td>
                        </tr>
                        <tr>
                            <td>Admin</td>
                            <td class="pl-4">:</td>
                            <td class="pl-2">{{ ucfirst($data[0]->created_by) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">No</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Harga/KG</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @foreach ($item->selling_detail as $key => $detail)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $detail->stock->product->product ?? '-' }}</td>
                                    <td>Rp. {{ number_format($detail->price_kg) }}</td>
                                    <td>Rp. {{ number_format($detail->price_sell) }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td class="text-right">Rp. {{ number_format($detail->subtotal) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right fw-bold">Grand Total</td>
                            <td class="text-right">Rp. {{ number_format($item->grand_total) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right fw-bold">Total Bayar</td>
                            <td class="text-right">Rp. {{ number_format($item->total_payment) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right fw-bold">Laba Bersih</td>
                            <td class="text-right">Rp. {{ number_format($item->net_profit) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <u><i>Catatan :</i></u>
        <p>{{ $data[0]->notes }}</p>
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
