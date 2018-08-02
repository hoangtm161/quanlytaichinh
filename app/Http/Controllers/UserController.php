<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\UserActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        if ($user->can('view',Auth::user())) {
            return view('user.edit', compact('user',$user));
        }
        return view('not_authorization');
    }

    public function update(int $id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($user->can('update',Auth::user())) {
            $validatedData = $request->validate([
                'name' => 'max:50|nullable',
                'address' => 'max:100|nullable',
                'phone_number' => 'numeric|nullable',
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
                'dob' => 'date|nullable',
            ]);

            if (isset($validatedData['avatar']) && $validatedData['avatar'] !== null ) {
                $avatar = $validatedData['avatar'];
                $filename = time().'.'.$avatar->getClientOriginalExtension();
                $avatar->move(public_path('avatars'),$filename);
                $validatedData['avatar']=$filename;
                //delete old avatar if user upload new one
                $oldAvatar = public_path('avatars/').$user->avatar;
                File::delete($oldAvatar);
            }
            $user->update($validatedData);

            return redirect()->route('user.edit',['id'=>$id])->with('status', 'User information updated');
        }
        return view('not_authorization');
    }

    public function changePassword(int $id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($user->can('update',Auth::user())) {
            return view('user.change_password');
        }
        return view('not_authorization');
    }

    public function updatePassword(int $id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($user->can('update',Auth::user())) {
            if (!Hash::check($request->input('current-password'), Auth::user()->password)) {
                return redirect()->back()->with('status-fail','Current password is incorrect');
            } else {
                $validatedData = $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                ]);
                $user->password = Hash::make($validatedData['password']);
                $user->save();
                return redirect()->route('user.changePassword',['id' => $user->id])->with('status','Password changed');
            }
        }
        return view('not_authorization');
    }
}
