<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except(['showRegistrationForm', 'register']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'designation' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer', 'exists:roles,id'], // Ensure role exists in the roles table
            'course_id' => ['required', 'integer', 'exists:courses,id'], // Ensure course exists in the course table
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'dob' => ['nullable', 'date', 'date_format:Y-m-d'],
        ]);
    }

    protected function create(array $data)
    {
        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'designation' => $data['designation'],
            'role_id' => $data['role'],
            'course_id' => $data['course_id'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
        ]);
    
        // Fetch the role
        $role = Role::findById($data['role']); // $data['role'] is the role ID
    
        // Assign the role to the user
        $user->assignRole($role);
    
        // Return the user
        return $user;
    }
}
