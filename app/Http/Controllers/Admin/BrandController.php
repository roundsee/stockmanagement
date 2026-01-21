<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => ['required'],
                'image' => ['required', 'image', 'max:2048']
            ]);

            $imagePath = $this->uploadImage($request, 'image', 'uploads/brand');
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->image = $imagePath;
            $brand->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Brand created successfully',
                'data' => $brand
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $brands = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        try {
            $validateData = $request->validate([
                'id' => ['required', 'exists:brands,id'],
                'name' => ['required'],
                'image' => ['nullable', 'image', 'max:2048']
            ]);
            $brand = Brand::findOrFail($request->id);
            $brand->name = $request->name;
            if ($request->hasFile('image')) {
                $imagePath = $this->updateImage($request, 'image', 'uploads/brand', $brand->image);
                $brand->image = $imagePath;
            }

            $brand->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Brand updated successfully',
                'data' => $brand
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(string $id)
    {
        $product = Brand::findOrFail($id);
        $this->deleteImage($product->image);

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand deleted successfully!',
        ]);
    }
}
