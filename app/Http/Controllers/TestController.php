<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        return view('test');
    }

    public function show() {
        return response()->json([
            'data' => Test::get(),
        ]);
    }

    public function store(Request $request) {
        $data = new Test();
        $data->first_name = $request->first_name;
        $data->middle_name = $request->middle_name;
        $data->last_name = $request->last_name;
        $data->save();

        return response()->json([
            'message' => 'Data Successfully Saved!'
        ]);
    }
}
