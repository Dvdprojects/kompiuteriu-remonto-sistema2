<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
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
        return view('contacts');
    }
    public function sendEmail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | max:64',
            'surname' => 'required | max:64',
            'phoneNumber' => 'required | max:12',
            'emailHeader' => 'max:128',
            'emailText' => 'max:256',
        ]);

        $name = $request->name . ' ' . $request->surname;
        $account = Auth::user()->name . ' ' . Auth::user()->surname;
        $mobile = $request->phoneNumber;
        $subject = $request->emailHeader;
        $text = $request->emailText;
        Mail::to('zygiax12@gmail.com')->send(new CustomerEmail($name, $mobile, $subject,$text, $account));

        return redirect()->route('contacts')->with('success', 'Laiškas sėkmingai išsiūstas, susisieksime su jumis kaip galima greičiau.');
    }
}
