<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Servis Kendaraan</title>
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
            <h3 class="text-center fw-bold">Laporan Servis Kendaraan</h3>
            <hr class="hr1 mt-2">
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center d-align-center">
                            <th scope="col">Tanggal</th>
                            <th scope="col">Driver</th>
                            <th scope="col">Nopol</th>
                            <th scope="col">Kategori pengeluaran</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotal = 0; // Inisialisasi grand total
                        @endphp

                        @foreach ($data as $item)
                            @php
                                $grandTotal = 0; // Reset grand total setelah setiap service
                            @endphp

                            @foreach ($item->vehicleServiceDetail as $key => $childItem)
                                <tr class="text-center">
                                    @if ($key == 0)
                                        <td rowspan="{{ COUNT($item->vehicleServiceDetail) }}" style="vertical-align: middle;">{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                        <td rowspan="{{ COUNT($item->vehicleServiceDetail) }}" style="vertical-align: middle;">{{ $item->driver->name }}
                                        </td>
                                        <td rowspan="{{ COUNT($item->vehicleServiceDetail) }}" style="vertical-align: middle;">
                                            {{ $item->vehicle->license_plate }}</td>
                                    @endif

                                    <td>{{ $childItem->spendingCategory->spending_category ?? '-' }}</td>
                                    <td>{{ toThousand($childItem->amount_of_expenditure ?? '0') }}</td>
                                    <td>{{ $childItem->description ?? '-' }}</td>

                                    @if ($key == 0)
                                        @for ($i = 0; $i < COUNT($item->vehicleServiceDetail); $i++)
                                            @php
                                                $grandTotal += $item->vehicleServiceDetail[$i]['amount_of_expenditure'];
                                            @endphp
                                        @endfor

                                        <td rowspan="{{ COUNT($item->vehicleServiceDetail) }}" style="vertical-align: middle;">{{ toThousand($grandTotal ?? '0') }}
                                        </td>
                                    @endif

                                </tr>

                                {{-- @php
                                    $grandTotal += $childItem->amount_of_expenditure ?? 0; // Akumulasi grand total
                                @endphp --}}
                            @endforeach

                            <!-- Tampilkan total per service di akhir setiap service -->
                            {{-- <tr style="background-color: yellowgreen">
                                <td colspan="3" class="text-right"></td>
                                <td>Total Per Service</td>
                                <td class="text-left">{{ toThousand($grandTotal) }}</td>
                                <td></td>
                            </tr> --}}

                            {{-- @php
                                $grandTotal = 0; // Reset grand total setelah setiap service
                            @endphp --}}
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
