@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="note note-primary">
                    <strong>Pastaba:</strong> Darbo valandomis, su mumis galite susisiekti pasinaudodami gyvo pokalbio funkcija!
                </p>
                <div class="card shadow-1-strong">
                    <div class="container">
                        <div class="mt-3"></div>
                        <h5 class="card-title">Susisiekite su mumis</h5>
                        <hr>
                        <form id="pcRegistrationForm" action="{{url('send-email')}}" method="GET">
                            <div class="mt-3"></div>
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- Vardas input -->
                                    <div class="form-outline">
                                        <input type="text" id="name" name="name" class="form-control" value="{{Auth::user()->name}}" required/>
                                        <label class="form-label" for="form6Example1">Vardas</label>
                                    </div>
                                </div>
                                <!-- Pavarde input -->
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="surname" name="surname" class="form-control"@if (Auth::user()->profile_verified == 1) value="{{Auth::user()->surname}}"@endif required/>
                                        <label class="form-label" for="form6Example2">Pavardė</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="email" name="email"  class="form-control" disabled/>
                                <label class="form-label" for="form6Example3">{{Auth::user()->email}}</label>
                            </div>

                            <!-- Tel. Nr input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="phoneNumber" name="phoneNumber"  class="form-control" @if (Auth::user()->profile_verified == 1) value="{{Auth::user()->phone_number}}"@endif required />
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
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-1-strong">
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
