@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-1-strong">
                    <div class="card-header">
                        <h5 class="text-center">Kompiuterio remonto registracija</h5>
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
                        <form id="pcRegistrationForm" action="{{route('form-edit-post', $forms->id)}}" method="post">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- Vardas input -->
                                    <div class="form-outline">
                                        <input type="text" id="name" name="name" class="form-control" value="{{$forms->user->name}}" disabled/>
                                        <label class="form-label" for="form6Example1">Vardas</label>
                                    </div>
                                </div>
                                <!-- Pavarde input -->
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="surname" name="surname" class="form-control" value="{{$forms->user->surname}}" disabled/>
                                        <label class="form-label" for="form6Example2">Pavardė</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="email" name="email"  class="form-control"  disabled/>
                                <label class="form-label" for="form6Example3">{{$forms->user->email}}</label>
                            </div>

                            <!-- Tel. Nr input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="phoneNumber" name="phoneNumber"  class="form-control" value="{{$forms->user->phone_number}}" disabled />
                                <label class="form-label" for="form6Example4">Telefono numeris</label>
                            </div>

                            <!-- Miestas input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="city" name="city"  class="form-control" value="{{$forms->user->city}}" disabled/>
                                <label class="form-label" for="form6Example7">Miestas</label>
                            </div>
                            @if($forms->garantinis_saskaitos_nr != null)
                            <div class="form-outline mb-4">
                                <input type="text" id="guaranteeId"  class="form-control" value="{{$forms->garantinis_saskaitos_nr}}" disabled/>
                                <label class="form-label" for="form6Example7">Garantijos nr</label>
                            </div>
                            @endif
                            <!-- Kompiuterio gamintojas input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="computerBrand" name="computerBrand"  class="form-control" value="{{$forms->computer->computer_brand}}" @if($forms->garantinis_saskaitos_nr != null) disabled @else required @endif/>
                                <label class="form-label" for="form6Example7">Kompiuterio gamintojas</label>
                            </div>
                            <!-- Kompiuterio modelis input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="computerModel" name="computerModel"  class="form-control" value="{{$forms->computer->computer_model}}" @if($forms->garantinis_saskaitos_nr != null) disabled @else required @endif/>
                                <label class="form-label" for="form6Example7">Kompiuterio modelis</label>
                            </div>
                            <!-- Komentaras input -->
                            <div class="form-outline mb-4">
                                <textarea class="form-control" id="comment" name="comment"  rows="4"  required>{{$forms->short_comment}}</textarea>
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
                                    @if($forms->delivery == 1)
                                        checked
                                    @endif
                                />
                                <label class="form-check-label" for="form6Example8"> Ar reikalingas kurjerio pristatymas? </label>
                            </div>
                            <!-- Adresas input -->
                            <div class="form-outline mb-4" id="addressDiv" @if($forms->delivery != 1)style="display: none"@endif>
                                <input type="text" id="address" name="address"  value="{{$forms->address}}"class="form-control" />
                                <label class="form-label" for="form6Example5">Adresas</label>
                            </div>

                            <!-- Pašto kodas input -->
                            <div class="form-outline mb-4" id="postalCodeDiv" @if($forms->delivery != 1)style="display: none"@endif>
                                <input type="text" id="postalCode" name="postalCode"  value="{{$forms->postal_code}}" class="form-control" />
                                <label class="form-label" for="form6Example6">Pašto kodas</label>
                            </div>
                            @if(Auth::user()->role == 1)
                            <hr>
                            <h5 class="text-center">Administravimo sekcija</h5>
                            <hr>
                                <select class="form-select mb-4" id="busena" name="busena" aria-label="Default select example">
                                    <option disabled>Remonto būsenos pasirinkimas</option>
                                    <option value="1" @if($forms->busena == "pateikta") selected @endif>Pateikta</option>
                                    <option value="2" @if($forms->busena == "priimta") selected @endif>Priimta</option>
                                    <option value="3" @if($forms->busena == "gauta") selected @endif>Gauta</option>
                                    <option value="4" @if($forms->busena == "taisoma") selected @endif>Taisoma</option>
                                    <option value="5" @if($forms->busena == "atlikta") selected @endif>Atlikta</option>
                                </select>
                                <div class="form-check d-flex justify-content-center mb-4">
                                    <input
                                        class="form-check-input me-2"
                                        type="checkbox"
                                        value="1"
                                        id="mailCheckbox"
                                        name="mailCheckbox"
                                        @if(old('checkbox') == 1)
                                            checked
                                        @endif
                                    />
                                    <label class="form-check-label" for="form6Example8"> Ar siūsti laišką siuntėjui? </label>
                                </div>
                                <div id="mailDiv" class="form-outline mb-4" style="display: none">
                                    <textarea class="form-control" id="mailBox" name="mailBox"  rows="4"></textarea>
                                    <label class="form-label" for="form6Example7">Laiškas kleintui</label>
                                </div>
                            @endif

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
                $('#delivery').click(function(){
                    if($(this).is(':checked')){
                        $('#addressDiv').show();
                        $('#postalCodeDiv').show();
                    } else {
                        $('#addressDiv').hide();
                        $('#postalCodeDiv').hide();
                    }
                });
                $('#mailCheckbox').click(function(){
                    if($(this).is(':checked')){
                        $('#mailDiv').show();
                    } else {
                        $('#mailDiv').hide();
                    }
                });
            </script>
@endsection
