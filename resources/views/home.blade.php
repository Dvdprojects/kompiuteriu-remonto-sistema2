@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body text-center">
        <img src="{{asset('images\clients.png')}}" alt="No IMG">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body text-center">
        <img src="{{asset('images\clients.png')}}" alt="No IMG">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body text-center">
        <img src="{{asset('images\clients.png')}}" alt="No IMG">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-sm-8">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Specialus remontas</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
    <div class="card-body">
      <div class="chart">
            <canvas id="chart1" width="400" height="400"></canvas>
      </div>
   </div>
    </div>
  </div>
</div>
</div>
@endsection
