@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h5 class="text-center">Pateikti atsiliepimai</h5>
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
    <table id="formDataTable" class="table text-center">
        <thead>
        <tr>
            <th scope="col">Vardas</th>
            <th scope="col">Pavardė</th>
            <th scope="col">Komentaras</th>
            <th scope="col">Įvertinimas</th>
            @if (Auth::user()->role == 1)
            <th scope="col">Veiksmai</th>
            @endif
        </tr>
        </thead>
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
            $('#formDataTable').DataTable({
            "processing": true,
            "serverSide": true,
                "ajax": {
                    url: "{{route('comments-show-datatables')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
                    },
                },
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: 3,
                        orderable: false,
                        render: function (data, type, row){
                            return '<div class="rating" style="margin: 0 auto;" data-rating="' + data + '"></div>';
                        }
                    },
                    @if (Auth::user()->role == 1)
                    {
                        className: 'text-center',
                        targets: 4,
                        orderable: false,
                        render: function (data, type, row){
                            var dataRow = '';
                            dataRow += '<div class="row">';
                            dataRow += '<div class="col-md-4">';
                            dataRow += '<a href="{{route('leave-comment', '')}}/' + data[0] + '"> <i class="fas fa-edit"></i></a>';
                            dataRow += '</div>';
                            dataRow += '<div class="col-md-4">';
                            dataRow += '<a href="{{route('comment-change-visibility', '')}}/' + data[0] + '"> <i class="far fa-eye' + (data[1] ? '' : '-slash') + '"></i></a>';
                            dataRow += '</div>';
                            dataRow += '<div class="col-md-4">';
                            dataRow += '<a href="{{route('comment-delete', '')}}/' + data[0] + '"> <i class="fas fa-trash-alt"></i></a>';
                            dataRow += '</div>';
                            dataRow += '</div>';
                            return dataRow;
                        }
                    }
                    @endif
                ],
                drawCallback: function (settings) {
                    $('.rating').each(function() {
                        let rating = $(this).data('rating');
                        $(this).rateYo({
                            starWidth: "20px",
                            rating: rating,
                            precision: 1,
                            fullStar: true,
                            readOnly: true,
                        });
                    })
                }
            });
        });
    </script>
@endsection
