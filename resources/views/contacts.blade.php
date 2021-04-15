@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h5 class="text-center">Susisiekite su mumis</h5>
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
            <p class="note note-primary">
                <strong>Pastaba:</strong> Darbo valandomis, su mumis galite susisiekti pasinaudodami gyvo pokalbio funkcija!
            </p>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="pcRegistrationForm" action="{{url('send-email')}}" method="GET">
                    <div class="row mb-4">
                        <div class="col">
                            <!-- Vardas input -->
                            <div class="form-outline">
                                <input type="text" id="name" name="name" class="form-control" value="{{$vartotojas->name}}" required/>
                                <label class="form-label" for="form6Example1">Vardas</label>
                            </div>
                        </div>
                        <!-- Pavarde input -->
                        <div class="col">
                            <div class="form-outline">
                                <input type="text" id="surname" name="surname" class="form-control"@if ($vartotojas->profile_verified == 1) value="{{$vartotojas->surname}}"@endif required/>
                                <label class="form-label" for="form6Example2">Pavardė</label>
                            </div>
                        </div>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="text" id="email" name="email"  class="form-control" disabled/>
                        <label class="form-label" for="form6Example3">{{$vartotojas->email}}</label>
                    </div>

                    <!-- Tel. Nr input -->
                    <div class="form-outline mb-4">
                        <input type="text" id="phoneNumber" name="phoneNumber"  class="form-control" @if ($vartotojas->profile_verified == 1) value="{{$vartotojas->phone_number}}"@endif required />
                        <label class="form-label" for="form6Example4">Telefono numeris</label>
                    </div>

                    <!-- Email tema -->
                    <div class="form-outline mb-4">
                        <input type="text" id="emailHeader" name="emailHeader"  class="form-control" required />
                        <label class="form-label" for="form6Example4">Tema</label>
                    </div>

                    <div class="form-outline">
                        <textarea class="form-control" id="emailText" name="emailText" rows="4"></textarea>
                        <label class="form-label" for="textAreaExample">Laiškas</label>
                    </div>
                    <hr>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Pateikti</button>
                </form>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kontaktai</h5>
                        <hr>
                        <p class="card-text">
                         Greitas, patikimas ir kokybiškas kompiuterių remontas.
                        </p>
                        <hr>
                        <p class="card-text">
                            <strong> Rekvizitai: </strong> <br>
                            UAB TEST <br>
                            Į.k: 300000000 <br>
                            Adresas: Test g. Kaunas <br>
                            LT-08237 <br>
                        </p>
                        <hr>
                        <p class="card-text">
                            <strong> Telefonas: </strong> +37060000000
                        </p>
                        <hr>
                        <p class="card-text">
                            <strong> El. Paštas: </strong> info@test.lt
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
