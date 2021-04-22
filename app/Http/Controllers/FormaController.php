<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
use App\Mail\StateMail;
use App\Models\Forma;
use App\Models\Forum;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
        return view('forma');
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

        $this->validate($request, [
            'computerBrand' => 'required | max:64',
            'computerModel' => 'required | max:64',
            'comment' => 'required | max:255',
            'delivery' => 'numeric | min: 0 | max: 1',
            'address' => 'max:128',
            'postalCode' => 'max:32',
        ]);

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
        $registerForm->user()->associate(Auth::user());
        $registerForm->busena = "Pateikta";
        $registerForm->saskaitos_nr = $idForSas;
        $registerForm->save();
        return redirect()->route('forma')->with('success', 'Kompiuterio remonto forma pateikta patvirtinimui, apie remonto busena jus informuosime el. pastu.');

    }
    public function showAll()
    {
        if (Auth::user()->role == 1)
        {
            $formaAll = Forma::all();
        }
        else
        {
            $formaAll = Auth::user()->forms;
        }
        return view('formashow', compact('formaAll'));
    }
    public function formEdit(Request $request, $id)
    {
        if (Auth::user()->role == 1)
        {
            $forms = Forma::findOrFail($id);
        }
        else
        {
            $forms = Auth::user()->forms()->findOrFail($id);
        }
        return view('formaEdit', compact('forms'));
    }
    public function formEditPost(Request $request, $id)
    {
        if (Auth::user()->role == 1)
        {
            $this->validate($request, [
                'computerBrand' => 'required | max:64',
                'computerModel' => 'required | max:64',
                'comment' => 'required | max:255',
                'delivery' => 'numeric | min: 0 | max: 1',
                'address' => 'required_if:delivery,==,1 | max:128',
                'postalCode' => 'required_if:delivery,==,1 | max:32',
                'busena' => 'required|max:32',
            ]);
        }
        else
        {
            $this->validate($request, [
                'computerBrand' => 'required | max:64',
                'computerModel' => 'required | max:64',
                'comment' => 'required | max:255',
                'delivery' => 'numeric | min: 0 | max: 1',
                'address' => 'required_if:delivery,==,1 | max:128',
                'postalCode' => 'required_if:delivery,==,1 | max:32',
            ]);
        }

        if (Auth::user()->role == 1)
        {
            $registerForm = Forma::findOrFail($id);
        }
        else
        {
            $registerForm = Auth::user()->forms()->findOrFail($id);
        }

        if($registerForm->busena != "pateikta" && Auth::user()->role != 1)
        {
            return redirect()->route('forma-all')->with('error', 'Forma nebegali būti keičiama.');
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
        $registerForm->user()->associate(Auth::user());
        if (Auth::user()->role == 1)
        {
            switch ($request->busena)
            {
                case 1:
                    $registerForm->busena = 'Pateikta';
                    $state = 'Pateikta';
                break;
                case 2:
                    $registerForm->busena = 'Priimta';
                    $state = 'Priimta';
                    break;
                case 3:
                    $registerForm->busena = 'Gauta';
                    $state = 'Gauta';
                    break;
                case 4:
                    $registerForm->busena = 'Taisoma';
                    $state = 'Taisoma';
                    break;
                case 5:
                    $registerForm->busena = 'Atlikta';
                    $state = 'Atlikta';
                    break;
            }
            $name = $registerForm->user->name;
            $number = $registerForm->saskaitos_nr;
            $registerForm->save();
            Mail::to($registerForm->user->email)->send(new StateMail($name, $number, $state));
            return redirect()->route('forma-all')->with('success', 'Kompiuterio remonto forma sekmingai paredaguota, el. laiškas išsiūstas klientui.');
        }
        else
        {
            $registerForm->busena = "pateikta";
            $registerForm->save();
            return redirect()->route('forma-all')->with('success', 'Kompiuterio remonto forma sekmingai paredaguota, apie remonto busena jus informuosime el. pastu.');
        }
    }
    public function formDelete(Request $request, $id)
    {
        if (Auth::user()->role == 1)
        {
            $forms = Forma::findOrFail($id);
        }
        else
        {
            $forms = Auth::user()->forms()->findOrFail($id);
        }

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
    public function leaveComment(Request $request, $id)
    {
        $forms = Auth::user()->forms()->findOrFail($id);
        return view('commentsForm', compact('forms'));
    }
    public function leaveCommentPost(Request $request, $id)
    {
        $this->validate($request, [
                'comment' => 'required | max:255',
                'rating' => 'numeric | min: 1 | max: 5',
            ]);
        $forms = Auth::user()->forms()->findOrFail($id);
        $commentForm = new \App\Models\Comment;
        $commentForm->rating = $request->rating;
        $commentForm->comment = $request->comment;
        $commentForm->user()->associate(Auth::user());
        $commentForm->formComment()->associate($forms);
        $forms->comment_state = 1;
        $commentForm->save();
        $forms->save();

        return redirect()->route('forma-all')->with('success', 'Komentaras sėkmingai pateiktas.');
    }
    public function showDatatable(Request $request)
    {
        $result['data'] = [];
        if (Auth::user()->role == 1)
        {
            $allDataUser = Forma::all();
        }
        else
        {
            $allDataUser = Auth::user()->forms;
        }
        if (count($allDataUser) > 0)
        {
            foreach ($allDataUser as $single)
            {
                $tableData = [];
                $tableData[] = $single->computer_brand;
                $tableData[] = $single->computer_model;
                $tableData[] = $single->comment;
                if ($single->delivery == 0)
                {
                    $tableData[] = 'Pristatysite patys';
                }
                else
                {
                    $tableData[] = 'Kurjerio pristatymas';
                }
                $tableData[] = $single->busena;
                $tableData[] = $single->saskaitos_nr;
                $tableData[] = [$single->id, $single->busena == "Atlikta" && $single->comment_state != 1];
                $result['data'][] = $tableData;
            }
        }
        $result['success'] = true;
        $result['recordsTotal'] = count($allDataUser);
        $result['recordsFiltered'] = count($result['data']);
        $result['draw'] = $request->draw;
        return response()->json($result);


    }
}
