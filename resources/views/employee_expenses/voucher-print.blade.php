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
            height:600px;
        }
        .voucher_head{
            margin-top:0px;
            width:100%;
            height:100px;
            text-align: center;
            /* font-size: 30px; */
            font-weight:bold;
            border-bottom: 1px solid #333333;
        }
        .title-text{
            font-size:14px;
            font-weight:bold;
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
            margin-top:100px !important;
            text-align: left;
            font-size: 12px;
            color:#333333;
            height:250px;
            
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
                <!-- <p class="voucher_title"> Payment Voucher </p> -->
            
            <div class="row">
                    <div class="col-md-3" style=" width:25%; height:100%; v-align:middle; text-align:center; float:left;">
                        <img src="{{ asset('dist/img/logo-square-big.jpeg') }}" alt="logo" style="width: 90px; margin-top:5px;" class="img-circle elevation-3">
                    </div>
                    <div class="col-md-8" style=" width:74%; height:100%; text-align:center; float:left;">
                        <p class="voucher_title">{{$school->name}} </p>
                        <address class="text-muted text-sm">{{$school->address}}</address>
                        <p class="text-muted text-sm"><abbr title="Phone">Phone:</abbr> {{$school->phone}}</p>
                    </div>   
                </div>
                <<br/><p class="title-text" style="width:auto; margin-top:40px;">Payment Voucher</p><br/>
                </div>
            <div id="voucher_detail">            
                <p class="text-sm text-muted">Voucher No: {{ $expense->voucher_no}}</p>
                <p class="text-sm text-muted">Date: {{ $expense->created_at}}</p>
            </div>
            <div style="width:100%; height:1px;"></div>
            <div id="voucher_body">
                
                <p><b>Paid To: Mr/Mrs/Ms,  </b><i>{{ $expense->employee->name}}</i> </p>
                <p><b>Voucher Type:  </b><i>{{ $expense->expenseMaster->name}}</i> </p>
                <p><b> Amount: </b> <i> {{ $expense->amount}}</i>/-</p>
                <p><b>Description:</b> <i>{{ e($expense->description ?? 'NA') }}</i></p>
            </div>
            <div class="voucher_footer">
                <p class="text-left text-sm text-muted" style="width:49%">Signature : ....................................</p>
                <p  class="text-left text-sm text-muted" style="width:49%">Prepared By : {{$expense->createdBy->name}}</p>
            </div>            
        </div>
    </div>
</body>
</html>
