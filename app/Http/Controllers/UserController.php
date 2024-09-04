<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        if(Auth::user()->role->name ==='Management'){
            $users = User::orderBy('course_id')->get();
        } else {
            $users = User::where('course_id', Auth::user()->course_id)->orderBy('course_id')->get();
        }

        return view('users.index', compact('users'));
    }
    public function edit($id){

        $user_id = intval($id);
        $user = User::find($user_id);

        // Checking weather user is accessing own profile.
        if (($user->id === Auth::user()->id) || (Auth::user()->role->name === "Management"))
        {
            $roles = Role::all();
            $courses = Course::all();
            return view('users.edit', compact('user', 'roles', 'courses'));
        }
        return redirect()->back()->withErrors(['error' => 'You are not authorized to access the profile.']);

    }

    public function profile($user_id = null)
    {
        if($user_id === null){
            $user_id = Auth::user()->id;
        }
        $user = User::with('course', 'role')->findOrFail($user_id);
        return view('users.view-profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find($request->input('user_id'));
        if ($user) {
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return redirect()->back()->with('success', 'Password updated successfully.');
        }

        return redirect()->back()->with('error', 'User not found.');
    }



    public function update(Request $request)
    {
        $user_id = (int) $request->post('user_id');

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_id)],
            'designation' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer', 'exists:roles,id'], // Ensure role exists in the roles table
            'course_id' => ['required', 'integer', 'exists:courses,id'], // Ensure course exists in the courses table
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'dob' => ['nullable', 'date', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($user_id);

        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->designation = $request->input('designation');
        $user->role_id = $request->input('role');
        $user->course_id = $request->input('course_id');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');

        if($request->input('role'))
        {
            // Fetch the role
            $role = Role::findById($request->input('role')); // $data['role'] is the role ID
            // Assign the role to the user
            $user->assignRole($role);
        }

        // Save the user
        $user->save();
        //return redirect()->route('schools.index')->with('success', 'User details updated successfully');
        return redirect()->route('user.index')->with('success', 'User details updated successfully');
    }
}
