<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Logs;

class FacultyController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('faculty.dashboard');
    }

    public function index()
    {
        $faculty = Faculty::all();
        return view('faculty.index', compact('faculty'));
    }

    public function log()
    {
        $logs = Logs::all(); // or any other logic to retrieve logs
        return view('faculty.logs', compact('logs'));
    }

    public function create()
    {
        return view('faculty.faculty_registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculty,faculty_id|max:100',
            'fname' => 'required|string|max:45',
            'lname' => 'required|string|max:45',
            'rfid_uid' => 'nullable|string|max:255',
        ]);

        // Check if the RFID UID already exists
        if (!empty($request->rfid_uid) && Faculty::where('rfid_uid', $request->rfid_uid)->exists()) {
            return redirect()->back()->with('error', 'RFID UID already exists. Please use a different one.');
        }

        Faculty::create($request->all());

        return redirect()->back()->with('success', 'Faculty registered successfully!');
    }
    
}
