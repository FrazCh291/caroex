<style>

    .manifest {
    background-color: white;
    width: 95%;
    margin-top: 13px;
    margin-left: 22px;
    border: solid #bab8b8 1px;
    margin-bottom: 38px;
}
    body{
        background-color: #f2f2f4;
        font-size:10px;
            orientation: landscape;
            font-family:Rubik, Helvetica, Arial, serif;
    }
    thead tr th, tbody tr td {
            padding-bottom: 8px;
        }
    .istar {
        margin-left: 661px;
        font-size: 20px;
        margin-top: 25px;
        font-family: system-ui;
    }
</style>
<html class="body" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    
    <div class="body">
        <h5 class="text-center mb-1 font-weight-bold">Delivery Manifest {{$manifests->date}} For ISTARZ LIMITED</h5>
        <section>   
            <div class="manifest">
                <table class="px-2 table table-borderless mb-0">
                    <tr class="border-0">
                        <th scope="col">Service</th>
                        <th class="text-center" scope="col">Consignment</th>
                        <th class="text-center" scope="col">Items</th>
                        <th class="text-center" scope="col">Weight(kg)</th>
                        <th class="text-center" scope="col"></th>
                        <th class="text-center" scope="col"></th>
                    </tr>
                    <tr>
                        <th scope="col" class="small cursor-pointer fw-light  ml-2 border-0">
                            Next Day
                        </th>
                        <td class="text-center">{{$manifests->consignment}}</td>
                        <td class="text-center">{{$manifests->No_items}}</td>
                        <td class="text-center">{{$manifests->weight}}</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <th class="small fw-light  cursor-pointer">Offshore</th>
                        <td class="text-center">10</td>
                        <td class="text-center">1</td>
                        <td class="text-center">10</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td class="text-center">14</td>
                        <td class="text-center">5</td>
                        <td class="text-center">119</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                </table>
            </div>
        </section>
        <div class="invoice-product-details table-responsive px-4">
            <table class="table table-borderless mb-0">
                <thead>
                <tr class="border-0">
                    <th scope="col">Next Day</th>
                    <th scope="col">Ref:</th>
                    <th scope="col">Delivery Address</th>
                    <th scope="col">Collection Address</th>
                    <th scope="col">Package</th>
                    <th scope="col">Weight(kg)</th>
                </tr>
                </thead>
                @foreach ($manifestitems as $manifestitem)
                    <tbody>
                    <tr>
                        <td class="PX-2 small py-0 my-0 custom-padding">{{$manifestitem->id}} <br>Ref:{{$manifestitem->orderItem->order->channel->name}}</td>
                        <td class="py-0 small PX-2 my-0">542</td>
                        <td class="PX-2 small py-0 my-0"><h6>{{$manifestitem->orderItem->order->customer->name}}
                        <br>{{$manifestitem->orderItem->order->customer->address1_2}}</h6>Your Ref:{{$manifestitem->orderItem->product->name}}</td>
                        <td class="PX-2 small text-truncate">ISTARZ LIMITED<br> ARROW TRADIND ESTATE <br> CORPORATION ROAD <br>MANCHESTER <br>LANCASHIRE M34 5LR </td>
                        <td class="px-4 small  ml-1">{{$manifestitem->orderItem->order->item}}</td>
                        <td class="px-4 small  ml-1">{{$manifestitem->orderItem->order->product->weight_unit}}</td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
     
    </div>
</body>

</html>