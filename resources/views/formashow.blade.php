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
                },
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: 6,
                        orderable: false,
                        render: function (data, type, row){
                            var dataRow = '';
                            if (data[1])
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
                            else {
                                if (data[3])
                                {
                                    dataRow += '<div class="row">';
                                    dataRow += '<div class="col-md-12">';
                                    dataRow += '<a href="{{route('download-guarantee', '')}}/' + data[0] + '"> <i class="fas fa-file-alt"></i></a>';
                                    dataRow += '</div>';
                                    dataRow += '</div>';
                                }
                                else {
                                    if (data[2])
                                    {
                                        dataRow += '<div class="row">';
                                        dataRow += '<div class="col-md-12">';
                                        dataRow += 'Negalimi';
                                        dataRow += '</div>';
                                    }
                                    else
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
                                }
                            }
                            return dataRow;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
