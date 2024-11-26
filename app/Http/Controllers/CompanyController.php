<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.masterdata.companies');
    }

    public function show()
    {
        return response()->json([
            'data' => Company::get()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|max:100|unique:companies,name',
            'address' => 'required|max:100',
            'established_date' => 'required|date|before_or_equal:today',

        ], [], [
            'name' => 'Company Name',
            'address' => 'Company Address',
            'established_date' => 'Established Date',
        ]);
        $data = new Company();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->established_date = $request->established_date;
        $data->save();

        return response()->json([
            'message' => 'Company Successfully Saved!'
        ]);
    }

    public function edit($id)
    {
        $data = Company::where('id', $id)->first();
        return response()->json([
            'data' => Company::get()
        ]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:100|unique:companies,name,' . $id . ',company_id',
        'address' => 'required|max:100',
        'established_date' => 'required|date|before_or_equal:today',
    ], [], [
        'name' => 'Company Name',
        'address' => 'Company Address',
        'established_date' => 'Established Date',
    ]);

    $data = Company::where('company_id', $id)->firstOrFail();
    $data->name = $request->name;
    $data->address = $request->address;
    $data->established_date = $request->established_date;
    $data->save();

    return response()->json([
        'message' => 'Company successfully updated!',
    ]);
}


public function destroy($id)
{
    $data = Company::where('company_id', $id)->firstOrFail();
    $data->delete();

    return response()->json([
        'message' => 'Company successfully deleted',
    ]);
}

}
