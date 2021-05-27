<?php

namespace App\Http\Controllers;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(20);
            $roles = Role::orderBy('name')->get();
            $companies = Company::where('status', 1)->orderBy('name')->get();
            return view('user.index', compact('users', 'roles', 'companies'));
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        try {
            $user = User::create([
                'name' => $request->username,
                'role_id' => $request->role_id,
                'company_id' => $request->company_id,
                'email' => $request->email,
                'password' => Hash::make($request->paswword),
            ]);
            if ($request->filled('telegramuserid')){
                $user->update(['telegram_user_id' => '@'. $request->telegramuserid]);
            }
            return redirect()->route('users.index')->with('success', 'Successfully created!');
        }catch (\Exception $exception){
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
       abort(404);
    }

    public function destroy(User $user)
    {
        try {
            $user->forceDelete();
            return back()->with('success', 'Successfully deleted!');
        }catch (\Exception $exception){
            return back()->withErrors($exception->getMessage());
        }
    }

}
