@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
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
        <div class="row">
            <div class="col-sm-4">
                <div class="card shadow-1-strong">
                    <div class="card-body text-left">
                        <h5 class="text-center">Naujausi atsiliepimai</h5>
                        <hr>
                        @if(count($visibleComments) < 1)
                            <p class="card-text">Nėra atsiliepimu</p>
                        @else
                            @foreach ($visibleComments as $comment)
                                <div class="row">
                                    <div class="col-8">
                                        <p class="card-text">{{ $comment->comment }}</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="rating" style="margin: 0 auto;" data-rating="{{ $comment->rating }}"></div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card shadow-1-strong h-100">
                    <div class="card-body text-left">
                        <h5 class="text-center">Atsiliepimų įvertinimo vidurkis</h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <p class="card-text">{{ number_format($averageRating, 2) }} / 5.00</p>
                            </div>
                            <div class="col-8">
                                <div id="average-rating" style="margin: 0 auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card shadow-1-strong h-100">
                    <div class="card-body text-left">
                        <h5 class="text-center">Vidutinė kompiuterio taisymo trukmė</h5>
                        <hr>
                        <p class="card-text text-center">{{ $time }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <img src="https://i.ibb.co/PcPVQNM/main-page.png" class="img-fluid" alt="no photo" />
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.rating').each(function() {
                let rating = $(this).data('rating');
                $(this).rateYo({
                    starWidth: "20px",
                    rating: rating,
                    precision: 1,
                    fullStar: true,
                    readOnly: true,
                });
            });
            $('#average-rating').rateYo({
                starWidth: "40px",
                rating: {{ $averageRating }},
                precision: 2,
                fullStar: true,
                readOnly: true,
            });
        });
    </script>
@endsection
