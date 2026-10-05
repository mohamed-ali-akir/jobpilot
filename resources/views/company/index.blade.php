<a href="{{route('company.create')}}">Ajouter une Entreprise</a> <br>

@foreach($companies as $company)
{{$company->nom}} <br>

<form action="{{ route('company.destroy', $company) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit"
        onclick="return confirm('Confirmer la suppression ?')">
        Supprimer
    </button>
</form>
@endforeach