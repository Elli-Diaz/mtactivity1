<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Department;
use App\Exports\TestExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {

        $companies = Company::get();
        return view('admin.masterdata.employees', compact('companies'));
    }
    public function show()
    {
        $employees = Employee::all()
            ->map(function ($item) {
                $department_name = Department::where('department_id', $item->department_id)->first();
                $company_name = Company::where('company_id', $item->company_id)->first();
                $item->department_name = $department_name->name;
                $item->company_name = $company_name->name;
                return $item;
            });
        return response()->json([
            'data' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'company_id' => 'required|exists:companies,company_id',
            'first_name' => 'required|string|min:2|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|min:2|max:11|unique:employees,phone_number',
            'job_title' => 'required|string|min:2|max:100',
            'hire_date' => 'required|date|before_or_equal:today',
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

        return response()->json([
            'message' => 'User Successfully Added!'
        ]);
    }

    public function getDepartmentsByCompany($id)
    {
        return response()->json([
            'department' => Department::where('company_id', $id)->get()
        ]);
    }

    public function edit($id)
    {
        $data = Employee::with(['Department.Company'])->where('id', $id)->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,department_id',
            'company_id' => 'required|exists:companies,company_id',
            'first_name' => 'required|string|min:2|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|unique:employees,phone_number,' . $id,
            'job_title' => 'required|string|min:2|max:100',
            'hire_date' => 'required|date|before_or_equal:today',
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
    public function destroy($id)
    {
        $data = Employee::where('id', $id);
        $data->delete();

        return response()->json([
            'message' => 'User Successfully Deleted'
        ]);
    }

    public function export_excel()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            $object = [
                'ID' => $employee->id,
                'Department' => $employee->department_id,
                'Company' => $employee->company_id,
                'First Name' => $employee->first_name,
                'Last Name' => $employee->last_name,
                'Email' => $employee->email,
                'Phone Number' => $employee->phone_number,
                'Job Title' => $employee->job_title,
                'Hired Date' => $employee->hire_date,
            ];
            $data[] = $object;
        }
        // dd($data);
        $currDateTime = Carbon::now()->format('Y-m-d H:i:s');
        return Excel::download(new TestExport($data), 'UserDataReport' . '_' . $currDateTime . '.xlsx');
    }
    public function print()
    {
        $employees = Employee::all();
        return view('admin.masterdata.user_report', compact('employees'));
    }
}
