<!DOCTYPE html>
<html>
<head>
    <title>Order Report</title>
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
    <h2>Orders Report</h2>
    <table width="100%">
        <thead>
        <tr>
            <th class="text-center">Order</th>
            <th>Channel</th>
            <th>Customer</th>
            <th class="text-center">Total Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
        <td class="text-center">{{$order->order_number}}</td>
        <td >{{$order->channel->name}}</td>
        <td>{{$order->customer->name}}</td>
        @if($order->order_total_amount!==null)
        <td class="text-center">{{$order->order_total_amount}}</td>
        @else
            <td></td>
        @endif
        <td>{{$order->order_status}}</td>
        <td>{{date("d/m/Y", strtotime($order->order_date))}}</td>
        </tr>
        @endforeach
        <tr>
            <td class="text-center">Total</td>
            <td ></td>
            <td></td>
            <td class="text-center">{{$sum}}</td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
