<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function index()
    {
        return view('admin.masterdata.regions');
    }

    public function show()
    {
        return response()->json([
            'data' => Region::get()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|max:100|unique:regions,name',
        ], [], [
            'name' => 'Region',
        ]);
        $data = new Region();
        $data->name = $request->name;
        $data->save();

        return response()->json([
            'message' => 'Region Successfully Saved!'
        ]);
    }

    public function edit($id)
    {
        $data = Region::where('id', $id)->first();
        return response()->json([
            'data' => Region::get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:regions,name,' .$id,
        ], [], [
            'name' => 'Region',
        ]);

        $data = Region::where('id', $id)->first();
        $data->name = $request->name;
        $data->save();

        return response()->json([
            'message' => 'Region successfully Updated!'
        ]);
    }

    public function destroy($id)
    {
        $data = Region::where('id', $id);
        $data->delete();

        return response()->json([
            'message' => 'Region successfully deleted'
        ]);
    }
}
