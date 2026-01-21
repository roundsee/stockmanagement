<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileCredentialUpdateRequest;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $user = Auth::user();
        return view('admin.user-profile.index', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = auth()->user();

            // Handle image upload via trait
            if ($request->hasFile('image')) {
                $path = 'uploads/users';
                $newImagePath = $this->updateImage($request, 'image', $path, $user->photo);
                $user->photo = $newImagePath;
            }

            // Update user data
            $user->update([
                'name' => $request->name,
                'phone_num' => $request->phone_num,
                'address' => $request->address,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!',
            ], 200);
        } catch (\Exception $e) {
            logger()->error('Profile Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while updating the profile.',
            ], 500);
        }
    }

    public function updateCredential(ProfileCredentialUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $user = auth()->user();
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['status' => false, 'message' => 'Old password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['status' => true, 'message' => 'Profile updated successfully.']);
        } catch (\Exception $e) {
            logger()->error('Profile Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while updating the profile.',
            ], 500);
        }
    }
}
