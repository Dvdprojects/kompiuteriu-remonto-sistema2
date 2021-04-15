<tr>
    <th scope="row">{{$loop->iteration}}</th>
    @if(Auth::user()->role == 1)
        <td>{{$forma->forms->name . ' ' . $forma->forms->surname}}</td>
    @endif
    <td>{{$forma->computer_brand}}</td>
    <td>{{$forma->computer_model}}</td>
    <td>{{$forma->comment}}</td>
    @if($forma->delivery == 1)
        <td>Kurjerio pristatymas</td>
    @else
        <td>Pristatysite patys</td>
    @endif
    <td>{{$forma->busena}}</td>
    <td>{{$forma->saskaitos_nr}}</td>
    <td>
        <div class="row">
            @if($forma->busena == "Atlikta" && $forma->comment_state != 1)

                <div class="col-md-3">
                    <a href="/download-guarantee/{{$forma->id}}"> <i class="fas fa-file-alt"></i></a>
                </div>
                <div class="col-md-3">
                    <a href="/leave-comment/{{$forma->id}}"> <i class="fas fa-comment-alt"></i></a>
                </div>
                <div class="col-md-3">
                    <a href="/form-edit/{{$forma->id}}"> <i class="fas fa-edit"></i></a>
                </div>
                <div class="col-md-3">
                    <a href="/form-delete/{{$forma->id}}" onclick="return confirm('Ar tikrai norite ištrinti šį įrašą??');"> <i class="fas fa-trash-alt"></i></a>
                </div>
            @else
                <div class="col-md-4">
                    <a href="/download-guarantee/{{$forma->id}}"> <i class="fas fa-file-alt"></i></a>
                </div>
                <div class="col-md-4">
                    <a href="/form-edit/{{$forma->id}}"> <i class="fas fa-edit"></i></a>
                </div>
                <div class="col-md-4">
                    <a href="/form-delete/{{$forma->id}}" onclick="return confirm('Ar tikrai norite ištrinti šį įrašą??');"> <i class="fas fa-trash-alt"></i></a>
                </div>
            @endif
        </div>
    </td>
</tr>
