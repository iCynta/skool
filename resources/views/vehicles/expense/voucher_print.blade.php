<!-- resources/views/expenses/print.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Voucher</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .voucher_container{
            border:1px solid #333333;
            padding:0px;
            margin: 0px;
            height:400px;
        }
        .voucher_head{
            margin-top:0px;
            width:100%;
            height:50px;
            text-align: center;
            /* font-size: 30px; */
            font-weight:bold;
            border-bottom: 1px solid #333333;
        }
        .Voucher_title{
            height:50px;
            text-align: center;
            vertical-align: middle;
            font-size: 35px;
            font-weight:bold;
            color:#000000;
            margin:auto;
        }
        #voucher_detail{
            float: right;
            height: 100px;
            width:50%;
            margin:10px;
            text-align: left;
            font-size: 12px;
            color:#333333;
            float:right;
            text-align: right;
            clear:both;
        }
        #voucher_body{
            width:100%;
            margin:10px;
            text-align: left;
            font-size: 12px;
            color:#333333;
            height:200px;
            
        }
        .voucher_footer{
            padding-top:20px;
            margin:10px;
            border-top:1px dotted #333333;
            width:100%;
            height:70px;
        }
        
        .text-right {
            text-align: right !important;
        }
        .text-left {
            text-align: left !important;
        }
        .text-sm {
            font-size: 10px;
        }
        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
    <div class="voucher_container">
        <div class="voucher">
            <div class="voucher_head">
                <p class="voucher_title"> Vehicle Expense Voucher </p>
            </div>
            <div id="voucher_detail">
                <!-- <p class="text-sm text-muted">Voucher No: {{-- $expense->voucher_no --}}</p> -->
                <p class="text-sm text-muted">Date: {{ $expense->created_at}}</p>
            </div>
            <div style="width:100%; height:1px;">.</div>
            <div id="voucher_body">
                <p><b>Vehicle      :  </b><i>{{ $expense->vehicle->plate_number}}</i> </p>
                <p><b> Type        :  </b><i>{{ $expense->expenseType->name}}</i> </p>
                <p><b> Amount      :  </b> <i> {{ $expense->amount}}</i>/-</p>
                <p><b>Purpose      :  </b> <i>{{ e($expense->description ?? 'NA') }}</i></p>
            </div>
            <div class="voucher_footer">
                <p class="text-left text-sm text-muted" style="width:49%">Authorized By : ...............................</p>
                <p  class="text-left text-sm text-muted" style="width:49%">Prepared By : {{$expense->createdBy->name}}</p>
            </div>            
        </div>
    </div>
</body>
</html>
