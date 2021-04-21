@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">{{ __('Pateikite forumo įrašą.') }}</h5>
                        <br>
                        <br>
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
                        <form id="pcRegistrationForm" action="{{url('forum-post')}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}

                            <!-- Kompiuterio modelis input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="forumSubject" name="forumSubject"  class="form-control" required/>
                                <label class="form-label" for="form6Example7">Gedimas</label>
                            </div>
                                <select class="form-select" id="forumGroup" name="forumGroup" aria-label="Default select example">
                                    <option selected>Pasirinkite temą</option>
                                    <option value="1">Pamokos</option>
                                    <option value="2">Klausimai/Atsakymai</option>
                                    <option value="3">Klausk specialisto</option>
                                    <option value="4">Dažniausiai užduodami klausimai</option>
                                </select>
                                <div class="mt-4">

                                </div>
                            <!-- Komentaras input -->
                            <div class="form-outline mb-4">
                                <textarea class="form-control" id="forumComment" name="forumComment"  rows="4" required></textarea>
                                <label class="form-label" for="form6Example7">Gedimo aprašymas</label>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Pateikti</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
        @endsection
