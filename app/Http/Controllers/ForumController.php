<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forma;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
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
        $forumPosts = Auth::user()->forumPosts;
        return view('forum.forum', compact('forumPosts'));
    }
    public function lessons()
    {
        $forumPosts = Forum::query()->groups(1)->public(1)->get();
        return view('forum.forum', compact('forumPosts'));
    }
    public function questions()
    {
        $forumPosts = Forum::query()->groups(2)->public(1)->get();
        return view('forum.forum', compact('forumPosts'));
    }
    public function specialistQuestions()
    {
        $forumPosts = Forum::query()->groups(3)->public(1)->get();
        return view('forum.forum', compact('forumPosts'));
    }
    public function duk()
    {
        $forumPosts = Forum::query()->groups(4)->public(1)->get();
        return view('forum.forum', compact('forumPosts'));
    }
    public function reviews()
    {
        $forumPosts = Comment::all()->where('comment_verified', '==', 1);
        return view('forum.forum', compact('forumPosts'));
    }
    public function forumAdmin()
    {
        $lessons = Forum::query()->groups(1)->public(0)->get();
        $questions = Forum::query()->groups(2)->public(0)->get();
        $specialistQuestions = Forum::query()->groups(3)->public(0)->get();
        $duk = Forum::query()->groups(4)->public(0)->get();
        $comments = Comment::all()->where('comment_verified', '==', 0);
        $forumPosts = Forum::all();
        $commentPosts = Comment::all();
        return view('forum.forumAdmin', compact('forumPosts', 'commentPosts', 'lessons', 'questions', 'specialistQuestions', 'duk', 'comments'));
    }
    public function forumPostAddView()
    {
        return view('forum.forumPost');
    }
    public function forumPost(Request $request)
    {
        $this->validate($request, [
            'forumGroup' => 'required | min: 1 | max:5',
            'forumSubject' => 'required | max:64',
            'forumComment' => 'required | max:512',
        ]);

        $forum = new \App\Models\Forum;
        $forum->user()->associate(Auth::user());
        $forum->group = $request->forumGroup;
        $forum->forum_subject = $request->forumSubject;
        $forum->forum_comment = $request->forumComment;
        $forum->save();
        return redirect()->route('forum')->with('success', 'Klausimas sėkmingai pateiktas, laukite atsakymo.');
    }
    public function viewForumPosts(Request $request)
    {
        $forumPost = Forum::findOrFail($request->id);
        $comments = $forumPost->comments;
        return view('forum.forumPostView', compact('forumPost', 'comments'));
    }
    public function leaveForumPostComment(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required | max:256',
        ]);
        $forumPost = Forum::findOrFail($id);
        $forumComment = new \App\Models\ForumComments;
        $forumComment->user()->associate(Auth::user());
        $forumComment->forumPost()->associate($forumPost);
        $forumComment->forum_post_comment = $request->comment;
        $forumComment->save();
        return redirect()->back()->with('success', 'Komentaras sėkmingai pateiktas.');
    }
    public function acceptForumPost(Request $request, $id)
    {
        $forumPost = Forum::findOrFail($id);
        $forumPost->public = 1;
        $forumPost->save();
        return redirect()->back()->with('success', 'Sėkmingai patalpintas.');
    }
    public function denyForumPost(Request $request, $id)
    {
        $forumPost = Forum::findOrFail($id);
        $forumPost->delete();
        return redirect()->back()->with('error', 'Sėkmingai atmestas.');
    }
}
