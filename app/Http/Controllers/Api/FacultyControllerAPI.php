<?php

namespace App\Http\Controllers\Api; // ✅ Correct namespace

use App\Http\Controllers\Controller;
use App\Models\Faculty; // ✅ Ensure this model exists
use Illuminate\Http\Request;

class FacultyControllerAPI extends Controller {
    public function index() {
        return response()->json(Faculty::all());
    }

    public function show($id) {
        return response()->json(Faculty::find($id));
    }

    public function store(Request $request) {
        $faculty = Faculty::create($request->all());
        return response()->json($faculty, 201);
    }

    public function update(Request $request, $id) {
        $faculty = Faculty::findOrFail($id);
        $faculty->update($request->all());
        return response()->json($faculty);
    }

    public function destroy($id) {
        Faculty::destroy($id);
        return response()->json(null, 204);
    }

}




