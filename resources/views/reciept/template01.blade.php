<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    body {
        margin-top: 20px;
    }
    .footer {
        margin-top: 20px;
        border-top: 1px solid #ddd;
        padding-top: 10px;
        text-align: center; /* Center the text */
    }
</style>
<div class="container">
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong>{{ $student->name }}</strong>
                        <br>
                       {{ $student->address }}
                        <abbr title="Phone">Phone:</abbr>  {{ $student->contact_number }}
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>Date: {{ $expense->created_at }}</em>
                    </p>
                    <p>
                        <em>Receipt #:{{ $expense->reciept_no }}</em>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="text-center">
                    <h1>Receipt</h1>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>#</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-md-9"><em>{{$studentmastr->expense_name}}</em></td>
                        <td class="col-md-1 text-center"></td>
                        <td class="col-md-1 text-center">{{$expense->amount}}</td>
                        <td class="col-md-1 text-center">{{$expense->amount}}</td>
                    </tr>
                 
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <p><strong>Subtotal:</strong></p>
                            <p><strong>Tax:</strong></p>
                        </td>
                        <td class="text-center">
                            <p><strong>{{$expense->amount}}</strong></p>
                            <p><strong>{{$expense->amount}}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right"><h4><strong>Total:</strong></h4></td>
                        <td class="text-center text-danger"><h4><strong>{{$expense->amount}}</strong></h4></td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer Section -->
            <div class="footer">
                <address>
                    <strong>{{$school->name}}</strong>
                    <br>
                    {{$school->address}}
                    <br>
                    <abbr title="Phone">Phone:</abbr> {{$school->phone}}
                </address>
            </div>
        </div>
    </div>
</div>
