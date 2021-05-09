@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-1-strong">
                <div class="card-header">
                    <h5 class="text-center">{{ __('Vartotoju registracija.') }}</h5>
                    <hr>
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
                    <form id="pcRegistrationForm" action="{{url('admin-user-add')}}" method="post">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="row mb-4">
                            <div class="col">
                                <!-- Vardas input -->
                                <div class="form-outline">
                                    <input type="text" id="name" name="name" class="form-control"
                                           value="{{old('name')}}"/>
                                    <label class="form-label" for="form6Example1">Vardas</label>
                                </div>
                            </div>
                            <!-- Pavarde input -->
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="surname" name="surname" class="form-control"
                                           value="{{old('surname')}}"/>
                                    <label class="form-label" for="form6Example2">Pavardė</label>
                                </div>
                            </div>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="email" name="email" class="form-control"
                                   value="{{old('email')}}"/>
                            <label class="form-label" for="form6Example4">E. Paštas</label>
                        </div>

                        <!-- Tel. Nr input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                   value="{{old('phoneNumber')}}"/>
                            <label class="form-label" for="form6Example4">Telefono numeris</label>
                        </div>

                        <!-- Miestas input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="city" name="city" class="form-control" value="{{old('city')}}"/>
                            <label class="form-label" for="form6Example7">Miestas</label>
                        </div>

                        <!-- Miestas input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control" value=""/>
                            <label class="form-label" for="form6Example7">Slaptažodis</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value=""/>
                            <label class="form-label" for="form6Example7">Pakartokite Slaptažodį</label>
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
    <script>
        $('#delivery').click(function () {
            if ($(this).is(':checked')) {
                $('#addressDiv').show();
                $('#postalCodeDiv').show();
            } else {
                $('#addressDiv').hide();
                $('#postalCodeDiv').hide();
            }
        });
        $(function () {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
