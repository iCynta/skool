
@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<style>
    .modal-content {
    border-radius: 15px; /* Adjust the value as needed */
}
    </style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vehicle Master</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item">Management Corner</li>
                    <li class="breadcrumb-item">Vehicle Master</li>
                    <li class="breadcrumb-item active"><a href="#">New</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content card">
    <div class="container-fluid">
    
    <div class="row">
        <div class="container mt-2 pb-2">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Message Board -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('partials.message_board')
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-md btn-success mr-2" onclick="openModal(0);">Add Expenses</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead class="bg-dark">
                <tr>
                    <th> Si:No</th>
                    <th>Expense Name</th>
                    <th>Created date</th>
                    <th> Actions</th>
                </tr>
            </thead>
            <tbody id="expenseList">
   
            </tbody>
            <tfoot class="bg-light">
                    <tr>
                        <td colspan="5">
                        <div class="pagination justify-content-center">
                        <span id="links"></span>
                        </div>

                        </td>
                    </tr>
                </tfoot>
        </table>
    </div>
    <!-- Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <div class="form-group">
        <label for="expense_name">Expense Name</label>
        <input type="hidden" class="form-control" id="expid" name="expid" value="" >
        <input type="text" class="form-control" id="expense_name" name="expense_name" value="" >
    </div>
    <div class="form-group">
        <label>Status</label>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="statusSwitch" name="status">
            <label class="custom-control-label" for="statusSwitch">Active</label>
        </div>
    </div>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveChanges();">Save changes</button>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
ListExpense();
function openModal(val)
{
  
    if(val==0)
    {
        $('#expenseModal').modal('show');
        $('#exampleModalLabel').html('Add Expense');
        $('#expid').val('');
        $('#expense_name').val('');
        $('#statusSwitch').val('');
        
    }

}

function editModal(val) {
    // Retrieve the data-id attribute
    const id = val.getAttribute('data-id');
    const expense_name = val.getAttribute('data-expense_name');
    const status = val.getAttribute('data-status');
    if(status==1)
{
    $('#statusSwitch').prop('checked', true);
}
else
{
    $('#statusSwitch').prop('checked', false);
}
    // Display the modal
    $('#expid').val(id);
    $('#expense_name').val(expense_name);
    $('#expenseModal').modal('show');
    $('#exampleModalLabel').html('Edit Expense');
}      

function ListExpense(page = 1) {
    $.ajax({
        url: '{{ route('settings.expense.master.list') }}',
        method: 'GET',
        dataType: 'json', // Specify dataType as JSON
        data: { page: page }, // Pass the page number to the server
        success: function(response) {
            console.log('Full response:', response); // Log the entire response

            if (response.status === 200) {
                // Populate table with data
                const tableBody = $('#expenseList'); // Replace with your table body selector
                tableBody.html(response.data); // Directly set the HTML

                // Handle pagination links
                const paginationLinks = $('#links');
                paginationLinks.html(response.links); // Directly set the HTML

                // Attach click event handler to the pagination links
                paginationLinks.find('a').on('click', function(event) {
                    event.preventDefault();
                    const url = $(this).attr('href');
                    const page = new URLSearchParams(new URL(url).search).get('page');
                    ListExpense(page);
                });
            } else {
                alert('Invalid data format received from server');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', xhr);
            alert('Error fetching expenses');
        }
    });
}

$(document).ready(function() {
    ListExpense();
});
function saveChanges()
{
        // Get values from the modal inputs
        const id = $('#expid').val();
  const expense_name = $('#expense_name').val();
  const status = $('#statusSwitch').is(':checked') ? 1 : 0;
  const url = id ? '{{ route('settings.expense.master.entry', '') }}' + '/' + id : '{{ route('settings.expense.master.entry', '') }}';


        // Send the AJAX request
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                expense_name: expense_name,
                status: status
            },
            success: function(response) {
                // Handle success response
                console.log('Data saved successfully', response);
                $('#expenseModal').modal('hide');
                ListExpense();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Error saving data', error);
            }
        });
    
    }

</script>
@endsection

<!-- @push('scripts')
    
@endpush -->


