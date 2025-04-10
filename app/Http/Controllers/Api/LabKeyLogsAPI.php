<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logs;
use App\Models\Faculty;
use App\Models\LabKey;
use Carbon\Carbon;

class LogControllerAPI extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculty,faculty_id',
            'key_id' => 'required|exists:lab_keys,key_id',
            'action' => 'required|in:borrow,return', // Borrow or return
            'borrow_wireless_hdmi' => 'nullable|boolean', // Only affects details
        ]);

        $faculty_id = $request->faculty_id;
        $key_id = $request->key_id;
        $action = $request->action;
        $borrow_wireless_hdmi = $request->borrow_wireless_hdmi;

        if ($action === 'borrow') {
            // Check if the key is already borrowed and not yet returned
            $existingLog = Logs::where('key_id', $key_id)
                ->whereNull('date_time_returned')
                ->first();

            if ($existingLog) {
                return response()->json(['error' => 'Key is already borrowed and not yet returned.'], 400);
            }

            // Create a new borrow log
            $log = Logs::create([
                'faculty_id' => $faculty_id,
                'key_id' => $key_id,
                'details' => $borrow_wireless_hdmi ? 'Borrowed Key. Also took Wireless HDMI.' : 'Borrowed Key.',
                'date_time_borrowed' => Carbon::now(),
                'date_time_returned' => null, // Not yet returned
            ]);

            return response()->json(['message' => 'Key borrowed successfully', 'log' => $log], 201);
        } elseif ($action === 'return') {
            // Find the last borrowed log where the key was not yet returned
            $log = Logs::where('faculty_id', $faculty_id)
                ->where('key_id', $key_id)
                ->whereNull('date_time_returned')
                ->latest()
                ->first();

            if (!$log) {
                return response()->json(['error' => 'No active borrowing record found.'], 400);
            }

            // Update the return date
            $log->update([
                'date_time_returned' => Carbon::now(),
                'details' => 'Returned Key.',
            ]);

            return response()->json(['message' => 'Key returned successfully', 'log' => $log], 200);
        }

        return response()->json(['error' => 'Invalid action.'], 400);
    }
}
