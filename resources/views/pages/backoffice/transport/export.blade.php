<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>laporan_angkutan_{{ date('d-m-Y') }}</title>
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
            <h3 class="text-center fw-bold">Laporan Angkutan</h3>
            <hr class="hr1 mt-2">
        </div>

        <div class="row mt-4">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nopol</th>
                            <th scope="col">Pengemudi</th>
                            <th scope="col">Penerima</th>
                            <th scope="col">Ongkosan</th>
                            <th scope="col">Saku Sopir</th>
                            <th scope="col">Setoran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->vehicle->license_plate }}</td>
                                    <td>{{ $item->driver->name }}</td>
                                    <td>{{ $item->customer->name }}</td>
                                    <td>{{ toThousand($item->customer->ongkosan) }}</td>
                                    <td>{{ toThousand($item->drivers_pocket_money) }}</td>
                                    <td>{{ toThousand($item->customer->ongkosan - $item->drivers_pocket_money) }}</td>
                                </tr>
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
