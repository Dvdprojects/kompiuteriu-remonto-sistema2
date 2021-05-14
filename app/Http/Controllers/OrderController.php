<?php

namespace App\Http\Controllers;

use App\Mail\StateMail;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
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
            'comment' => 'required | max:255',
            'delivery' => 'numeric | min: 0 | max: 1',
            'address' => 'max:128',
            'postalCode' => 'max:32',
        ]);

        $guaranteeOrder = null;
        if ($request->from_guarantee == 1) {
			$this->validate($request, [
				'guaranteeId' => 'required|max:64',
			]);
			$guaranteeOrder = Auth::user()->order()->where('saskaitos_nr', '=', $request->guaranteeId)->first();
			if ($guaranteeOrder == null) {
				$errors = new MessageBag();
				$errors->add('guaranteeId', 'Šis garantijos numeris neegzistuoja.');
				return redirect()->back()->exceptInput()->withErrors($errors);
			}
			if ($guaranteeOrder->busena != 'atlikta') {
				$errors = new MessageBag();
				$errors->add('guaranteeId', 'Užsakymas nėra dar įvykdytas.');
				return redirect()->back()->exceptInput()->withErrors($errors);
			}
			if ($guaranteeOrder->updated_at->addDays(90) < Carbon::now()) {
				$errors = new MessageBag();
				$errors->add('guaranteeId', 'Garantija jau yra pasibaigusi.');
				return redirect()->back()->exceptInput()->withErrors($errors);
			}
		}
        else {
			$this->validate($request, [
				'computerBrand' => 'required|max:64',
				'computerModel' => 'required|max:64',
			]);
		}

        $order = new \App\Models\Order;
        $computer = new \App\Models\Computer();
        if ($guaranteeOrder != null) {
			$computer->computer_brand = $guaranteeOrder->computer->computer_brand;
			$computer->computer_model = $guaranteeOrder->computer->computer_model;
			$order->garantinis_saskaitos_nr = $request->guaranteeId;
		}
        else {
			$computer->computer_brand = $request->computerBrand;
			$computer->computer_model = $request->computerModel;
		}
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

        if ($registerForm->garantinis_saskaitos_nr == null) {
        	$this->validate($request, [
				'computerBrand' => 'required | max:64',
				'computerModel' => 'required | max:64',
			]);
		}

        if($registerForm->busena != "pateikta" && Auth::user()->role != 1)
        {
            return redirect()->route('forma-all')->with('error', 'Forma nebegali būti keičiama.');
        }

		if ($registerForm->garantinis_saskaitos_nr == null) {
			$registerForm->computer->computer_brand = $request->computerBrand;
			$registerForm->computer->computer_model = $request->computerModel;
		}
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
        return $pdf->download($user->name . '_' . $user->surname . '.pdf');
    }
    public function leaveComment(Request $request, $id)
    {
    	$user = Auth::user();
    	if ($user->role == 1) {
			$forms = Order::findOrFail($id);
		}
    	else {
			$forms = $user->order()->findOrFail($id);
		}
        return view('commentsForm', compact('forms'));
    }
    public function leaveCommentPost(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role == 1) {
			$this->validate($request, [
				'comment' => 'required | max:255',
			]);
			$forms = Order::findOrFail($id);
		}
        else {
			$this->validate($request, [
				'comment' => 'required | max:255',
				'rating' => 'numeric | min: 1 | max: 5',
			]);
			$forms = Auth::user()->order()->findOrFail($id);
		}
        if ($forms->comment != null) {
        	if ($user->role == 1) {
        		$commentForm = $forms->comment;
				$commentForm->comment = $request->comment;
				$commentForm->save();
				return redirect()->route('forma-all')->with('success', 'Komentaras sėkmingai pakoreguotas.');
			}
        	return redirect()->route('form-edit', $id);
		}
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
            $allDataUser = Order::query()->join('computers', 'computers.order_id', '=', 'orders.id');
        }
        else
        {
            $allDataUser = auth()->user()->order()->join('computers', 'computers.order_id', '=', 'orders.id');
        }

		$totalCount = $allDataUser->count();
		if (isset($request->order) && count($request->order) > 0) {
			if ($request->order[0]['column'] == "0") {
				$allDataUser = $allDataUser->orderBy('computer_brand', $request->order[0]['dir']);
			}
			else if ($request->order[0]['column'] == "1") {
				$allDataUser = $allDataUser->orderBy('computer_model', $request->order[0]['dir']);
			}
			else if ($request->order[0]['column'] == "2") {
				$allDataUser = $allDataUser->orderBy('short_comment', $request->order[0]['dir']);
			}
			else if ($request->order[0]['column'] == "4") {
				$allDataUser = $allDataUser->orderBy('busena', $request->order[0]['dir']);
			}
			else if ($request->order[0]['column'] == "5") {
				$allDataUser = $allDataUser->orderBy('saskaitos_nr', $request->order[0]['dir']);
			}
			else {
				$allDataUser = $allDataUser->orderBy('garantinis_saskaitos_nr', $request->order[0]['dir']);
			}
		}

		if (isset($request->stateFilter) && $request->stateFilter > 0 && $request->stateFilter < 6) {
			if ($request->stateFilter == 1)
				$allDataUser = $allDataUser->where('busena', '=', 'pateikta');
			else if ($request->stateFilter == 2)
				$allDataUser = $allDataUser->where('busena', '=', 'priimta');
			else if ($request->stateFilter == 3)
				$allDataUser = $allDataUser->where('busena', '=', 'gauta');
			else if ($request->stateFilter == 4)
				$allDataUser = $allDataUser->where('busena', '=', 'taisoma');
			else if ($request->stateFilter == 5)
				$allDataUser = $allDataUser->where('busena', '=', 'atlikta');
		}

		if (!empty($request->search['value'])) {
			$allDataUser = $allDataUser->where('saskaitos_nr', 'LIKE', '%' . $request->search['value'] . '%');
		}

		$count = $allDataUser->count();
		$allDataUser = $allDataUser->offset($request->start)->limit($request->length)->get();

        $user = auth()->user();
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
                $tableData[] = $single->garantinis_saskaitos_nr == null ? '-' : $single->garantinis_saskaitos_nr;
                $type = 0;
				if ($user->role == 1 && $single->busena == "atlikta" && $single->comment != null)
					$type = 3;
                else if ($user->role == 1 || $single->busena == "pateikta")
                	$type = 1;
                else if ($single->busena == "atlikta")
                	$type = 2;
                $tableData[] = [$single->id, $type];
                $result['data'][] = $tableData;
            }
        }
        $result['success'] = true;
        $result['recordsTotal'] = $totalCount;
        $result['recordsFiltered'] = $count;
        $result['draw'] = $request->draw;
        return response()->json($result);
    }
	public function commentsList()
	{
		return view('commentslist');
	}
	public function showDatatableComments(Request $request)
	{
		$result['data'] = [];
		if (Auth::user()->role == 1)
		{
			$allDataUser = Comment::query()->orderByDesc('created_at')->get();
		}
		else
		{
			$allDataUser = Comment::query()->where('comment_verified', '=', 1)->orderByDesc('created_at')->get();
		}
		$user = auth()->user();
		if (count($allDataUser) > 0)
		{
			foreach ($allDataUser as $single)
			{
				$tableData = [];
				$tableData[] = $single->user->name;
				$tableData[] = $single->user->surname;
				$tableData[] = $single->comment;
				$tableData[] = $single->rating;
				if ($user->role == 1) {
					$tableData[] = [$single->order->id, $single->comment_verified == 1];
				}
				$result['data'][] = $tableData;
			}
		}
		$result['success'] = true;
		$result['recordsTotal'] = count($allDataUser);
		$result['recordsFiltered'] = count($result['data']);
		$result['draw'] = $request->draw;
		return response()->json($result);
	}
	public function deleteComment(Request $request, $id)
	{
		if (Auth::user()->role == 1)
		{
			$orders = Order::findOrFail($id);
		}
		else
		{
			return redirect()->route('comments-list');
		}
		if ($orders->comment != null) {
			$orders->comment->delete();
		}
		return redirect()->route('comments-list')->with('success', 'Atsiliepimas sekmingai istrintas.');
	}
	public function changeCommentVisibility(Request $request, $id)
	{
		if (Auth::user()->role == 1)
		{
			$orders = Order::findOrFail($id);
		}
		else
		{
			return redirect()->route('comments-list');
		}
		$visible = false;
		if ($orders->comment != null) {
			$comment = $orders->comment;
			$comment->comment_verified = $orders->comment->comment_verified == 1 ? 0 : 1;
			$comment->save();
			$visible = $comment->comment_verified == 1;
		}
		return redirect()->route('comments-list')->with('success', $visible ? 'Atsiliepimas paviesintas.' : 'Atsiliepimas pasleptas.');
	}
}
