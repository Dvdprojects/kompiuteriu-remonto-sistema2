@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">{{ __('Atsiliepimas apie remontą.') }}</h5>
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
                        <form id="pcRegistrationForm" action="{{url('leave-comment-post/' . $forms->id)}}" method="post">
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
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- Vardas input -->
                                    <div class="form-outline">
                                        <input type="text" id="computerBrand" name="computerBrand" class="form-control" value="{{$forms->computer->computer_brand}}" disabled/>
                                        <label class="form-label" for="form6Example1">Kompiuterio gamintojas</label>
                                    </div>
                                </div>
                                <!-- Pavarde input -->
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="computerModel" name="computerModel" class="form-control" value="{{$forms->computer->computer_model}}" disabled/>
                                        <label class="form-label" for="form6Example2">Kompiuterio Modelis</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Kompiuterio modelis input -->
                                <div class="" id="rateYo" style="margin: 0 auto;"></div>
                                <input type="hidden" id="rating" name="rating"  class="form-control" required/>
                                <div class="mt-5">

                                </div>
                            <!-- Komentaras input -->
                            <div class="form-outline mb-4">
                                <textarea class="form-control" id="comment" name="comment"  rows="4" @if($forms->comment != null && Auth::user()->role != 1) disabled @else required @endif>{{ $forms->comment != null ? $forms->comment->comment : "" }}</textarea>
                                <label class="form-label" for="form6Example7">Komentaras</label>
                            </div>

                            <!-- Submit button -->
                            @if($forms->comment == null || Auth::user()->role == 1)
                            <button type="submit" class="btn btn-primary btn-block mb-4">Pateikti</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script>
                $(function () {
                    $("#rateYo").rateYo({
                        starWidth: "50px",
                        rating: @if($forms->comment != null) {{ $forms->comment->rating }} @else 1 @endif,
                        precision: 1,
                        fullStar: true,
                        @if($forms->comment != null)
                        readOnly: true,
                        @endif
                        onChange: function (rating, rateYoInstance) {
                            var normalFill = $("#rateYo").rateYo("option", "rating");
                            $('#rating').val(normalFill);
                        }
                    });
                });
            </script>
        @endsection
