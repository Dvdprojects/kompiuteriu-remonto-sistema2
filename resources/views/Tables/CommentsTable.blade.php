<tr>
    <th scope="row">{{$loop->iteration}}</th>
    <td>{{$comment->comments->name . ' ' . $comment->comments->surname}}</td>
    <td>{{$comment->comment}}</td>
    <td>{{$comment->rating}}</td>
    <td>{{$comment->formComment->saskaitos_nr}}</td>
    <td>
        <div class="row">
                <div class="col-md-6">
                    <a href="/download-guarantee/{{$comment->id}}"> <i class="fas fa-check"></i></a>
                </div>
                <div class="col-md-6">
                    <a href="/form-edit/{{$comment->id}}"> <i class="fas fa-times"></i></a>
                </div>
        </div>
    </td>
</tr>
