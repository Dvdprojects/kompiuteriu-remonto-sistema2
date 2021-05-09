<?php

namespace App\Http\Controllers;

use App\Mail\StateMail;
use App\Models\Order;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class OrderController extends Controller
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
        if (Auth::user()->role == 1)
        {
            $users = Auth::user()->all();
            return view('forma', compact('users'));
        }
        return view('forma');
    }
    public function store(Request $request)
    {
        $config = [
            'table' => 'orders',
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

        $order = new \App\Models\Order;
        $computer = new \App\Models\Computer();
        $computer->computer_brand = $request->computerBrand;
        $computer->computer_model = $request->computerModel;
        $order->short_comment = $request->comment;
        if ($request->delivery == 1)
        {
            $order->address = $request->address;
            $order->postal_code = $request->postalCode;
            $order->delivery = $request->delivery;
        }
        else
        {
            $order->delivery = 0;
            $order->postal_code = "Nenurodyta";
            $order->address = "Nenurodyta";
        }
        if (Auth::user()->role == 1)
        {
            $order->user()->associate(User::find($request->userId));
        }
        else
        {
            $order->user()->associate(Auth::user());
        }
        $order->busena = "Pateikta";
        $order->saskaitos_nr = $idForSas;
        $order->save();
        $computer->order()->associate($order);
        $computer->save();
        return redirect()->route('forma')->with('success', 'Kompiuterio remonto forma pateikta patvirtinimui, apie remonto busena jus informuosime el. pastu.');

    }
    public function showAll()
    {
        return view('formashow');
    }
    public function formEdit(Request $request, $id)
    {
        if (Auth::user()->role == 1)
        {
            $forms = Order::findOrFail($id);
        }
        else
        {
            $forms = Auth::user()->order()->findOrFail($id);
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
                'mailCheckbox' => 'min:0|max:1',
                'mailBox' => 'required_if:mailCheckbox,==,1 | max:255',
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
            $registerForm = Order::findOrFail($id);
        }
        else
        {
            $registerForm = Auth::user()->order()->findOrFail($id);
        }

        if($registerForm->busena != "pateikta" && Auth::user()->role != 1)
        {
            return redirect()->route('forma-all')->with('error', 'Forma nebegali būti keičiama.');
        }

        $registerForm->computer->computer_brand = $request->computerBrand;
        $registerForm->computer->computer_model = $request->computerModel;
        $registerForm->short_comment = $request->comment;
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
        if (Auth::user()->role == 1)
        {
            switch ($request->busena)
            {
                case 1:
                    $registerForm->busena = 'pateikta';
                    $state = 'Pateikta';
                    break;
                case 2:
                    $registerForm->busena = 'priimta';
                    $state = 'Priimta';
                    break;
                case 3:
                    $registerForm->busena = 'gauta';
                    $state = 'Gauta';
                    break;
                case 4:
                    $registerForm->busena = 'taisoma';
                    $state = 'Taisoma';
                    break;
                case 5:
                    $registerForm->busena = 'atlikta';
                    $state = 'Atlikta';
                    break;
            }
            $name = $registerForm->user->name;
            $number = $registerForm->saskaitos_nr;
            $mailBox = strval($request->mailBox);
            if ($request->mailCheckbox == 1)
            {
                Mail::to($registerForm->user->email)->send(new StateMail($name, $number, $state, $mailBox));
            }
            $registerForm->save();
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
            $orders = Order::findOrFail($id);
        }
        else
        {
            $orders = Auth::user()->order()->findOrFail($id);
        }

        if($orders->busena != "pateikta" && Auth::user()->role != 1)
        {
            return redirect()->route('forma-all')->with('error', 'Pateikta forma nebegali būti ištrinta.');
        }

        $orders->delete();
        return redirect()->route('forma-all')->with('success', 'Kompiuterio remonto forma sekmingai istrinta.');
    }
    public function guaranteeDownload(Request $request, $id)
    {
        $user = Auth::user();
        $guaranteeForm = Order::findOrFail($id);
        $pdf = PDF::loadView('guarantee.guaranteeDownload', compact('guaranteeForm'));
        return $pdf->download($user->name . ' ' . $user->surname . '.pdf');
    }
    public function leaveComment(Request $request, $id)
    {
        $forms = Auth::user()->order()->findOrFail($id);
        return view('commentsForm', compact('forms'));
    }
    public function leaveCommentPost(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required | max:255',
            'rating' => 'numeric | min: 1 | max: 5',
        ]);
        $forms = Auth::user()->order()->findOrFail($id);
        $commentForm = new \App\Models\Comment;
        $commentForm->rating = $request->rating;
        $commentForm->comment = $request->comment;
        $commentForm->user()->associate(Auth::user());
        $commentForm->order()->associate($forms);
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
            $allDataUser = Order::all();
        }
        else
        {
            $allDataUser = auth()->user()->order;
        }
        if (count($allDataUser) > 0)
        {
            foreach ($allDataUser as $single)
            {
                $tableData = [];
                $tableData[] = $single->computer->computer_brand;
                $tableData[] = $single->computer->computer_model;
                $tableData[] = $single->short_comment;
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
                $tableData[] = [$single->id, $single->busena != "pateikta", $single->busena == "atlikta", Auth::user()->role == 1];
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
