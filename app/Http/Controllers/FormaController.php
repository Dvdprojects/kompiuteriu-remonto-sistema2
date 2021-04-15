<?php

namespace App\Http\Controllers;

use App\Models\Forma;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Validation\Rule;

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
        $vartotojas = Auth::user();
        return view('forma', compact('vartotojas'));
    }
    public function store(Request $request)
    {
        $config = [
            'table' => 'formas',
            'field' => 'saskaitos_nr',
            'length' => '10',
            'prefix' => '999'
        ];
        $idForSas = IdGenerator::generate($config);

        $validator = Validator::make($request->all(),
        [
            'computerBrand' => 'required | max:64',
            'computerModel' => 'required | max:64',
            'comment' => 'required | max:255',
            'delivery' => 'numeric | min: 0 | max: 1',
            'address' => 'max:128',
            'postalCode' => 'max:32',
        ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $registerForm = new \App\Models\Forma;
        $registerForm->computer_brand = $request->computerBrand;
        $registerForm->computer_model = $request->computerModel;
        $registerForm->comment = $request->comment;
        if ($request->delivery == 1)
        {
            $registerForm->address = $request->address;
            $registerForm->postal_code = $request->postalCode;
            $registerForm->delivery = $request->delivery;
        }
        else
        {
            $registerForm->delivery = 0;
            $registerForm->postal_code = "Nenurodyta";
            $registerForm->address = "Nenurodyta";
        }
        $registerForm->user_id = auth()->user()->id;
        $registerForm->busena = "Pateikta";
        $registerForm->saskaitos_nr = $idForSas;
        $registerForm->save();
        return redirect()->route('forma')->with('success', 'Kompiuterio remonto forma pateikta patvirtinimui, apie remonto busena jus informuosime el. pastu.');

    }
    public function showAll()
    {
        $vartotojas = Auth::user();
        if ($vartotojas->role == 1)
        {
            $formaAll = Forma::all();
        }
        else
        {
            $formaAll = Forma::where('user_id', '=', Auth::id())->get();
        }
        return view('formashow', compact('vartotojas', 'formaAll'));
    }
    public function formEdit(Request $request)
    {
        $vartotojas = Auth::user();
        $forms = Forma::find($request->id);
        return view('formaEdit', compact('vartotojas', 'forms'));
    }
    public function formEditPost(Request $request)
    {
        $registerForm = Forma::find($request->id);
        if($registerForm->busena != "Pateikta")
        {
            return redirect()->route('forma-all')->with('error', 'Pateikta forma nebegali būti keičiama.');
        }
        $validator = Validator::make($request->all(),
            [
                'computerBrand' => 'required | max:64',
                'computerModel' => 'required | max:64',
                'comment' => 'required | max:255',
                'delivery' => 'numeric | min: 0 | max: 1',
                'address' => 'required_if:delivery,==,1 | max:128',
                'postalCode' => 'required_if:delivery,==,1 | max:32',
            ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        $registerForm->computer_brand = $request->computerBrand;
        $registerForm->computer_model = $request->computerModel;
        $registerForm->comment = $request->comment;
        if ($request->delivery == 1)
        {
            $registerForm->address = $request->address;
            $registerForm->postal_code = $request->postalCode;
            $registerForm->delivery = $request->delivery;
        }
        else
        {
            $registerForm->delivery = 0;
            $registerForm->postal_code = "Nenurodyta";
            $registerForm->address = "Nenurodyta";
        }
        $registerForm->user_id = auth()->user()->id;
        $registerForm->busena = "Pateikta";
        $registerForm->save();
        return redirect()->route('forma-all')->with('success', 'Kompiuterio remonto forma sekmingai paredaguota, apie remonto busena jus informuosime el. pastu.');
    }
    public function formDelete(Request $request)
    {
        $forms = Forma::find($request->id);
        if($forms->busena != "Pateikta" && Auth::user()->role != 1)
        {
            return redirect()->route('forma-all')->with('error', 'Pateikta forma nebegali būti ištrinta.');
        }
        $forms->delete();
        return redirect()->route('forma-all')->with('success', 'Kompiuterio remonto forma sekmingai istrinta.');
    }
    public function guaranteeDownload(Request $request)
    {
        return $this->showAll();
    }
    public function leaveComment(Request $request)
    {
        $forms = Forma::find($request->id);
        $vartotojas = Auth::user();

        return view('commentsForm', compact('vartotojas', 'forms'));
    }
    public function leaveCommentPost(Request $request)
    {
        $forms = Forma::find($request->id);
        $vartotojas = Auth::user();

        $validator = Validator::make($request->all(),
            [
                'comment' => 'required | max:255',
                'rating' => 'numeric | min: 1 | max: 5',
            ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $commentForm = new \App\Models\Comment;
        $commentForm->rating = $request->rating;
        $commentForm->comment = $request->comment;
        $commentForm->user_id = auth()->user()->id;
        $commentForm->form_id = $forms->id;
        $forms->comment_state = 1;
        $commentForm->save();
        $forms->save();

        return redirect()->route('forma-all')->with('success', 'Komentaras sėkmingai pateiktas.');
    }
    public function showComments(Request $request)
    {
        $vartotojas = Auth::user();
        return view('commentList', compact('vartotojas'));
    }
    public function showDatatable(Request $request)
    {
        $query = Forma::select('computer_brand','computer_model','comment', 'delivery', 'busena', 'sakaitos_nr');
        return datatables($query)->make(true);
    }
}
