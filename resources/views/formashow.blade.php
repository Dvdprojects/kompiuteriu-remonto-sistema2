@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <table class="table text-center">
    @if(count($formaAll) < 1)
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Vardas</th>
      <th scope="col">Pavarde</th>
      <th scope="col">El. pastas</th>
      <th scope="col">Tipas</th>
      <th scope="col">Pristatymo Budas</th>
      <th scope="col">Apmokejimas</th>
      <th scope="col">Komentaras</th>
      <th scope="col">Busena</th>
      <th scope="col">Pateikta</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="10">Nera irasu</td>
    </tr>
  </tbody>
    @else
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Vardas</th>
      <th scope="col">Pavarde</th>
      <th scope="col">El. pastas</th>
      <th scope="col">Tipas</th>
      <th scope="col">Pristatymo Budas</th>
      <th scope="col">Apmokejimas</th>
      <th scope="col">Komentaras</th>
      <th scope="col">Busena</th>
      <th scope="col">Pateikta</th>
    </tr>
  </thead>
  <tbody>
  @foreach($formaAll as $key=>$forma)
    <tr>
      <th scope="row">{{$key}}</th>
      <td>{{$forma->vardas}}</td>
      <td>{{$forma->pavarde}}</td>
      <td>{{$vartotojas->email}}</td>
      <td>{{$forma->tipas}}</td>
      @if($forma->pristatymo_budas == 0)
      <td>{{"Kurjerio paslauga"}}</td>
      @else
      <td>{{"Pristatysite patys"}}</td>
      @endif
      @if($forma->apmokejimas == 0)
      <td>{{"Kortele"}}</td>
      @else
      <td>{{"Grynaisiais"}}</td>
      @endif
      <td>{{$forma->komentaras}}</td>
      <td>{{$forma->busena}}</td>
      <td>{{$forma->created_at}}</td>
      <input name="invisible" type="hidden" value=" {{++$key}} ">
    </tr>
    @endforeach
  </tbody>
  @endif
</table>
    </div>
</div>
@endsection
