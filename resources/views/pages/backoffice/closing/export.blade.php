<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>{{ $title }}</title>
</head>
<style>
    table {
        widows: 100%;
        width: 100%;
        border-collapse: collapse;
    }

    table thead tr th {
        background-color: #46ce5f;
        color: #000;
        padding: 5px;
        text-align: center;

    }
</style>

<body>
    <h1>{{ $title }}</h1>

    <div class="row">
        @foreach ($data as $item)
            <div class="col-md-6">
                <table border="1">
                    <thead>
                        <tr>
                            <th colspan="2">Customer Belum Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->closing_detail as $closing_detail)
                            <tr>
                                <td>{{ $closing_detail->customer->name }}</td>
                                <td>{{ toThousand($closing_detail->nominal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <table border="1">
                    <thead>
                        <tr>
                            <th colspan="2">Lain-lain</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hutang: </td>
                            <td>{{ toThousand($item->debt ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Total Customer Belum Bayar: </td>
                            <td>{{ toThousand($item->cust_has_not_paid ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Saldo Individu: </td>
                            <td>{{ toThousand($item->main_balance ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Saldo BRI: </td>
                            <td>{{ toThousand($item->bri_balance ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Saldo Bisnis: </td>
                            <td>{{ toThousand($item->business_balance ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Hutang Toko: </td>
                            <td>{{ toThousand($item->shop_debt ?? 0) }}</td>
                        </tr>

                        <tr>
                            <td>Modal Toko: </td>
                            <td>{{ toThousand($item->shop_capital ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Total Semua: </td>
                            <td>{{ toThousand(intval($item->debt ?? 0) + intval($item->cust_has_not_paid ?? 0) + intval($item->main_balance ?? 0) + intval($item->bri_balance ?? 0) + intval($item->business_balance ?? 0) + intval($item->shop_debt ?? 0) + intval($item->shop_capital ?? 0)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </br>
        @endforeach

    </div>
</body>

</html>
