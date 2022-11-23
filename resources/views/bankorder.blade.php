<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <div class="col-11">
        <section class="invoice-view-wrapper">
                    <div style="margin-left:35px;">
                        <img src="img/alfaMohuha.png" alt="description of myimage" class="imgLogo">
                    </div>
                <div style="margin-left:513px ;">
                    <span class="font-weight-normal">{{$companyName}}</span><br>
                    <span class="font-weight-normal">{{$address}}</span><br>
                    <p class="font-weight-bold mt-3">{{$date}}</p>
                </div>
                    <div style="margin-left:35px; width: 290px;">
                        <span class="font-weight-normal">{{$managerName}} - Branch Manager</span><br>
                        <span class="font-weight-normal "> 
                        {{$bankAddress}}
                        </span>
                    </div>   
                    <div style="margin-left:150px;">
                        <p class="mt-3 font-weight-bold">RE: {{$date}}
                            Salary disbursement for Alfa Mohuha</p>
                    </div>
                    <div style="margin-left:35px;">
                        <span>Dear {{$managerName}},</span><br>
                    </div>
              
      
               
                    <div style="margin-left:35px;">
                        <label class="mt-2">Please disburse funds to staff listed in the table below on <label class="font-weight-bold mt-1">{{$date}}:</label></label>

                    </div>
               
                <div>
                    <table style="margin-left:35px">
                        <tr>
                            <th style="padding-left:10px; padding-right: 20px;">#</th>
                            <th style="padding-left:5px;" width="230px">Name</th>
                            <th style="padding-left:5px;" width="230px">Account Number</th>
                            <th style="padding-left:30px;" width="80px">Salary</th>
                        </tr>
                        @foreach ($employeeSalaries as $employeeSalary)
                        <tr>
                            <td style="padding-left:10px; padding-right: 20px;">{{ $loop->index+1}}</td>
                            <td style="padding-left:5px;" width="230px">{{$employeeSalary->employee->name}}</td>
                            <td style="padding-left:5px;" width="230px">{{$employeeSalary->employee->account? $employeeSalary->employee->account->account_no: ""}}</td>
                            <td style="padding-left:30px;" width="100px">{{$employeeSalary->net_total }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="padding-left:145; font-weight:bold">Total</td>
                            <td style="padding-left:25px;">{{$employeeSalaries->sum('net_total')}}</td>
                        </tr>
                    </table>
                </div>   
                    <div style="margin-left:35px;">
                        <div style="margin-top:10px;">Your sincerely,</div>
                        <div style="margin-top: 30px;">{{$ceoName}}</div>
                        <div>CEO</div>
                    </div>
                
            <div class="col-1"></div>
        </section>
    </div>
</body>
<style>
    .imgLogo {
        height: 60px;
        margin-top: 40px;
    }

    body {
        font-size: 14px;
        font-family: Rubik, Helvetica, Arial, serif;
    }
</style>