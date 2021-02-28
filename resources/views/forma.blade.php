@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <h5 class="text-center">{{ __('Kompiuterio remonto registracija.') }}</h5>
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
                <form id="pcRegistrationForm" action="{{url('formpost')}}" method="post">
                {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="vardas" class="col-sm-4 col-form-label">Vardas</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="vardas" name="vardas" placeholder="Vardas" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pavarde" class="col-sm-4 col-form-label">Pavardė</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="pavarde" name="pavarde" placeholder="Pavardė" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipas" class="col-sm-4 col-form-label">Tipas</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="tipas" name="tipas" placeholder="Tipas" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">Pristatymo būdas</div>
                        <div class="col-sm-8">
                        <div class="form-check col-sm-4">
                            <input class="form-check-input" type="radio" id="pristatymo_budas" name="pristatymo_budas" value="1">
                            <label class="form-check-label" for="pristatymo_budas">
                            Pristatysite patys
                            </label>
                        </div>
                            <div class="form-check col-sm-4">
                                <input class="form-check-input" type="radio" id="pristatymo_budas" name="pristatymo_budas" value="0">
                                <label class="form-check-label" for="pristatymo_budas">
                                    Paims kurjeris
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">Apmokejimas</div>
                        <div class="col-sm-8">
                        <div class="form-check col-sm-4">
                            <input class="form-check-input" type="radio" id="apmokejimas" name="apmokejimas" value="1">
                            <label class="form-check-label" for="apmokejimas">
                            Grynaisiais
                            </label>
                        </div>
                            <div class="form-check col-sm-4">
                                <input class="form-check-input" type="radio" id="apmokejimas" name="apmokejimas" value="0">
                                <label class="form-check-label" for="apmokejimas">
                                    Apmokejimas kortele
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="komentaras" class="col-sm-4 col-form-label">Komentaras</label>
                        <div class="col-sm-8">
                        <textarea class="form-control" id="komentaras" name="komentaras" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                        <button type="submit" id="submit" class="btn btn-primary">Pateikti</button>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
