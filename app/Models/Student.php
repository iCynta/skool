<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'dob',
        'contact_number',
        'contact_person',
        'student_relation',
        'seat_type',
        'donation',
        'referred_by',
        'admission_no',
        'course_id',
        'batch_id',
        'department_id',
        'gender',
        'address'
    ];

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

