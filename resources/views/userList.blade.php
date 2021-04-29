@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h5 class="text-center">Vartotojų valdymas</h5>
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
                @include('Tables.UserListTableTop')
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
                    url: "{{route('admin-users-list-datatable')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
                    },
                },
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: 6,
                        orderable: false,
                        render: function (data, type, row){
                            var dataRow = '';
                            dataRow += '<div class="row">';
                            dataRow += '<div class="col-md-6">';
                            dataRow += '<a href="{{route('admin-user-edit-show', '')}}/' + data[0] + '"> <i class="fas fa-highlighter"></i></a>';
                            console.log(data[0]);
                            dataRow += '</div>';
                            dataRow += '<div class="col-md-6">';
                            dataRow += '<a href="{{route('admin-user-delete', '')}}/' + data[0] + '"> <i class="fas fa-trash-alt"></i></a>';
                            dataRow += '</div>';
                            dataRow += '</div>';
                            return dataRow;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
