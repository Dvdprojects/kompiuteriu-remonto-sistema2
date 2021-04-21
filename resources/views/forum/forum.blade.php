@extends('layouts.app')

@section('content')
   <div class="container">
       <div class="row">
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
               <div class="col-md-3 mt-5">
                   <div class="card shadow-1-strong">
                       <div class="container mb-3">
                           <div class="row mb-3">
                               <div class="mt-3"></div>
                               <h5>Temų parinktys</h5>
                               <hr>
                           </div>
                           <div class="row mb-2">
                               <a href="{{route('forum')}}" style="text-align: left;" class="btn btn-dark btn-rounded"> <i class="fas fa-male"></i> Mano</a>
                           </div>
                           <div class="row mb-2">
                               <a href="{{route('forum.lessons')}}" style="text-align: left;" class="btn btn-dark btn-rounded"> <i class="fas fa-book-open"></i> Pamokos</a>
                           </div>
                           <div class="row mb-2">
                               <a href="{{route('forum.questions')}}" style="text-align: left;" class="btn btn-dark btn-rounded"> <i class="fas fa-question"></i> Klausimai/Ataskymai</a>
                           </div>
                           <div class="row mb-2">
                               <a href="{{route('forum.specialist')}}" style="text-align: left;" class="btn btn-dark btn-rounded"> <i class="fas fa-question-circle"></i> Klausk specialisto</a>
                           </div>
                           <div class="row mb-2">
                               <a href="{{route('forum.reviews')}}" style="text-align: left;" class="btn btn-dark btn-rounded"> <i class="fas fa-comment"></i>Atsiliepimai</a>
                           </div>
                       </div>
                   </div>
               </div>
           <div class="col-md-9">
               <div class="row">
                   <div class="clearfix">
                       <div class="text-center" style="width: auto;">
                           <h5>Klauskite specialisto</h5>
                       </div>
                       <div class="float-right" style="width: auto; float: right">
                           <a href="{{route('forum-post-add-view')}}"> <i class="fas fa-plus"></i> Pridėti įrašą</a>
                       </div>
                   </div>
               </div>
               <hr>
                   @forelse($forumPosts as $post)
                       <div class="card mb-3 shadow-1-strong">
                           <div class="row g-0">
                               <div class="col-md-2">
                                   <div class="d-flex justify-content-center mt-4">
                                       <img
                                           src="https://mdbootstrap.com/wp-content/uploads/2020/06/vertical.jpg"
                                           alt="..."
                                           class="img-fluid rounded-circle"
                                           style="width: 120px; height: 120px"
                                       />
                                   </div>
                               </div>
                               <div class="col-md-10">
                                   <div class="card-body">
                                       @if(isset($post->comment_verified) && $post->comment_verified == 1)
                                           <h5 class="card-title">
                                               Vartotojas: {{$post->user->name . ' ' . $post->user->name}}
                                           </h5>
                                       @else
                                           <h5 class="card-title">
                                               <a href="/forum-post-open/{{$post->id}}">{{$post->forum_subject}}</a>
                                           </h5>
                                       @endif
                                       <p class="card-text">
                                           @if(isset($post->comment_verified) && $post->comment_verified == 1)
                                           {{$post->comment}}
                                               <div class="float-right">
                                                   <div id="rateYo"></div>
                                                   <input type="hidden" id="rating" name="rating" value="{{$post->rating}}">
                                               </div>
                                               @else
                                               {{$post->forum_comment}}
                                               @endif
                                       </p>
                                                   <div class="mt-5"></div>
                                       <p class="card-text">
                                           <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                       </p>
                                   </div>
                               </div>
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
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#rateYo").rateYo({
                starWidth: "30px",
                rating: $( "#rating" ).val(),
                precision: 1,
                fullStar: true,
                readOnly: true,
            });
        });
    </script>
@endsection
