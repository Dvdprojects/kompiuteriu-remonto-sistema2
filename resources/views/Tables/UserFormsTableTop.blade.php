<thead>
<tr>
    <th scope="col">#</th>
    @if(Auth::user()->role == 1)
        <th scope="col">Pateikė</th>
    @endif
    <th scope="col">Kompiuterio gamintojas</th>
    <th scope="col">Kompiuterio modelis</th>
    <th scope="col">Komentaras</th>
    <th scope="col">Pristatymo Budas</th>
    <th scope="col">cc</th>
    <th scope="col">Saskaitos Numeris</th>
    <th scope="col">Veiksmai</th>
</tr>
</thead>
