<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }
    public function check(Request $request)
    {
        $stateCheck = Order::select('busena')->where('saskaitos_nr', $request->saskNr)->get();
        if ($stateCheck != null)
        {
            $result[] = $stateCheck;
            return response()->json($result);
        }
        else
        {
            return response()->json(['error' => 'Toks sąskaitos numeris neegzistuoja'], 404);
        }
    }
}
