<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $region = Region::get();
        return view('admin.masterdata.provinces', compact('region'));
    }

    public function show()
    {
        $data = Province::get()
        ->map(function($item){
            $item->region_id = $item->Region->id;
            $item->region_name = $item->Region->name;
            return $item; 
        });
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:provinces,name',
            'region_id' => 'required',
        ], [], [
            'name' => 'Province',
            'region_id' => 'Region',
        ]);
        $data = new Province();
        $data->name = $request->name;
        $data->region_id = $request->region_id;
        $data->save();
    }

    public function edit($id){
        $data = Province::where('id', $id)->first();
        return response()->json([
            'data' => Province::get()
        ]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100',
            'region_id' => 'required',
        ], [], [
            'name' => 'Province',
            'region_id' => 'Region',
        ]);

        $data = Province::where('id', $id)->first();
        $data->name = $request->name;
        $data->region_id = $request->region_id;
        $data->save();

        return response()->json([
            'message' => 'Province Successfully Updated!'
        ]);
    }
    public function destroy($id){
        $data = Province::where('id', $id);
        $data->delete();

        return response()->json([
            'message' => 'Province Successfully Deleted'
        ]);
    }
}
