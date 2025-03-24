<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Logs;
use App\Models\Admin;
use App\Models\LabKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function welcome()
    {
        return view('loader.welcome');
    }

    public function app()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        return view('admin.app');
    }

    public function loader()
    {
        return view('loader.loader');
    }

    public function login()
    {
        return view('admin.login');
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Redirect to loader view first, then go to dashboard
            return response()->view('loader.loader', [
                'redirectUrl' => route('admin.dashboard')
            ]);
        }

        return back()->withInput()->with('error', 'Invalid username or password.');
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');  // Change here to 'login'
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        // Count total faculty members
        $facultyCount = Faculty::count();

        // Retrieve the last 3 recently borrowed keys with faculty name and laboratory
        $recentlyBorrowed = Logs::with(['faculty', 'labKey'])
            ->orderBy('date_time_borrowed', 'desc')
            ->limit(3)
            ->get();

        // Count the number of keys currently borrowed (not yet returned)
        $borrowedKeysCount = Logs::whereNull('date_time_returned')->count();

        return view('admin.dashboard', compact('facultyCount', 'recentlyBorrowed', 'borrowedKeysCount'));
    }

    public function createFaculty()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        return view('admin.registration');
    }

    public function toggleStatus($faculty_id)
    {
        $faculty = Faculty::findOrFail($faculty_id);

        // Toggle status
        $faculty->status = $faculty->status === 'Enabled' ? 'Disabled' : 'Enabled';
        $faculty->save();

        return redirect()->back()->with('success', 'Faculty status updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculty,faculty_id|max:100',
            'fname' => 'required|string|max:45',
            'lname' => 'required|string|max:45',
            'rfid_uid' => 'nullable|string|max:255',
        ]);

        if (!empty($request->rfid_uid) && Faculty::where('rfid_uid', $request->rfid_uid)->exists()) {
            return redirect()->back()->with('error', 'RFID UID already exists. Please use a different one.');
        }

        // Get the currently logged-in admin's ID
        $adminId = Auth::guard('admin')->user()->admin_id;


        // Create faculty with additional fields
        Faculty::create([
            'faculty_id' => $request->faculty_id,
            'rfid_uid' => $request->rfid_uid,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix' => $request->suffix,
            'admin_id' => $adminId,  // Store the admin who added the faculty
            'status' => 'Enabled',   // Default status
        ]);

        return redirect()->back()->with('success', 'Faculty registered successfully!');
    }

    public function labKeys()
    {
        // Retrieve all lab keys
        $labKeys = LabKey::all();

        // Pass the data to the view
        return view('admin.labkeys', compact('labKeys'));
    }

    public function storeLabKey(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'key_id' => 'required|unique:lab_keys,key_id',
            'laboratory' => 'required|string|max:255',
        ]);

        // Create a new LabKey record
        LabKey::create([
            'key_id' => $request->key_id,
            'laboratory' => $request->laboratory,
        ]);

        // Redirect back with success message
        return back()->with('success', 'Laboratory Key Registered Successfully!');
    }

    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        $faculty = Faculty::all();
        return view('admin.list', compact('faculty'));
    }

    public function log()
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Access denied.');
        }

        // Retrieve logs with related faculty and key information
        $logs = Logs::with(['faculty', 'labKey'])->orderBy('date_time_borrowed', 'desc')->get();

        return view('admin.logs', compact('logs'));
    }
}
