<a href="{{route('offer.create')}}">Ajouter une offre</a>

@foreach($offers as $offer)
    <section>
        {{$offer->name}} - {{$offer->company->nom}} - {{$offer->date_debut}} : <br> 
        L'adresse : {{$offer->address}} <br>
        Rémunération : <strong>{{$offer->salaire}}€</strong> <br>

        <form action="{{ route('offer.destroy', $offer) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('Confirmer la suppression ?')">
                Supprimer
            </button>
        </form>
    </section>
@endforeach


<style>
    section{
        margin: 5px;
        padding: 5px;
        border: 1px, solid, black;
    }
</style>