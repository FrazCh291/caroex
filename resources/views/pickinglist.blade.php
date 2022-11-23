<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
<div class="col-11">
<section class="invoice-view-wrapper">
              <div class="col-12 mt-3">
                <h5 class="font-weight-bold ml-5">Picking List: {{$pickingLists->date}}</h5>
                <div class="card ml-5">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="custom-padding">product</th>
                                    <th class="text-center justify-content-start">Sku</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pickingLists->products as $pickingList)
                                <tr>
                                    <td class=" custom-padding">{{$pickingList->name}}</td>
                                    <td class="text-center">{{$pickingList->sku}}</td>
                                    <td class="text-center">{{$pickingList->total_quantity}}</td>
                                    <td class="text-center"></td>
                                </tr>
                                @endforeach
                                <tr>
                                   <th>Total</th>
                                    <th></th>
                                    <th class="text-center text-bold">{{$total}}
                                    </th>      
                                    <th></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>


        </body>

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
        font-size:10px;
        background-color: #f2f2f4;
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