<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Faculty;
use App\Models\LabKey;

class LogsApiController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data (basic checks)
        $validatedData = $request->validate([
            'faculty_id' => 'required|string',
            'key_id' => 'required|integer',
            'details' => 'required|string',
            'date_time_borrowed' => 'nullable|date',
            'date_time_returned' => 'nullable|date|after_or_equal:date_time_borrowed',
        ]);

        // Check if faculty_id exists in the Faculty model
        $faculty = Faculty::where('faculty_id', $request->faculty_id)->first();
        if (!$faculty) {
            return response()->json([
                'message' => 'Invalid faculty_id. No matching faculty found.',
            ], 422);
        }

        // Check if key_id exists in the LabKey model
        $labKey = LabKey::where('key_id', $request->key_id)->first();
        if (!$labKey) {
            return response()->json([
                'message' => 'Invalid key_id. No matching lab key found.',
            ], 422);
        }

        // Create and save the log entry
        $log = Logs::create($validatedData);

        return response()->json([
            'message' => 'Log stored successfully!',
            'log' => $log
        ], 201);
    }
}
