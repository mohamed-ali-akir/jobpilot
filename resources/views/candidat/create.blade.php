<form action="{{ route('candidat.store') }}" method="POST">
    @csrf
    <label>Prénom :</label>
    <input type="text" name="firstname"> <br>
    <label>Nom :</label> <input type="text" name="lastname">
    <button type="submit">Ajouter</button>
</form>
<a href="{{route('candidat.index')}}">Annuler</a>
