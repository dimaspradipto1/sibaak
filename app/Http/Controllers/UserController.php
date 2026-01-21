<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        $title = 'Pengguna';
        return $dataTable->render('pages.users.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(60),

            // role flags (boleh lebih dari satu, sama seperti update)
            'is_admin'      => $request->has('is_admin') ? 1 : 0,
            'is_mahasiswa'  => $request->has('is_mahasiswa') ? 1 : 0,
            'is_tata_usaha' => $request->has('is_tata_usaha') ? 1 : 0,
            'is_approval'   => $request->has('is_approval') ? 1 : 0,
            'is_staffbaak'  => $request->has('is_staffbaak') ? 1 : 0,
        ];

        User::create($data);

        Alert::success('success', 'user created successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_admin' => $request->has('is_admin') ? 1 : 0,
            'is_mahasiswa' => $request->has('is_mahasiswa') ? 1 : 0,
            'is_tata_usaha' => $request->has('is_tata_usaha') ? 1 : 0,
            'is_approval' => $request->has('is_approval') ? 1 : 0,
        ]);

        $updateData = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
        ];

        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        Alert::success('success', 'data updated successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('success', 'data deleted successfully')
            ->autoclose(4000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="fa-solid fa-thumbs-up"></i>');
        return redirect()->route('users.index');
    }

    public function showUpdatePasswordForm($id)
    {
        $users = User::findOrFail($id);
        return view('pages.users.updatePassword', compact('users'));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make($request->new_password);
        $user->save();
        Alert::success('success', 'data updated successfully')->autoclose(2000)->toToast();
        return redirect()->route('users.index');
    }
}
