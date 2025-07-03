<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Employee;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403, 'Access denied. Super Admin access required.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $roles = Role::where('guard_name', 'employee')->with(['users', 'permissions'])->get();
        $permissions = Permission::where('guard_name', 'employee')->get();
        $totalUsers = Employee::count();
        $totalPermissions = $permissions->count();

        return view('roles.index', compact('roles', 'permissions', 'totalUsers', 'totalPermissions'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'employee')->get();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'employee'
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    public function show(Role $role)
    {
        $role->load(['users', 'permissions']);
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin role cannot be modified.');
        }

        $permissions = Permission::where('guard_name', 'employee')->get();
        $role->load('permissions');
        
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('roles.index')->with('error', 'Super Admin role cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return redirect()->route('roles.index')->with('error', 'System roles cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role that has assigned users.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
