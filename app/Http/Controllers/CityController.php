<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use App\Models\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){

        $regions = Region::get();
        return view('admin.masterdata.cities', compact('regions'));
    }
    public function show()
    {
        $cities = City::all()
        ->map(function($item){
            $item->province_name = $item->Province->name;
            $item->region_id = $item->Province->Region->id;
            $item->region_name = $item->Province->Region->name;
            return $item; 
        });
        return response()->json([
            'city' => $cities,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:cities,name',
            'province_id' => 'required',
        ], [], [
            'name' => 'City Name',
            'province_id' => 'Province',
        ]);
        $data = new City();
        $data->name = $request->name;
        $data->province_id = $request->province_id;
        $data->save();
    }

    public function getProvincesByRegion($id){
        return response()->json([
            'province' => Province::where('region_id', $id)->get()
        ]);
    }

    public function edit($id){
        $data = City::with(['Province.Region'])->where('id', $id)->first();
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100|unique:cities,name,' .$id,
            'province_id' => 'required',
        ], [], [
            'name' => 'City Name',
            'province_id' => 'Province',
        ]);

        $data = City::where('id', $id)->first();
        $data->name = $request->name;
        $data->province_id = $request->province_id;
        $data->save();

        return response()->json([
            'message' => 'City Successfully Updated!'
        ]);
    }
    public function destroy($id){
        $data = City::where('id', $id);
        $data->delete();

        return response()->json([
            'message' => 'City Successfully Deleted'
        ]);
    }
}
