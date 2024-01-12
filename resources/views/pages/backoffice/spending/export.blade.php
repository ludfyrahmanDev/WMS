<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Mutasi Saldo</title>
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
    </style>
</head>

<body>

    <div class="mt-4">
        <div class="row">
            <h3 class="text-center fw-bold">Laporan Mutasi Saldo</h3>
            <hr class="hr1 mt-2">
        </div>

        <h5 class="card-title fw-bold">Saldo Fisik</h5>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Uang Masuk</th>
                            <th scope="col">Uang Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @if ($item->payment_method == 'CASH')
                                <tr class="text-center">
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{ $item->spendingCategory->spending_category ?? '-' }}</td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    @if ($item->mutation == 'Uang Masuk')
                                        <td>{{ toThousand($item->nominal) ?? '0' }}</td>
                                        <td>-</td>
                                    @else
                                        <td>-</td>
                                        <td>{{ toThousand($item->nominal) ?? '0' }}</td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="card-title fw-bold">Saldo Rekening</h5>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Mutasi Kredit</th>
                            <th scope="col">Mutasi Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            @if ($item->payment_method != 'CASH')
                                <tr class="text-center">
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{ $item->spendingCategory->spending_category ?? '-' }}</td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    @if ($item->mutation == 'Uang Masuk')
                                        <td>{{ toThousand($item->nominal) ?? '0' }}</td>
                                        <td>-</td>
                                    @else
                                        <td>-</td>
                                        <td>{{ toThousand($item->nominal) ?? '0' }}</td>
                                    @endif
                                </tr>
                            @endif
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
