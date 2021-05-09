@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Carousel wrapper -->
    <div
        id="carouselBasicExample"
        class="carousel slide carousel-fade"
        data-mdb-ride="carousel"
    >
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button
                type="button"
                data-mdb-target="#carouselBasicExample"
                data-mdb-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
            ></button>
            <button
                type="button"
                data-mdb-target="#carouselBasicExample"
                data-mdb-slide-to="1"
                aria-label="Slide 2"
            ></button>
            <button
                type="button"
                data-mdb-target="#carouselBasicExample"
                data-mdb-slide-to="2"
                aria-label="Slide 3"
            ></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner">
            <!-- Single item -->
            <div class="carousel-item active">
                <img
                    src="https://images.unsplash.com/photo-1543965860-82ed7d542cc4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1942&q=80"
                    class="d-block w-100"
                    alt="..."
                />
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <img
                    src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1951&q=80"
                    class="d-block w-100"
                    alt="..."
                />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <img
                    src="https://images.unsplash.com/photo-1584438784894-089d6a62b8fa?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                    class="d-block w-100"
                    alt="..."
                />
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                </div>
            </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button
            class="carousel-control-prev"
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide="prev"
        >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide="next"
        >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!------------------------------------------ Carousel wrapper ---------------------------------------------------------------------------------->
    @auth
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pildykite remonto forma ir mūsų specialistai apžiūrės jūsų įrenginį.</h5>
                <a href="{{ url('/forma') }}" class="text-sm text-gray-700 underline">Registruoti įrenginį</a>
            </div>
        </div>
    @endauth
    @guest
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Registruokitės tinklalapyje, užpildykite formą ir mūsų specialistai sutvarkys jūsų įrenginį.</h5>
                @if (Route::has('login'))
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                        <a href="{{ route('login') }}" class="btn btn-dark btn-rounded">  Login  </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark btn-rounded">Register</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endguest
    <div class="row">
        <div class="col-md-12">
            <img src="{{asset('images\blade.png')}}" style="height: 100px; width: 100%" class="img-fluid" alt="..." />
        </div>
    </div>
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Patikrinkite savo įrenginio remonto būseną, vieno mygtuko paspaudimu!</h5>
            <form id="checkRepairState" class="row g-3 justify-content-center">
                <div class="col-auto">
                    <label for="saskaitosnr" class="visually-hidden">Saskaitos numeris</label>
                </div>
                <div class="col-auto">
                    <input type="numeric" class="form-control" id="saskNr" required>
                </div>
                <div class="col-auto">
                    <button id="repairStateCheckClick" type="submit" class="btn btn-dark btn-rounded">Tikrinti</button>
                </div>
            </form>
            <div id="checkRepairStateResponse"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        var responseDiv = document.getElementById('checkRepairStateResponse');
        $('#checkRepairState').on('submit', function (event) {
            event.preventDefault();
            var data = $('#saskNr').val();
            $.ajax({
                type: "GET",
                url: "{{route('check')}}",
                data: {
                    saskNr: jQuery('#saskNr').val(),
                },
                success: function (response) {
                    responseDiv.innerText = "Jūsų remonto būsena: '" + response + "'";
                    console.log(response);
                    },
                error: function(xhr, status, error){
                    console.log(error);
                    responseDiv.innerText = "Toks sąskaitos numeris neegzistuoja, prašome patikslinti numerį.";
                }
                });
            });
        });
</script>
@endsection
