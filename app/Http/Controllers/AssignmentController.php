<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(){
        $name = "Ellijah";
        $age = 20;
        return view('admin.masterdata.assignment', compact('name', 'age'));
    }
}
