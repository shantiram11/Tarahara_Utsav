<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // The view now loads data via Ajax DataTables
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    /**
     * Return users data as JSON for DataTables (client-side processing).
     */
    public function data(Request $request)
    {
        $users = User::orderByDesc('created_at')
            ->get(['id', 'name', 'email', 'created_at'])
            ->map(function ($u) {
                $editUrl = route('admin.users.edit', $u->id);
                $deleteUrl = route('admin.users.destroy', $u->id);
                $csrf = csrf_token();
                $form = '<form method="POST" action="'.$deleteUrl.'" onsubmit="return confirm(\'Delete this user?\');" style="display:inline-block">'
                    .'<input type="hidden" name="_token" value="'.$csrf.'">'
                    .'<input type="hidden" name="_method" value="DELETE">'
                    .'<button type="submit" class="btn btn-sm btn-danger">Delete</button>'
                    .'</form>';
                $actions = '<a href="'.$editUrl.'" class="btn btn-sm btn-primary me-1">Edit</a>'.$form;
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'created_at' => optional($u->created_at)->format('Y-m-d H:i'),
                    'actions' => $actions,
                ];
            });

        return response()->json($users);
    }
}
