<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $comments = count(Comment::all()->where('comment_verified', '=', 0));
        $visibleComments = Comment::query()->where('comment_verified', '=', 1)->orderByDesc('updated_at')->limit(3)->get();
        $averageRating = Comment::query()->average('rating');
        $seconds = Order::query()->where('busena', '=', 'atlikta')->select(\DB::raw('AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) as seconds'))->first()['seconds'];
        $time = '';
		if ($seconds >= 86400) {
			$time .= intval($seconds / 86400) . " d. ";
		}
		if ($seconds % 86400 >= 3600) {
			$time .= intval($seconds % 86400 / 3600) . " val. ";
		}
		if ($seconds % 3600 >= 60) {
			$time .= intval($seconds % 3600 / 60) . " min. ";
		}
		if ($seconds % 60 >= 0) {
			$time .= $seconds % 60 . " sec. ";
		}
        return view('home', compact('comments', 'visibleComments', 'averageRating', 'time'));
    }
}
