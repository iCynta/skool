<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelPackageTools\Traits\HasValidations;

class school extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'schools';

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    //public $translatable = ['name']; // Consider translating other fields if needed

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'affiliation_no',
        'phone',
        'email',
        'address',
        'logo', // Optional
    ];

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique|max:255',
            'affiliation_no' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:schools,email',
            'address' => 'required|string',
            'logo' => 'nullable|string', // Optional: Validate image file properties if applicable
        ];
    }

    // Relationships (consider adding these based on your specific requirements)

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
