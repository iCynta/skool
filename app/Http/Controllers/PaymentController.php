<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StudentsExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Log;

class PaymentController extends Controller
{

    public function index()
    {
        // Get total amount paid to each payment type
        $totalsByType = $this->getTotalByPaymentType();

        // Get total amount paid to each user for the 'management' payment type
        $totalsByUserForManagement = $this->getTotalPaidByUserForManagement();

        $payments = Payment::where('paid_by',Auth::User()->id)->with('paidTo', 'paidBy')->get();

        foreach ($payments as $payment) {
            //dd($payments);
            $payment->relatedExpenses = $payment->relatedStudentExpense()->with('expense', 'student')->get();
        }
        return view('payment.index', compact('payments','totalsByType', 'totalsByUserForManagement' ));
    }
    // Create payment
    public function create()
    {
        $payments_to_settle = StudentsExpense::where('created_by', Auth::user()->id)
        ->where('settled',0)
        ->with('student','expense')->paginate(10);

        $recipients = User::where('course_id',1)->get();
        return view('payment.create', compact('payments_to_settle','recipients' ));
    }

    // Store a new payment
    public function store(Request $request)
    {

        $rules = [
            //'paid_by' => 'required|exists:users,id',
            'payment_type' => 'required|string|max:20',
            'paid_to' => 'nullable|exists:users,id',
            'amount' => 'required|numeric',
            'detail' => 'nullable|string',
            'payment_slip' => 'nullable|file|mimes:pdf,jpeg,jpg,png,gif|max:2048',
            'selected_payments' => 'required',
        ];

        // Convert the comma-separated string to an array and cast each element to an integer
        $selectedPaymentsArray = array_map('intval', explode(',', $request->selected_payments));

        // Validate each selected payment ID exist in student expense table
        foreach ($selectedPaymentsArray as $id) {
            if (!StudentsExpense::find($id)) {
                return redirect()->back()->withErrors(['selected_payments' => 'One or more payments selected are not in our record.'])->withInput();
            }
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Validate input data
            $validatedData = $validator->validated();

            // Set paid_by to current logged user
            $validatedData['paid_by'] = Auth::user()->id;

            // Set paid_date to current date and time
            $validatedData['paid_date'] = Carbon::now()->toDateTimeString();

            // Convert the integer array to JSON for storage
            $validatedData['selected_payments'] = json_encode($selectedPaymentsArray);

            // Handle file upload if present
            if ($request->hasFile('payment_slip')) {
                $validatedData['payment_slip'] = $this->handleFileUpload($request->file('payment_slip'));
            }
            // Update StudentsExpense records
            StudentsExpense::whereIn('id', $selectedPaymentsArray)->update(['settled' => 1]);
            // Create new Payment record
            Payment::create($validatedData);
            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('payments.cashInHand.settle')->with('success', 'Payment created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                // Optionally, you can log the error or handle it accordingly
                Log::error($e->getMessage());

                // Redirect with error message
                return redirect()->back()->withErrors(['error' => 'Failed to create payment. Please try again.']);
            }
    }

    // Update an existing payment
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'paid_by' => 'required|exists:users,id',
            'payment_type' => 'required|string|max:20',
            'paid_to' => 'nullable|exists:users,id',
            'paid_date' => 'required|date',
            'detail' => 'nullable|string',
            'payment_slip' => 'nullable|file|mimes:pdf,jpeg,jpg,png,gif|max:2048',
        ]);

        $paymentData = $request->all();

        if ($request->hasFile('payment_slip')) {
            // Delete the old payment slip if it exists
            if ($payment->payment_slip && Storage::exists('payments/' . $payment->payment_slip)) {
                Storage::delete('payments/' . $payment->payment_slip);
            }
            $paymentData['payment_slip'] = $this->handleFileUpload($request->file('payment_slip'));
        }

        $payment->update($paymentData);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    // Handle file upload and resizing
    protected function handleFileUpload($file)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = storage_path('app/public/payments');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Resize the image if it's not a PDF
        if (in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'gif'])) {
            $image = Image::make($file)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save($path . '/' . $filename);
        } else {
            $file->move($path, $filename);
        }

        return $filename;
    }

    // Total paid to each payment type
    public function getTotalByPaymentType()
    {
        $totalsByType = Payment::select('payment_type')
                                ->selectRaw('SUM(amount) as total_amount')
                                ->groupBy('payment_type')
                                ->get();

        return $totalsByType;
    }

    //Total paid to each management user
    public function getTotalPaidByUserForManagement()
    {
        $totalsByUser = Payment::where('payment_type', 'management')
                                ->select('paid_to')
                                ->selectRaw('SUM(amount) as total_amount')
                                ->groupBy('paid_to')
                                ->with('paidTo') // Assuming 'paidTo' is a relationship to get user details
                                ->get();

        return $totalsByUser;
    }

}
