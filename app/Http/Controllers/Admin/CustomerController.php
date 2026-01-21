<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function create(){
        return view('admin.customer.create');
    }

    public function store(Request $request){
       try{

        $validateData = $request->validate([
            'name' => ['required'],
            'email' => ['required','email'],
            'phone' => ['required','digits:10'],
            'address' => ['required'],
        ]);
        $customers = new Customer();
        $customers-> name = $request->name;
        $customers-> email = $request->email;
        $customers-> phone = $request->phone;
        $customers-> address = $request->address;

        $customers->save();
        return response()->json([
                'status' => 'success',
                'message' => 'Customer created successfully',
                'data' => $customers
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
        $customers = Customer::findOrFail($id);
        return view('admin.customer.edit',compact('customers'));
    }
    public function update(Request $request){
       try{

        $validateData = $request->validate([
            'id' => ['required', 'exists:customers,id'],
            'name' => ['required'],
            'email' => ['required','email'],
            'phone' => ['required','digits:10'],
            'address' => ['required'],
        ]);
        $customers = Customer::findOrFail($request->id);
        $customers-> name = $request->name;
        $customers-> email = $request->email;
        $customers-> phone = $request->phone;
        $customers-> address = $request->address;

        $customers->save();
        return response()->json([
                'status' => 'success',
                'message' => 'Customer Updated successfully',
                'data' => $customers
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
        $customers = Customer::findOrFail($id);
        $customers->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Customer deleted successfully!',
        ]);
    }
}
