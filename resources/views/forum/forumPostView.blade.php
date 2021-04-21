@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h5 class="text-center">{{$forumPost->forum_subject}}</h5>
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{Session::get('success')}}</p>
                </div>
            @endif
            @if(\Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{Session::get('error')}}</p>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="card-text">
                        Parašė:  {{Auth::user()->name . Auth::user()->surname}}
                    </p>
                    <p class="card-text">
                       Gedimas:  {{$forumPost->forum_comment}}
                    </p>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="headings d-flex justify-content-between align-items-center mb-3">
                            <h5>Komentarai</h5>
                            <div class="buttons"> <span class="badge bg-white d-flex flex-row align-items-center"> <span class="text-primary">Rodyti komentarus</span>
                        <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" id="commentSwitch"> </div>
                    </span> </div>
                        </div>
                        <div class="commentBox" id="commentBox" style="display: none">
                            @forelse($comments as $comment)
                                <div class="card p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="user d-flex flex-row align-items-center"> <img src="https://images.unsplash.com/photo-1618423771942-1fa46503a0ca?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80" width="30" class="user-img rounded-circle mr-2"> <span><small class="font-weight-bold text-primary">{{$comment->user->name}}</small> <small class="font-weight-bold">{{$comment->forum_post_comment}}</small></span> </div> <small>{{$comment->created_at}}</small>
                                    </div>
                                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                                        @if ($comment->user->role == 1)
                                            <div class="reply px-4"> <small></small> <span class="dots"></span> <small></small> <span class="dots"></span> <small></small> </div>
                                            <div class="icons align-items-center"> <i class="fa fa-star text-warning"></i> <i class="fa fa-check-circle-o check-icon"></i> </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="row">
                                    <div class="text-center">
                                        Nėra įrašų.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">

            </div>
            <hr>
            <form id="forumCommentPostForm" action="{{url('leave-forum-post-comment/' . $forumPost->id)}}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <!-- Komentaras input -->
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="comment" name="comment"  rows="4" required></textarea>
                    <label class="form-label" for="form6Example7">Komentaras</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Pateikti</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#commentSwitch').click(function(){
            if($(this).is(':checked')){
                $('#commentBox').show();
            } else {
                $('#commentBox').hide();
            }
        });
    </script>
@endsection
