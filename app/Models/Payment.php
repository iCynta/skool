<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'paid_by',
        'payment_type',
        'paid_to',
        'amount',
        'detail',
        'payment_slip',
        'selected_payments',
        'paid_date',
    ];

    protected $casts = [
        'selected_payments' => 'array', // Cast selected_payments as an array
    ];

    // public function relatedExpenses()
    // {
    //     return StudentsExpense::whereIn('id', $this->selected_payments ?? [])->get();
    // }    

    public function relatedStudentExpense()
    {
        // Ensure that selected_payments is properly cast to an array
        $selectedPaymentsArray = $this->selected_payments;
    
        if (!is_array($selectedPaymentsArray)) {
            $selectedPaymentsArray = json_decode($selectedPaymentsArray, true) ?? [];
        }
    
        return StudentsExpense::whereIn('id', $selectedPaymentsArray);
    }
    

    public function paidTo()
    {
        return $this->belongsTo(User::class, 'paid_to');
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
