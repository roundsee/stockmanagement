<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('admin.supplier.index', compact('suppliers'));
    }
    public function create(){
        return view('admin.supplier.create');
    }
    public function store(Request $request){
        // dd($request->all());
        try{
            $validation = $request->validate([
                'name' => ['required'],
                'email' => ['required','email'],
                'phone' => ['required','digits:10'],
                'address' => ['required']
            ]);

            $supplier = new Supplier();
            $supplier->name=$request->name; 
            $supplier->email=$request->email; 
            $supplier->phone=$request->phone; 
            $supplier->address=$request->address; 
            $supplier->save();
          return response()->json([
                'status' => 'success',
                'message' => 'Supplier created successfully',
                'data' => $supplier
            ], 201);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id){
        $suppliers=Supplier::findOrFail($id);
        return view('admin.supplier.edit',compact('suppliers'));
    }
    public function update(Request $request){
         try{
            $validation = $request->validate([
                'id' => ['required', 'exists:suppliers,id'],
                'name' => ['required'],
                'email' => ['required','email'],
                'phone' => ['required','digits:10'],
                'address' => ['required']
            ]);

            $supplier = Supplier::findOrFail($request->id);
            $supplier->name=$request->name; 
            $supplier->email=$request->email; 
            $supplier->phone=$request->phone; 
            $supplier->address=$request->address; 
            $supplier->save();
          return response()->json([
                'status' => 'success',
                'message' => 'Supplier Updated successfully',
                'data' => $supplier
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
        $suppliers=Supplier::findOrFail($id);
        $suppliers->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Supplier deleted successfully!',
        ]);
    }
    }

