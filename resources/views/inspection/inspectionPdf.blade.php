<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn538    4xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <title>Document</title>
</head>
<body>

<body>
<form class="form form-horizontal" @submit.prevent="submit">
            <section id="basic-horizontal-layouts">
                <div class="row match-height">
                    <div class=" inspectioncard1 px-1">
                    <div class="col-md-11 col-lg-11  col-xl-11 col-11  ">
                        <h5 class="font-weight-bold">Delivery Inspection {{  $delivery->date }}</h5>
                        <div class="card invoice-print-area">
                            <div class="invoice-product-details table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody class="line">
                                    <tr class="border-0">
                                        <th scope="col" class="fw-bolder">Service</th>
                                        <th class="text-center" scope="col">Consignment</th>
                                        <th class="text-center" scope="col">Items</th>
                                        <th class="text-center" scope="col">Weight(kg)</th>
                                        <th class="text-right" scope="col"></th>
                                        <th class="text-right" scope="col"></th>
                                    </tr>
                                    <tr>
                                        <th class="small cursor-pointer ml-2 border-0" scope="col">
                                            Next Day
                                        </th>
                                        <td class="text-center">{{ $delivery->No_items }}</td>
                                        <td class="text-center">{{ $delivery->No_items }}</td>
                                        <td class="text-center">{{ $delivery->weight }}</td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                    <tr>
                                        <th class="small cursor-pointer">Offshore</th>
                                        <td class="text-center">10</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">10</td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                    </tbody>
                                    <tr>
                                        <th>Total</th>
                                        <td class="text-center">14</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">119</td>
                                        <td class="text-right"></td>
                                        <td class="text-right"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-10 col-md-10 col-lg-10  col-xl-10 ml-5  inspectioncard invoice-product-details table-responsive mt-5">
                        <table class="table table-border-less ">
                            <thead>
                            <tr class="border-0">
                                <th></th>
                                <!-- <input class="mt-2" type="checkbox"  :value="deliveryInspection.id" v-model="selected" number> -->
                                <th scope="col">Service Type</th>
                                <th scope="col">Product</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Status</th>
                                <th scope="col">Package</th>
                                <th scope="col">Weight (kg)</th>
                            </tr>
                            @foreach ($deliveryInspection as $deliveryInspecte)
                            <tr >
                                <td></td>
                                <td class="text-center custom-padding">
                                    Next Day
                                </td>
                                <td class="text-center aligns-items-start">{{ $deliveryInspecte->order->product->name }}</td>
                                <td class="text-truncate" @click="inspection(deliveryInspecte.id)">
                                    <div class="text-md-left"> <span
                                        id="login" :data-toggle="deliveryInspecte.id"

                                        data-container="body" data-html="true" data-placement="bottom"
                                        href="#" type="button" @mouseout="hideTooltip(deliveryInspecte.id)"><span
                                        class="underline-dotted border-gray  text-truncate ">{{
                                            ($deliveryInspecte->order->shipping_address_1 ? $deliveryInspecte->order->shipping_address_1 : '') .
                                            ($deliveryInspecte->order->shipping_address_2 ? $deliveryInspecte->order->shipping_address_2 : '') .
                                            ($deliveryInspecte->order->shipping_city ? ", " . $deliveryInspecte->order->shipping_city : '') .
                                            ($deliveryInspecte->order->shipping_address_county ? ", " . $deliveryInspecte->order->shipping_address_county : '') .
                                            ($deliveryInspecte->order->shipping_address_postcode ? ", " . $deliveryInspecte->order->shipping_address_postcode : '') .
                                            ($deliveryInspecte->order->shipping_country ? ", " . $deliveryInspecte->order->shipping_country : '')
                                        }}</span>
                                    </span>
                                    </div>
                                </td>
                                <td class="text-center px-0">
                                <div class="d-flex align-items-center text-center">
                                        @if ( $deliveryInspecte->is_collected === '1')
                                        <span
                                              class="badge rounded-pill bg-success">Collected</span>
                                         @else
                                        <span class="badge rounded-pill bg-danger">Not Collected</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{ $deliveryInspecte->order->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ $deliveryInspecte->order->product->weight_unit }}
                                </td>
                            </tr>
                            @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </section>
        </form>

        </body>


        <style>

body{
    font-size:10px;
    background-color: #f2f2f4;
        orientation: landscape;
        font-family:Rubik, Helvetica, Arial, serif;
}
thead tr th, tbody tr td {
        padding-bottom: 8px;
    }
.inspectioncard{
    margin-left: 10px;
}

.inspectioncard1{
    margin-left: 40px;
}
</style>
