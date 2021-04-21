<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
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
        $lessons = count(Forum::query()->groups(1)->public(0)->get());
        $questions = count(Forum::query()->groups(2)->public(0)->get());
        $specialistQuestions = count(Forum::query()->groups(3)->public(0)->get());
        $duk = count(Forum::query()->groups(4)->public(0)->get());
        $comments = count(Comment::all()->where('comment_verified', '==', 0));
        return view('home', compact('lessons', 'questions', 'specialistQuestions', 'duk', 'comments'));
    }
}
