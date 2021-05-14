@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-1-strong">
                <div class="card-header">
                    <h5 class="text-center">{{ __('Kompiuterio remonto registracija.') }}</h5>
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
                    <div class="container">
                    <form id="pcRegistrationForm" action="{{url('formpost')}}" method="post">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        @if(Auth::user()->role != 1)
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- Vardas input -->
                                    <div class="form-outline">
                                        <input type="text" id="name" name="name" class="form-control"
                                               value="{{Auth::user()->name}}" disabled/>
                                        <label class="form-label" for="form6Example1">Vardas</label>
                                    </div>
                                </div>
                                <!-- Pavarde input -->
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="surname" name="surname" class="form-control"
                                               value="{{Auth::user()->surname}}" disabled/>
                                        <label class="form-label" for="form6Example2">Pavardė</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="email" name="email" class="form-control" disabled/>
                                <label class="form-label" for="form6Example3">{{Auth::user()->email}}</label>
                            </div>

                            <!-- Tel. Nr input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                       value="{{Auth::user()->phone_number}}" disabled/>
                                <label class="form-label" for="form6Example4">Telefono numeris</label>
                            </div>

                            <!-- Miestas input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="city" name="city" class="form-control" value="{{Auth::user()->city}}"
                                       disabled/>
                                <label class="form-label" for="form6Example7">Miestas</label>
                            </div>
                        @else
                            <input id="userId" type="hidden" value="{{Auth::user()->id}}" name="userId">
                            <div class="row mb-4">
                                    <select class="form-control" id="select-user"
                                            data-live-search="true">
                                        @forelse($users as $user)
                                            <option value="{{$user->id}}" @if($user->id == Auth::user()->id) selected @endif>{{$user->name . " " . $user->surname}}</option>
                                        @empty
                                            <option>No Data</option>
                                        @endforelse

                                    </select>
                                </div>
                    @endif
                        <!-- Kompiuterio gamintojas input -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input
                                    class="form-check-input me-2"
                                    type="checkbox"
                                    value="1"
                                    id="from_guarantee"
                                    name="from_guarantee"
                            />
                            <label class="form-check-label" for="form6Example8"> Garantinis taisymas? </label>
                        </div>
                        <div class="form-outline mb-4" id="computerBrandDiv">
                            <input type="text" id="computerBrand" name="computerBrand" class="form-control"/>
                            <label class="form-label" for="form6Example7">Kompiuterio gamintojas</label>
                        </div>
                        <!-- Kompiuterio modelis input -->
                        <div class="form-outline mb-4" id="computerModelDiv">
                            <input type="text" id="computerModel" name="computerModel" class="form-control"/>
                            <label class="form-label" for="form6Example7">Kompiuterio modelis</label>
                        </div>
                        <div class="form-outline mb-4" id="guaranteeIdDiv" style="display: none">
                            <input type="text" id="guaranteeId" name="guaranteeId" class="form-control"/>
                            <label class="form-label" for="form6Example5">Garantijos numeris</label>
                        </div>
                        <!-- Komentaras input -->
                        <div class="form-outline mb-4">
                            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                            <label class="form-label" for="form6Example7">Komentaras</label>
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input
                                class="form-check-input me-2"
                                type="checkbox"
                                value="1"
                                id="delivery"
                                name="delivery"
                            />
                            <label class="form-check-label" for="form6Example8"> Ar reikalingas kurjerio
                                pristatymas? </label>
                        </div>
                        <!-- Adresas input -->
                        <div class="form-outline mb-4" id="addressDiv" style="display: none">
                            <input type="text" id="address" name="address" class="form-control"/>
                            <label class="form-label" for="form6Example5">Adresas</label>
                        </div>

                        <!-- Pašto kodas input -->
                        <div class="form-outline mb-4" id="postalCodeDiv" style="display: none">
                            <input type="text" id="postalCode" name="postalCode" class="form-control"/>
                            <label class="form-label" for="form6Example6">Pašto kodas</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4">Pateikti</button>
                    </form>
                    </div>
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
        $('#from_guarantee').click(function () {
            if ($(this).is(':checked')) {
                $('#computerBrandDiv').hide();
                $('#computerModelDiv').hide();
                $('#guaranteeIdDiv').show();
            } else {
                $('#computerBrandDiv').show();
                $('#computerModelDiv').show();
                $('#guaranteeIdDiv').hide();
            }
        });
    </script>
    <script>
        $('#select-user').on('click', function(e) {
            alert("test");
        });
        $(function() {
            $('#select-user').selectize({onChange: function (value){
                document.getElementById("userId").value = value;
                }});
        });
    </script>
@endsection
