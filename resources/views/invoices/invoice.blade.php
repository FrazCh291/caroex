<style>

    .invoice {
        background-color: white;
        width: 95%;
        margin-top: 13px;
        margin-left: 22px;
        border: solid #bab8b8 2px;
        margin-bottom: 38px;
    }

    body {
        font-size: 10px;
        orientation: landscape;
        font-family: Rubik, Helvetica, Arial, serif;
    }

    thead tr th, tbody tr td {
        padding-bottom: 8px;
    }

    #table2tr1 th {
        padding-left: 0px;
        padding-right: 0px;
        margin-left: 0px;
        margin-right: 0px;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>

<div class="body">
    {{--    <h5 class="text-center mb-1 font-weight-bold">Invoice#</h5>--}}
    <section>
        <div class="invoice">
            <div class="row match-height">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                    <div class="row pt-5">
                        <div class="col-md-2 col-lg-2 col-xl-2 col-2">

                        </div>
                        <div class="col-md-4 col-lg-4 col-xl-4 col-4">
                            <div class=" pb-0 mb-0">
                                <small
                                    class="text-muted mr-1 lg:font-bold"><strong>{{$invoice->customer->name}}</strong></small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">18 Jelly Way</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">Woking</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">Surrrey</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">GU22 9FT</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">info@istarz.co.uk</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">VAT Registration No: 280 3468 02 -
                                    ISTARZ</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold">LTD</small>
                            </div>
                            <div class=" pb-0 mb-0 pt-4">
                                <small class=""><strong>Invoice</strong></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-6 col-6">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-xl-2 col-2">
                        </div>
                        <div class="col-md-4 col-lg-4 col-xl-4 col-4 pt-5">
                            <div class="pb-0 mb-0">
                                <small class="text-muted pl-5"><strong>Invoice To</strong></small>
                            </div>
                            <div class="pb-0 mb-0">
                                <small class="text-muted pl-5">{{$invoice->supplier->name}}</small>
                            </div>
                            <div class="pb-0 mb-0">
                            </div>
                            <div class="pb-0 mb-0">
                            </div>
                            <div class="pb-0 mb-0">
                            </div>
                            <div class="pt-0 mt-0 pb-0 mb-0">
                            </div>
                            <div class="pb-0 mb-0">
                            </div>
                            <div class="pb-0 mb-0 pt-5">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3 col-3">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3 col-3">
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Shipment#</strong></small>
                                <small class="text-muted pl-4 ml-2">{{$invoice->shipment->container_number}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Invoice#</strong></small>
                                <small class="text-muted pl-5">{{$invoice->invoice_number}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Reference</strong></small>
                                <small class="text-muted pl-4 ml-3">{{$invoice->reference_number}}</small>
                            </div>
                            <div class="pt-0 mt-0 pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Date:</strong></small>
                                <small
                                    class="text-muted pl-5 ml-3">{{ date("d/m/Y", strtotime($invoice->invoice_date)) }}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Currency</strong></small>
                                <small class="text-muted pl-4 ml-3">{{$invoice->exchange->from_to}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted lg:font-bold"><strong>Conversion Rate:</strong></small>
                                <small class="text-muted">{{$invoice->conversion_rate}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-lg-1 col-xl-1 col-1">
                        </div>
                        <div class="col-md-10 col-lg-10 col-xl-10 col-10">
                            <table class="invoice table mb-0">
                                <thead>
                                <tr id="table2tr1">
                                    <th></th>
                                    <th></th>
                                    <th class="text-lef+t"><h3>Details</h3></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="border-0">
                                    <th scope="col" class="text-center">Product</th>
                                    <th scope="col" class="text-center">Currency</th>
                                    <th scope="col" class="text-center">Unit Price</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoice->invoiceItems as $invoiceItem)
                                    <tr>
                                        <td class="PX-2 small py-0 my-0 custom-padding text-center">{{$invoiceItem->item_name}}</td>
                                        <td class="PX-2 small py-0 my-0 custom-padding text-center">{{$invoiceItem->currency}}</td>
                                        <td class="PX-2 small py-0 my-0 custom-padding text-center">{{$invoiceItem->unit_price}}</td>
                                        <td class="PX-2 small py-0 my-0 custom-padding text-center">{{$invoiceItem->quantity}}</td>
                                        <td class="PX-2 small py-0 my-0 custom-padding text-center">{{$invoiceItem->total}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 col-1">
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-9 col-lg-9 col-xl-9 col-9">
                        </div>
                        <div class="col-md-2 col-lg-2 col-xl-2 col-2">
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Sub Total</strong></small>
                                <small class="text-muted">{{$invoice->sub_total}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Vat</strong></small>
                                <small class="text-muted">{{$invoice->vat}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Total</strong></small>
                                <small class="text-muted">{{$invoice->total}}</small>
                            </div>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 col-1">
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-2 col-lg-2 col-xl-2 col-2">
                        </div>
                        <div class="col-md-2 col-lg-2 col-xl-2 col-2">
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Status</strong></small>
                                <small class="text-muted">{{$invoice->statuss->value}}</small>
                            </div>
                            <div class=" pb-0 mb-0">
                                <small class="text-muted mr-1 lg:font-bold"><strong>Balance</strong></small>
                                <small class="text-muted">{{$invoice->balance}}</small>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-xl-8 col-8">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>

</html>
