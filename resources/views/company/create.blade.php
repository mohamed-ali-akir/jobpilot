<form action="{{ route('company.store') }}" method="POST">
    @csrf
    <label>Nom :</label>
    <input type="text" name="nom"> <br>
    <button type="submit">Ajouter</button>
</form>
<a href="{{route('company.index')}}">Annuler</a>
