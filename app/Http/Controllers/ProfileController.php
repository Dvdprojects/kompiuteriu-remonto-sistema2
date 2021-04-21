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
        return view('profile');
    }
    public function changePassword(Request $request)
    {
        $this->validate($request,[
            'current_password' => ['required', 'password'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        Auth::user()->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('profile')->with('success', 'Slaptažodis sėkmingai pakeistas.');
    }
    public function profilePost(Request $request)
    {
            $this->validate($request,             [
                'name' => 'required | max:32',
                'surname' => 'required | max:32',
                'phoneNumber' => 'required',
                'city' => 'required | max:32',
            ]);

        $profileForm = Auth::user();
        $profileForm->name = $request->name;
        $profileForm->surname = $request->surname;
        $profileForm->phone_number = $request->phoneNumber;
        $profileForm->city = $request->city;
        $profileForm->profile_verified = 1;
        $profileForm->save();
        return redirect()->route('profile')->with('success', 'Profilis sėkmingai užpildytas');
    }
}
