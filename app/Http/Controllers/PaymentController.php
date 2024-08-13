<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class PaymentController extends Controller
{
    // Create payment
    public function create()
    {
        return view('payment.create');
    }
    // Store a new payment
    public function store(Request $request)
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
            $paymentData['payment_slip'] = $this->handleFileUpload($request->file('payment_slip'));
        }

        Payment::create($paymentData);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
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
}
