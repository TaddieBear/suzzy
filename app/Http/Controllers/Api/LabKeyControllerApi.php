<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabKey;
use Illuminate\Http\Request;

class LabKeyControllerApi extends Controller
{
    public function index() {
        return response()->json(LabKey::all());
    }

    public function show($id) {
        return response()->json(LabKey::find($id));
    }
}
