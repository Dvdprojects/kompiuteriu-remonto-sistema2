<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vartotojas = Auth::user();
        return view('profile', compact('vartotojas'));
    }
    public function changePassword(Request $request)
    {
        $vartotojas = Auth::user();
        $request->validate([
            'current_password' => ['required', 'password'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find($vartotojas->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('profile')->with('success', 'Slaptažodis sėkmingai pakeistas.');
    }
    public function profilePost(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required | max:32',
                'surname' => 'required | max:32',
                'phoneNumber' => 'required',
                'city' => 'required | max:32',
            ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $profileForm = User::find(Auth::user()->id);
        $profileForm->name = $request->name;
        $profileForm->surname = $request->surname;
        $profileForm->phone_number = $request->phoneNumber;
        $profileForm->city = $request->city;
        $profileForm->profile_verified = 1;
        $profileForm->save();
        return redirect()->route('profile')->with('success', 'Profilis sėkmingai užpildytas');
    }
}
