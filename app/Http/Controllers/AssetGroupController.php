<?php

namespace App\Http\Controllers;

use App\Models\AssetGroup;
use Illuminate\Http\Request;

class AssetGroupController extends Controller
{
    public function index(){
        $user = auth()-> user();

        return view('admin.masterdata.asset_groups');
    }
    public function getRecords() {
        $asset_groups = AssetGroup::get();

        return response()->json(['asset_group' => $asset_groups],
            200);
    }

   
    public function store(Request $request)
    {
                // Check if email already exists
            if (AssetGroup::where('group_code', $request->group_code)->exists()) {
                return response()->json(['message' => 'Group Code already exists'], 400);
            }

            // Create new user if email is unique
            $data = new AssetGroup();
            $data->group_code = $request->group_code;
            $data->description = $request->description;
            $data->save();

            return response()->json(['message' => 'Asset Group successfully added'], 200);
    }

    public function edit($id)
    {
        $data = AssetGroup::where('id', $id)->first();
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {

        $data= AssetGroup::where('id', $request->id)->first();
        $data->group_code  = $request->group_code;
        $data->description  = $request->description;
        $data->save();

        return response()->json(['message' => 'Asset Group successfully updated'], 200);
    }


    public function destroy($id)
    {
        $data= AssetGroup::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Asset Group successfully deleted'], 200);
    }
}
