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
        <div class="row mb-2">
            <div class="col-2 pt-1 ps-4 pe-0">
                <label class="form-label d-inline mb-0" for="form6Example7">Filtruoti pagal būseną:</label>
            </div>
            <div class="col-3 ps-0">
                <select class="form-select" id="busena" name="busena" aria-label="Default select example">
                    <option value="-1" selected>Remonto būsenos pasirinkimas</option>
                    <option value="1">Pateikta</option>
                    <option value="2">Priimta</option>
                    <option value="3">Gauta</option>
                    <option value="4">Taisoma</option>
                    <option value="5">Atlikta</option>
                </select>
            </div>
        </div>
    <table id="formDataTable" class="table text-center">
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
            $('#formDataTable').DataTable({
            "processing": true,
            "serverSide": true,
                "ajax": {
                    url: "{{route('form-show-datatables')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
                    },
                    data: function(jsonData) {
                        jsonData.stateFilter = $('#busena').val();
                    }
                },
                columnDefs: [
                    {
                        targets: 3,
                        orderable: false
                    },
                    {
                        className: 'text-center',
                        targets: 7,
                        orderable: false,
                        render: function (data, type, row){
                            var dataRow = '';
                            if(data[1] === 1)
                            {
                                dataRow += '<div class="row">';
                                dataRow += '<div class="col-md-6">';
                                dataRow += '<a href="{{route('form-edit', '')}}/' + data[0] + '"> <i class="fas fa-edit"></i></a>';
                                dataRow += '</div>';
                                dataRow += '<div class="col-md-6">';
                                dataRow += '<a href="{{route('form-delete', '')}}/' + data[0] + '"> <i class="fas fa-trash-alt"></i></a>';
                                dataRow += '</div>';
                                dataRow += '</div>';
                            }
                            else if (data[1] === 2)
                            {
                                dataRow += '<div class="row">';
                                dataRow += '<div class="col-md-6">';
                                dataRow += '<a href="{{route('download-guarantee', '')}}/' + data[0] + '"> <i class="fas fa-file-alt"></i></a>';
                                dataRow += '</div>';
                                dataRow += '<div class="col-md-6">';
                                dataRow += '<a href="{{route('leave-comment', '')}}/' + data[0] + '"> <i class="fas fa-comment-alt"></i></a>';
                                dataRow += '</div>';
                                dataRow += '</div>';
                            }
                            else if (data[1] === 3)
                            {
                                dataRow += '<div class="row">';
                                dataRow += '<div class="col-md-4">';
                                dataRow += '<a href="{{route('leave-comment', '')}}/' + data[0] + '"> <i class="fas fa-comment-alt"></i></a>';
                                dataRow += '</div>';
                                dataRow += '<div class="col-md-4">';
                                dataRow += '<a href="{{route('form-edit', '')}}/' + data[0] + '"> <i class="fas fa-edit"></i></a>';
                                dataRow += '</div>';
                                dataRow += '<div class="col-md-4">';
                                dataRow += '<a href="{{route('form-delete', '')}}/' + data[0] + '"> <i class="fas fa-trash-alt"></i></a>';
                                dataRow += '</div>';
                                dataRow += '</div>';
                            }
                            return dataRow;
                        }
                    }
                ],
                order: [5, 'desc'],
            });
            $('#busena').on('change', function(e) {
                $('#formDataTable').DataTable().ajax.reload();
            });
        });
    </script>
@endsection
