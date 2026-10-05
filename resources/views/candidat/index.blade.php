@foreach($candidats as $candidat)

{{$candidat->firstname}} {{$candidat->lastname}}  <br>
<form action="{{ route('candidat.destroy', $candidat) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit"
        onclick="return confirm('Confirmer la suppression ?')">
        Supprimer
    </button>
</form>

@endforeach

<a href="{{route('candidat.create')}}">Ajouter un candidat</a>
