<?php

namespace App\Http\Controllers\Api; // ✅ Correct namespace

use App\Http\Controllers\Controller;
use App\Models\LabKey; // ✅ Ensure this model exists
use Illuminate\Http\Request;

class LabKeyControllerAPI extends Controller {
    public function index() {
        return response()->json(LabKey::all());
    }

    public function show($id) {
        return response()->json(LabKey::find($id));
    }

    public function store(Request $request) {
        $LabKey = LabKey::create($request->all());
        return response()->json($LabKey, 201);
    }

    public function update(Request $request, $id) {
        $LabKey = LabKey::findOrFail($id);
        $LabKey->update($request->all());
        return response()->json($LabKey);
    }

    public function destroy($id) {
        LabKey::destroy($id);
        return response()->json(null, 204);
    }
}

