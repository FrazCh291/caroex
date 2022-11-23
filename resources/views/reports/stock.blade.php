<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style>
        body {
            font-size:10px;
            orientation: landscape;
            font-family:Rubik, Helvetica, Arial, serif;
        }
        table {
            border-collapse: collapse;
            border: none !important;
        }
        thead tr th, tbody tr td {
            padding-bottom: 8px;
        }
        th {
            text-align: left;
        }
        .right {
            text-align: right;
            padding-right: 10px;
        }
        h2 {
            text-align: center;
        }

    </style>
</head>

<body>
<div class="landscape">
    <h2>Stocks Report</h2>
    <table width="100%">
        <thead>
        <tr>
            <th>PRODUCT NAME</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productStocks as $productStock)
            <tr>
                <td>{{$productStock->product->name}}</td>
                <td>{{$productStock->quantity}}</td>
                <td>{{date("d/m/Y", strtotime($productStock->date))}}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{$sum}}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
