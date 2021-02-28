<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class FormaController extends Controller
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
        return view('forma');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'vardas' => 'required | max:64',
            'pavarde' => 'required | max:64',
            'pristatymo_budas' => 'required | numeric | min:0 |max:1',
            'apmokejimas' => 'required | numeric | min:0 |max:1',
            'komentaras' => 'required | max:512',
            'tipas' => 'required | max:64',
        ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $registerForm = new \App\Models\Forma;
        $registerForm->vardas = $request['vardas'];
        $registerForm->pavarde = $request['pavarde'];
        $registerForm->pristatymo_budas = $request['pristatymo_budas'];
        $registerForm->apmokejimas = $request['apmokejimas'];
        $registerForm->komentaras = $request['komentaras'];
        $registerForm->tipas = $request['tipas'];
        $registerForm->vartotojo_id = auth()->user()->id;
        $registerForm->busena = "Pateikta";
        $registerForm->save();
        return redirect()->route('forma')->with('success', 'Kompiuterio remonto forma pateikta patvirtinimui, apie remonto busena jus informuosime el. pastu.');

    }
    public function showAll(Request $request)
    {
        $vartotojas = Auth::user();
        $formaAll = DB::table('formas')->where('vartotojo_id', '=', Auth::id())->get();
        return view('formashow', compact('vartotojas', 'formaAll'));
    }
}
