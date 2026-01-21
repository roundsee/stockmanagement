<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Log;

class WareHouseController extends Controller
{
    public function index()
    {
        $warehouses = WareHouse::latest()->get();
        return view('admin.ware-house.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.ware-house.create');
    }
    public function store(Request $request){
        try{
             $validateData = $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'phone' => ['required', 'digits:10'],
                'city' => ['required']
            ]);

            $warehouses = new WareHouse();
            $warehouses->name=$request->name;
            $warehouses->email=$request->email;
            $warehouses->phone=$request->phone;
            $warehouses->city=$request->city;
            $warehouses->save();
            return response()->json([
                'status' => 'success',
                'message' => 'wareHouse created successfully',
                'data' => $warehouses
            ], 201);
        }catch(\Exception $e){
            Log::Info($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id){
        $warehouses= WareHouse::findOrFail($id);
        return view('admin.ware-house.edit',compact('warehouses'));
    }

    public function update(Request $request){
         try{
             $validateData = $request->validate([
                'id' => ['required', 'exists:ware_houses,id'],
                'name' => ['required'],
                'email' => ['required'],
                'phone' => ['required'],
                'city' => ['required']
            ]);

            $warehouses =WareHouse::findOrFail($request->id);
            $warehouses->name=$request->name;
            $warehouses->email=$request->email;
            $warehouses->phone=$request->phone;
            $warehouses->city=$request->city;
            $warehouses->save();
            return response()->json([
                'status' => 'success',
                'message' => 'wareHouse updated successfully',
                'data' => $warehouses
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function delete(string $id){
        $warehouses=WareHouse::findOrFail($id);
        $warehouses->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Ware-house deleted successfully!',
        ]);
    }
    }
