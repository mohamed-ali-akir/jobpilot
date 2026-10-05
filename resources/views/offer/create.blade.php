<form action="{{ route('offer.store') }}" method="POST">
    @csrf
    <label>Nom :</label>
    <input type="text" name="name"> <br>
    <label>Entreprise :</label>
    <select name="companies_id" id="companies_id">
        @foreach($companies as $company)
            <option value="{{$company->id}}">{{$company->nom}}</option> 
        @endforeach
    </select> <br>
    <label>Date de début :</label> <input type="date" name="date_debut"> <br>
    <label>Salaire :</label> <input type="number" name="salaire"> <br>
    <label>Adresse :</label> <input type="text" name="address"><br>
    <button type="submit">Ajouter</button>
</form>
<a href="{{route('offer.index')}}">Annuler</a>
