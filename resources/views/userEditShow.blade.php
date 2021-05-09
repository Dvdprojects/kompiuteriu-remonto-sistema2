@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header">
                        <h5 class="text-center">{{ __('Vartotojo Profilis.') }}</h5>
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
                        <form id="pcRegistrationForm" action="{{route('admin-user-edit', $userInfo->id)}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- Vardas input -->
                                    <div class="form-outline">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$userInfo->name}}" required/>
                                        <label class="form-label" for="form6Example1">Vardas</label>
                                    </div>
                                </div>
                                <!-- Pavarde input -->
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="surname" name="surname" class="form-control"@if ($userInfo->profile_verified == 1) value="{{$userInfo->surname}}"@endif required/>
                                        <label class="form-label" for="form6Example2">Pavardė</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="email" name="email"  class="form-control" disabled/>
                                <label class="form-label" for="form6Example3">{{$userInfo->email}}</label>
                            </div>

                            <!-- Tel. Nr input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="phoneNumber" name="phoneNumber"  class="form-control" @if ($userInfo->profile_verified == 1) value="{{$userInfo->phone_number}}"@endif required />
                                <label class="form-label" for="form6Example4">Telefono numeris</label>
                            </div>

                            <!-- Miestas input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="city" name="city"  class="form-control" @if ($userInfo->profile_verified == 1) value="{{$userInfo->city}}"@endif required/>
                                <label class="form-label" for="form6Example7">Miestas</label>
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
