@extends('layouts.app')

@section('content')
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
            <div class="col-md-12">
                <div class="row">
                    <div class="clearfix">
                        <div class="text-center" style="width: auto;">
                            <h5>[Admin] Forumo peržiūros puslapis</h5>
                        </div>
                        <div class="float-right" style="width: auto; float: right">
                            <a href="{{route('forum-post-add-view')}}"> Pridėti forumo straispnį<i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <hr>
                {{-- Rikiavimo Mygtukai --}}
                        <div class="col-md-12 text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button id="lessons" type="button" class="btn btn-dark">Pamokos</button>
                                <button id="questions" type="button" class="btn btn-dark">Klausimai / Atsakymai</button>
                                <button id="specialistQuestions" type="button" class="btn btn-dark">Klausk specialisto</button>
                                <button id="duk" type="button" class="btn btn-dark">DUK</button>
                                <button id="comments" type="button" class="btn btn-dark">Komentarai</button>
                                <button id="comments" type="button" class="btn btn-dark">Publikuoti</button>
                            </div>
                        </div>
                {{-- Rikiavimo Mygtukai --}}

                {{-- PAMOKOS --}}
                <div class="mt-5"></div>

                        <div id="lessonsCard" style="display: none">
                            <h5 class="text-center">Pamokos</h5>
                            <hr>
                            @forelse($lessons as $post)
                                <div class="card mb-3 shadow-1-strong">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">
                                                    <a href="{{route('forum-post-open', $post->id)}}">{{$post->forum_subject}}</a>
                                                </h5>
                                                <p class="card-text text-center">
                                                    {{$post->forum_comment}}
                                                </p>
                                                <div class="row">
                                                    <p class="card-text text-center">
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-check"></i></a>
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-times"></i></a>
                                                    </p>
                                                </div>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                                </p>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpino: {{$post->user->name . ' ' . $post->user->surname}}</small>
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
                            {{-- PAMOKOS --}}
                        </div>

                        <div class="mt-5"></div>

                        {{-- Klausimai / Atsakymai --}}
                        <div id="questionsCard" style="display: none">
                            <h5 class="text-center">Klausimai / Atsakymai</h5>
                            <hr>
                            @forelse($questions as $post)
                                <div class="card mb-3 shadow-1-strong">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">
                                                    <a href="{{route('forum-post-open', $post->id)}}">{{$post->forum_subject}}</a>
                                                </h5>
                                                <p class="card-text text-center">
                                                    {{$post->forum_comment}}
                                                </p>
                                                <div class="row">
                                                    <p class="card-text text-center">
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-check"></i></a>
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-times"></i></a>
                                                    </p>
                                                </div>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                                </p>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpino: {{$post->user->name . ' ' . $post->user->surname}}</small>
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
                        {{-- Klausimai / Atsakymai --}}
                        <div class="mt-5"></div>

                        {{-- Klausk specialisto --}}
                        <div id="specialistQuestionsCard" style="display: none">
                            <h5 class="text-center">Klausk specialisto</h5>
                            <hr>
                            @forelse($specialistQuestions as $post)
                                <div class="card mb-3 shadow-1-strong">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">
                                                    <a href="{{route('forum-post-open', $post->id)}}">{{$post->forum_subject}}</a>
                                                </h5>
                                                <p class="card-text text-center">
                                                    {{$post->forum_comment}}
                                                </p>
                                                <div class="row">
                                                    <p class="card-text text-center">
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-check"></i></a>
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-times"></i></a>
                                                    </p>
                                                </div>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                                </p>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpino: {{$post->user->name . ' ' . $post->user->surname}}</small>
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
                        {{-- Klausk specialisto --}}
                        <div class="mt-5"></div>

                        {{-- DUK --}}
                        <div id="dukCard" style="display: none">
                            <h5 class="text-center">Dažniausiai užduodami klausimai</h5>
                            <hr>
                            @forelse($duk as $post)
                                <div class="card mb-3 shadow-1-strong">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">
                                                    <a href="{{route('forum-post-open', $post->id)}}">{{$post->forum_subject}}</a>
                                                </h5>
                                                <p class="card-text text-center">
                                                    {{$post->forum_comment}}
                                                </p>
                                                <div class="row">
                                                    <p class="card-text text-center">
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-check"></i></a>
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-times"></i></a>
                                                    </p>
                                                </div>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                                </p>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpino: {{$post->user->name . ' ' . $post->user->surname}}</small>
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
                        {{-- DUK --}}
                        <div class="mt-5"></div>

                        {{-- Komentarai --}}
                        <div id="commentsCard" style="display: none">
                            <h5 class="text-center">Komentarai</h5>
                            <hr>
                            @forelse($comments as $post)
                                <div class="card mb-3 shadow-1-strong">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">
                                                    {{$post->form->computer_brand . ' ' . $post->form->computer_model}}
                                                </h5>
                                                <p class="card-text text-center">
                                                    {{ 'Komentaras: '. $post->comment . '\n' . 'Reigingas: ' . $post->rating}}
                                                </p>
                                                <div class="row">
                                                    <p class="card-text text-center">
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-check"></i></a>
                                                        <a href="{{route('forum-post-accept', $post->id)}}"> <i class="fas fa-times"></i></a>
                                                    </p>
                                                </div>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpinta: {{$post->created_at}}</small>
                                                </p>
                                                <p class="card-text text-center">
                                                    <small class="text-muted">Patalpino: {{$post->user->name . ' ' . $post->user->surname}}</small>
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
                        {{-- Komentarai --}}






            </div>
            @endsection
            @section('scripts')
                <script>
                    $(function () {
                        $("#rateYo").rateYo({
                            starWidth: "30px",
                            rating: $("#rating").val(),
                            precision: 1,
                            fullStar: true,
                            readOnly: true,
                        });
                    });
                    $('#lessons').click(function(){
                            $('#lessonsCard').show();
                            $('#specialistQuestionsCard').hide();
                            $('#questionsCard').hide();
                            $('#dukCard').hide();
                            $('#commentsCard').hide();
                    });
                    $('#questions').click(function(){
                            $('#questionsCard').show();
                            $('#lessonsCard').hide();
                            $('#specialistQuestionsCard').hide();
                            $('#dukCard').hide();
                            $('#commentsCard').hide();
                    });
                    $('#specialistQuestions').click(function(){
                            $('#specialistQuestionsCard').show();
                            $('#lessonsCard').hide();
                            $('#questionsCard').hide();
                            $('#dukCard').hide();
                    });
                    $('#duk').click(function(){
                            $('#specialistQuestionsCard').hide();
                            $('#lessonsCard').hide();
                            $('#questionsCard').hide();
                            $('#commentsCard').hide();
                            $('#dukCard').show();
                    });
                    $('#comments').click(function(){
                            $('#dukCard').hide();
                            $('#specialistQuestionsCard').hide();
                            $('#lessonsCard').hide();
                            $('#questionsCard').hide();
                            $('#commentsCard').show();
                    });
                </script>
@endsection
