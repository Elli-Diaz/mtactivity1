<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

        $companies = Company::get();
        return view('admin.masterdata.employees', compact('companies'));
    }
    public function show()
    {
        $employees = Employee::all()
        ->map(function($item){
            $department_name = Department::where('department_id', $item->department_id)->first();
            $company_name = Company::where('company_id', $item->company_id)->first();
            $item->department_name = $department_name->name;
            $item->company_name = $company_name->name;
            // $item->department_name = $item->Department->name;
            // $item->company_id = $item->Department->Company->company_id;
            // $item->company_name = $item->Department->Company->name;
            return $item; 
        });
        return response()->json([
            'data' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'company_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'job_title' => 'required',
            'hire_date' => 'required',
        ], [], [
            'department_id' => 'Department Name',
            'company_id' => 'Company Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'job_title' => 'Job Title',
            'hire_date' => 'Hire Date',
        ]);
        $data = new Employee();
        $data->department_id = $request->department_id;
        $data->company_id = $request->company_id;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        $data->phone_number = $request->phone_number;
        $data->job_title = $request->job_title;
        $data->hire_date = $request->hire_date;
        $data->save();
    }

    public function getDepartmentsByCompany($id){

        
        return response()->json([
            'department' => Department::where('company_id', $id)->get()
        ]);
    }

    public function edit($id){
        $data = Employee::with(['Department.Company'])->where('id', $id)->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'department_id' => 'required',
            'company_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'job_title' => 'required',
            'hire_date' => 'required',
        ], [], [
            'department_id' => 'Department Name',
            'company_id' => 'Company Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'job_title' => 'Job Title',
            'hire_date' => 'Hire Date',
        ]);

        $data = Employee::where('id', $id)->first();
        $data->department_id = $request->department_id;
        $data->company_id = $request->company_id;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        $data->phone_number = $request->phone_number;
        $data->job_title = $request->job_title;
        $data->hire_date = $request->hire_date;
        $data->save();

        return response()->json([
            'message' => 'User Successfully Updated!'
        ]);
    }
    public function destroy($id){
        $data = Employee::where('id', $id);
        $data->delete();

        return response()->json([
            'message' => 'User Successfully Deleted'
        ]);
    }
}
