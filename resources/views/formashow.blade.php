@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h5 class="text-center">Pateiktos formos</h5>
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
    <table id="formaTable" class="table text-center">
    @include('Tables.UserFormsTableTop')
  <tbody>
  </tbody>
</table>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#formaTable').DataTable({
            "processing": true,
            "serverSide": true,
                "ajax": "{{route('form-show-datatables')}}",
                "columns": [
                    { "data": "computer_brand"},
                    { "data": "computer_model"},
                    { "data": "comment"},
                    { "data": "delivery"},
                    { "data": "busena"},
                    { "data": "saskaitos_nr"}
                ]
            });
        } );
    </script>
@endsection
