<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use App\User;

class RolePermissionController extends Controller
{
    public function getAllRole(){
        $roles = Role::all();
        return response()->json(['status' => 'success', 'data' => $roles]);
    }

    public function getAllPermission(){
        $permissions = Permission::all();
        return response()->json(['status' => 'success', 'data' => $permissions]);
    }

    // MENGAMBIL PERMISSION DARI DIMILIKI ROLE TERTENTU
    public function getRolePermission(Request $request){
        // MENGAMBIL NAMA PERMISSION BERDASARKAN ROLE ID NYA DARI GABUNGAN DATA TABLE ROLE_HAS_PERMISSIONS DENGAN PERMISSIONS
        $permissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->select('permissions.name')
            ->where('role_id', $request->role_id)->get();
        return response()->json(['status' => 'success', 'data' => $permissions]);
    }

    // MENGATUR PERMISSION DARI ROLE YANG DIPILIH
    public function setRolePermission(Request $request){
        $this->validate($request, [
            'role_id' => 'required|exists:roles,id',
        ]);

        // MENGAMBIL DATA ROLE BERDASARKAN ID
        $role = Role::find($request->role_id);
        // MENGUBAH DATA PERMISSIONS MILIK ROLE TERKAIT MENJADI DATA PERMISSIONS BARU YANG DIKIRIM KAN DARI REQUEST
        $role->syncPermissions($request->permissions);

        return response()->json(['status' => 'success']);
    }

    // MENGATUR ROLE SETIAP USER
    public function setRoleUser(Request $request){
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'role' => 'required'
        ]);

        // MENGAMBIL DATA USER BERDASARKAN ID
        $user = User::find($request->user_id);
        // MENAMBAHKAN ROLE KE USER
        $user->syncRoles([$request->role]);
        // $user->role = $request->role;
        // $user->save(); 

        return response()->json(['status' => 'success']);
    }
}
