<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function allPermission()
    {
        $permission = Permission::all();
        return view('admin.role_permission.permission.index', compact('permission'));
    }

    public function permission()
    {
        return view('admin.role_permission.permission.create');
    }

    public function storePermission(Request $request)
    {
        // normalize inputs
        $data = $request->only(['name', 'group_name']);
        $data['name'] = trim(preg_replace('/\s+/', ' ', $data['name'] ?? ''));
        $data['group_name'] = trim($data['group_name'] ?? '');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:191',
                // unique by name; if you want uniqueness per group_name, add Rule::unique with a where()
                Rule::unique('permissions', 'name'),
            ],
            'group_name' => ['required', 'string', 'max:191'],
        ]);

        try {
            // If you're using spatie/laravel-permission:
            $permission = Permission::create([
                'name'       => $data['name'],
                'group_name' => $data['group_name'], // ensure this column exists in your permissions table
                'guard_name' => 'web',                // required by spatie
            ]);

            // Clear spatie permission cache
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return redirect()
                ->route('admin.all.permission')
                ->with([
                    'message' => 'Permission created successfully.',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['name' => 'Failed to create permission.']);
        }
    }
    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'permission deleted successfully'
        ]);
    }

    public function editPermission($id)
    {

        $permission = Permission::findOrFail($id);


        return view('admin.role_permission.permission.edit', compact('permission'));
    }

    public function updatePermission(Request $request, $id)
    {
        $data = $request->only(['name', 'group_name']);
        $data['name'] = trim(preg_replace('/\s+/', ' ', $data['name'] ?? ''));
        $data['group_name'] = trim($data['group_name'] ?? '');

        // Validate input
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('permissions', 'name')->ignore($id), // Ignore current record when checking uniqueness
            ],
            'group_name' => ['required', 'string', 'max:191'],
        ]);

        try {
            // Find the existing permission
            $permission = Permission::findOrFail($id);

            // Update the record
            $permission->update([
                'name'       => $data['name'],
                'group_name' => $data['group_name'],
                'guard_name' => $permission->guard_name ?? 'web', // Keep existing guard_name
            ]);

            // Clear Spatie permission cache
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return redirect()
                ->route('admin.all.permission')
                ->with([
                    'message' => 'Permission updated successfully.',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors(['name' => 'Failed to update permission.']);
        }
    }

    public function getAllrole()
    {
        $roles = Role::all();
        return view('admin.role_permission.role.index', compact('roles'));
    }

    public function storeRoll(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'roleName' => 'required|string|max:255|unique:roles,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()
                ], 422);
            }

            // Create role
            $role = Role::create(['name' => $request->roleName]);

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully.',
                'data'    => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deleteRole($id)
    {
        $userRole = Role::findOrFail($id);
        $userRole->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully'
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        // dd($request->all());
        try {

            $validator = Validator::make($request->all(), [
                'roleName' => 'required|string|max:255|unique:roles,name,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()
                ], 422);
            }


            $role = Role::findOrFail($id);
            $role->name = $request->roleName;
            $role->save();

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully.',
                'data'    => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    //  
    function addRoleInPermission()
    {
        $roles = Role::all();
        $permission = Permission::all();
        $permissionGroups = User::getpermissionGroups();
        return view('admin.role_permission.role_in_permission.index', compact(
            'roles',
            'permission',
            'permissionGroups'
        ));
    }
    // Store ROle In Permission
    function storeRoleInPermission(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|array|min:1',
            'permission.*' => 'exists:permissions,id',
        ]);
        DB::table('role_has_permissions')->where('role_id', $request->role_id)->delete();

        $data = [];

        foreach ($request->permission as $permissionId) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $permissionId,
            ];
        }


        DB::table('role_has_permissions')->insert($data);

        return response()->json(['message' => 'Permissions assigned successfully.']);
    }

    function listAllRoleInPermission()
    {
        $roles = Role::with('permissions')->get();

        return view('admin.role_permission.role_in_permission.list', compact('roles'));
    }

    function editRoleInPermission($id)
    {
        $role = Role::findOrFail($id);
        $permissionGroups = User::getPermissionGroups();
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return view('admin.role_permission.role_in_permission.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }


    public function updateRoleInPermission(Request $request, $id)
    {
        $request->validate([
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();

        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Permissions updated successfully.']);
    }



    public function deleteRoleInPermission($id)
    {
        DB::table('role_has_permissions')->where('role_id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'All permissions removed from this role successfully!'
        ]);
    }

    function listAllUser()
    {
        $alladmin = User::whereNotNull('role')->latest()->get();
        return view('admin.role_permission.admin.index', compact('alladmin'));
    }

    function createAllUser()
    {
        $roles = Role::all();
        return view('admin.role_permission.admin.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'roles'    => 'required|exists:roles,id',
            ]);

            DB::beginTransaction();

            $role = Role::where('id', $validated['roles'])
                ->where('guard_name', 'web')
                ->first();

            if (!$role) {
                throw new \Exception("Invalid role selected.");
            }

            // Create user and dynamically set the 'role' column
            $user = new User();
            $user->name     = $validated['name'];
            $user->email    = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->role     = $role->name; // 👈 dynamic role name from DB (e.g., 'superadmin', 'manager')
            $user->save();

            // Assign Spatie role
            $user->assignRole($role->name);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User created successfully!',
                'user'    => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role, // from users table
                    'roles' => $user->getRoleNames(), // from Spatie
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while creating user.',
                'error'   => app()->isLocal() ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'User deleted successfully!',
        ]);
    }

    public function editUser($id)
    {
        $roles = Role::all();
        $users = User::findOrFail($id);
        return view('admin.role_permission.admin.edit', compact('users', 'roles'));
    }
    public function updateUser(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6', // optional password
                'roles' => 'required|exists:roles,id',
            ]);

            DB::beginTransaction();

            $user = User::findOrFail($id);

            $role = Role::where('id', $validated['roles'])
                ->where('guard_name', 'web')
                ->first();

            if (!$role) {
                throw new \Exception("Invalid role selected.");
            }

            // Update user info
            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->role = $role->name;
            $user->save();

            $user->syncRoles([$role->name]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'User updated successfully!',
                'user'    => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                    'roles' => $user->getRoleNames(),
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong while updating user.',
                'error'   => app()->isLocal() ? $e->getMessage() : null,
            ], 500);
        }
    }
}
