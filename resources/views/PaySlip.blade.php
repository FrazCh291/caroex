<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        @foreach($salaries as $salary)
        <div style="height: 500px;" >
            <div style="text-align: center; ">
                Employee Copy
                </div>
                <div style="text-align: right">
                    <img src="img/alfaMohuha.png" alt="description of myimage" class="imgLogo"><br>
                    <span>{{$companyName}}</span><br>
                    <span>{{ $address? $address: ""}}</span><br>
                    <span>www.alfamohuha.com , {{$companyEmail}}</span><br>
                </div>
                <div>
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:	dimgray;margin-left:20px; font-weight:bold">Salary Month</div>
                    </div>
                    <div style="display: inline-block;margin-left:70">
                        <div style="font-size: 14px;color:	dimgray;font-weight:bold">{{$date}}</div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:black;margin-left:20px">Employee Details</div>
                    </div>
                    <div style="display: inline-block;margin-left:215px">
                        <div style="font-size: 14px;color:black;">Deductions</div>
                    </div>
                </div>
                
                <div style="margin-top: 15px; margin-left:20px;">
                    <div class="oneline">
                        <div style="display: inline-block; padding-left:5px;padding-top:14px">
                            <span>Employee ID</span><br>
                            <span>Employee Name</span><br>
                            <span>Department</span><br>
                            <span>Designation</span><br>
                            
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span>{{ $salary->employee? $salary->employee->employee_id: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->name: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->department: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->designation: ""}}</span><br>
                        </div>
                    </div>
                    <div class="oneline" style="margin-left: 20px;">
                        <div style="display: inline-block; padding-top:14px; padding-left:5px">
                            <span>Life Ins:</span><br>
                            <span>Tax:</span><br>
                            <span>other Ded:Unapproved leave</span><br>
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span></span><br>
                            <span>{{ $salary? $salary->tax: ""}}</span><br>
                            <span></span><br>
                        </div>
                        <div style="border-top: 1px solid;padding-left: 180px;padding-top: 0px;padding-bottom: 0px;">
                            <span></span>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:black;margin-left:20px">Payment</div>
                    </div>
                    <div style="display: inline-block;margin-left:265px">
                        <div style="font-size: 14px;color:black;">Summary</div>
                    </div>
                </div>
                
                <div style="margin-top: 15px; margin-left:20px;">
                    <div class="oneline">
                        <div style="display: inline-block; padding-left:5px;padding-top:14px">
                            <span>Basic Salary:</span><br>
                            <span>Misc.pay:</span><br>
                            <span>Extra Hours / Days</span><br>
                            <span></span><br>
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span>{{ $salary->employee? $salary->employee->total_salary: ""}}</span><br>
                            <span></span><br>
                            <span></span><br>
                        </div>
                        <div style="border-top: 1px solid;padding-left: 200px;padding-top: 0px;padding-bottom: 0px;">
                            <span></span>
                        </div>
                    </div>
                    <div class="oneline" style="margin-left: 20px;">
                        <div style="display: inline-block; padding-top:14px; padding-left:10px">
                            <span>Gross Pay:</span><br>
                            <span>Deductions:</span><br>
                            @foreach($salary->adjustments as $adjustment)
                            <span>{{$adjustment->reason}}:</span><br>
                            @endforeach
                        </div>
                        <div style="display: inline-block;padding-left:110px">
                            <span>{{ $salary? $salary->gross: ""}}</span><br>
                            <span>{{ $salary? $salary->total_detuction: ""}}</span><br>
                            @foreach($salary->adjustments as $adjustment)
                            <span>{{$adjustment->total_amount}}</span><br>
                            @endforeach
                        </div>
                        <div style="border-top: 1px solid;padding-top: 0px;padding-bottom: 0px;">
                            <div style="display: inline-block;margin-left:10px">
                                <div>Net Pay:</div>
                            </div>
                            <div style="display: inline-block;margin-left:126px">
                                <div>{{ $salary? $salary->net_total: ""}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:130px;display: inline-block">HR</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:60px;display: inline-block">Employee Sign
                        </div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:88px;display: inline-block">Accountant</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:35px;display: inline-block">Accounts
                            Executive</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                </div>
            </div>  
            <hr style="width:100%; border-top: 1px dashed black;"> 
            <div style="height: 450px;" >
                <div style="text-align: center;">
                    Company Copy
                </div>
                <div style="text-align: right">
                    <img src="img/alfaMohuha.png" alt="description of myimage" class="imgLogo"><br>
                    <span>{{$companyName}}</span><br>
                    <span>{{ $address? $address: ""}}}</span><br>
                    <span>www.alfamohuha.com , {{$companyEmail}}</span><br>
                </div>
                <div>
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:	dimgray;margin-left:20px; font-weight:bold">Salary Month</div>
                    </div>
                    <div style="display: inline-block;margin-left:70">
                        <div style="font-size: 14px;color:	dimgray;font-weight:bold">{{$date}}</div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:black;margin-left:20px">Employee Details</div>
                    </div>
                    <div style="display: inline-block;margin-left:215px">
                        <div style="font-size: 14px;color:black;">Deductions</div>
                    </div>
                </div>

                <div style="margin-top: 15px; margin-left:20px;">
                    <div class="oneline">
                        <div style="display: inline-block; padding-left:5px;padding-top:14px">
                            <span>Employee ID</span><br>
                            <span>Employee Name</span><br>
                            <span>Department</span><br>
                            <span>Designation</span><br>
                            
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span>{{ $salary->employee? $salary->employee->employee_id: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->name: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->department: ""}}</span><br>
                            <span>{{ $salary->employee? $salary->employee->designation: ""}}</span><br>
                        </div>
                    </div>
                    <div class="oneline" style="margin-left: 20px;">
                        <div style="display: inline-block; padding-top:14px; padding-left:5px">
                            <span>Life Ins:</span><br>
                            <span>Tax:</span><br>
                            <span>other Ded:Unapproved leave</span><br>
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span></span><br>
                            <span>{{ $salary? $salary->tax: ""}}</span><br>
                            <span></span><br>
                        </div>
                        <div style="border-top: 1px solid;padding-left: 180px;padding-top: 0px;padding-bottom: 0px;">
                            <span></span>
                        </div>
                    </div>
                </div>

                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 14px;color:black;margin-left:20px">Payment</div>
                    </div>
                    <div style="display: inline-block;margin-left:265px">
                        <div style="font-size: 14px;color:black;">Summary</div>
                    </div>
                </div>

                <div style="margin-top: 15px; margin-left:20px;">
                    <div class="oneline">
                        <div style="display: inline-block; padding-left:5px;padding-top:14px">
                            <span>Basic Salary:</span><br>
                            <span>Misc.pay:</span><br>
                            <span>Extra Hours / Days</span><br>
                        </div>
                        <div style="display: inline-block;padding-left:40px">
                            <span>{{ $salary? $salary->gross: ""}}</span><br>
                            <span></span><br>
                            <span></span><br>
                        </div>
                        <div style="border-top: 1px solid;padding-left: 200px;padding-top: 0px;padding-bottom: 0px;">
                            <span></span>
                        </div>
                    </div>
                    <div class="oneline" style="margin-left: 20px;">
                        <div style="display: inline-block; padding-top:14px; padding-left:10px">
                            <span>Gross Pay:</span><br>
                            <span>Deductions:</span><br>
                            @foreach($salary->adjustments as $adjustment)
                            <span>{{$adjustment->reason}}:</span><br>
                            @endforeach
                        </div>
                        <div style="display: inline-block;padding-left:110px">
                            <span>{{ $salary? $salary->gross: ""}}</span><br>
                            <span>{{ $salary? $salary->total_detuction: ""}}</span><br>
                            @foreach($salary->adjustments as $adjustment)
                            <span>{{$adjustment->total_amount}}</span><br>
                            @endforeach
                        </div>
                        <div style="border-top: 1px solid;padding-top: 0px;padding-bottom: 0px;">
                        <div style="display: inline-block;margin-left:10px">
                        <div>Net Pay:</div>
                    </div>
                    <div style="display: inline-block;margin-left:126px">
                        <div>{{ $salary? $salary->net_total: ""}}</div>
                    </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:130px;display: inline-block">HR</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:60px;display: inline-block">Employee Sign
                        </div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                </div>
                <div style="margin-top:5px;">
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:88px;display: inline-block">Accountant</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                    <div style="display: inline-block">
                        <div style="font-size: 12px;color:black;margin-left:35px;display: inline-block">Accounts
                            Executive</div>
                        <div style="display: inline-block; border-bottom:1px solid;width:170px;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </div>
</body>
<style>
    .imgLogo {
        height: 40px;
        margin-top: 5;

    }

    .oneline {
        width: 300px;
        height: 95px;
        border: solid 1px black;
        display: inline-block;
    }


    body {
        font-size: 10px;
        font-family: Rubik, Helvetica, Arial, serif;
    }
</style>