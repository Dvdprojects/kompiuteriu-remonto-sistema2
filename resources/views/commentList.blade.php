@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h5 class="text-center">Pateikti komentarai</h5>
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
            <table id="commentTable" class="table text-center">
                @include('Tables.CommentsTableTop')
                <tbody>
                @forelse(Auth::user()->comments as $comment)
                    @include('Tables.CommentsTable', ['forma' => $comment])
                @empty
                    @include('Tables.CommentsTableEmpty')
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
