<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\DataTables\RoleDataTable;
use App\Http\Requests\RoleRequest;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    public function index(RoleDataTable $dataTable)
    {
        $title = 'Role Akses';
        return $dataTable->render('pages.role.index', compact('title'));
    }

    public function create()
    {
        $title = 'Form Role';
        return view('pages.role.create', compact('title'));
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->validated());
        Alert::success('Data berhasil ditambahkan')->toToast()->autoClose(4000)->timerProgressBar()->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('role.index');
    }

    public function show(Role $role) {}

    public function edit(Role $role)
    {
        $title = 'Edit Role';
        return view('pages.role.edit', compact('title', 'role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        Alert::success('Data berhasil diupdate')->toToast()->autoClose(4000)->timerProgressBar()->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('role.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        Alert::success('Data berhasil dihapus')->toToast()->autoClose(4000)->timerProgressBar()->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('role.index');
    }

    public function editPermission(Role $role)
    {
        $title = 'Setting Izin Akses - ' . $role->nama_role;
        $permissions = Permission::all()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('pages.role.setting', compact('role', 'permissions', 'rolePermissions', 'title'));
    }

    public function updatePermission(\Illuminate\Http\Request $request, Role $role)
    {
        $role->permissions()->sync($request->permissions ?? []);
        Alert::success('Izin akses berhasil diperbarui')->toToast()->autoClose(4000)->timerProgressBar()->iconHtml('<i class="fa fa-check-circle"></i>');
        return redirect()->route('role.index');
    }
}
