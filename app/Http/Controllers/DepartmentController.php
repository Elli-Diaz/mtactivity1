<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $company = Company::get();
        return view('admin.masterdata.departments', compact('company'));
    }

    public function show()
    {
        $data = Department::get()
            ->map(function ($item) {
                $item->company_id = $item->Company->company_id;
                $item->company_name = $item->Company->name;
                return $item;
            });
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|max:100|unique:departments,name',
            'budget' => 'required',
        ], [], [
            'company_id' => 'Company Name',
            'name' => 'Department Name',
            'budget' => 'Budget',
            'creation_date' => 'Creation Date',
        ]);
        $data = new Department();
        $data->company_id = $request->company_id;
        $data->name = $request->name;
        $data->budget = $request->budget;
        $data->creation_date = Carbon::now();
        $data->save();
    }

    public function edit($id)
    {
        $data = Department::where('department_id', $id)->first();
        return response()->json([
            'data' => Department::get()
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|max:100|unique:departments,name,' . $id. ',department_id',
            'budget' => 'required',
        ], [], [
            'company_id' => 'Company Name',
            'name' => 'Department Name',
            'budget' => 'Budget',
            'creation_date' => 'Creation Date',
        ]);

        $data = Department::where('department_id', $id)->first();
        $data->company_id = $request->company_id;
        $data->name = $request->name;
        $data->budget = $request->budget;
        $data->creation_date = Carbon::now();
        $data->save();

        return response()->json([
            'message' => 'Department Successfully Updated!'
        ]);
    }
    public function destroy($id)
    {
        $data = Department::where('department_id', $id);
        $data->delete();

        return response()->json([
            'message' => 'Department Successfully Deleted'
        ]);
    }
}
