<x-app-layout>

{{-- route pour la recherche --}}
    <form action="{{ route('front.posts.index') }}" method="GET" class="mb-4">
        <div class="flex items-center justify-center">
            <input
              type="text"
              name="search"
              id="search"
              placeholder="Rechercher un post ou un utilisateur"
              class="flex-grow border border-gray-300 rounded shadow px-4 py-2 mr-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
              value="{{ request()->search }}"
              autofocus
            />
            <button
              type="submit"
              class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition"
            >
              Rechercher
            </button>
        </div>
    </form>

    <h1 class="font-bold text-3xl mb-4 text-center">Liste des posts</h1>
    <div class="grid grid-cols-1 gap-4 max-w-xl  m-auto">
        {{-- (si pas de pagination ou pagination différente de 1) et qu'il n'y a pas de recherche en cours => évite les doublons --}}

        @if(($likers->isEmpty() || $likers->currentPage() === 1) && request('search') === null)
            @foreach ($i_followed as $follows)
                <x-post-card :post="$follows" />
            @endforeach
        @endif
    </div>
    <div class="grid grid-cols-1 gap-4 max-w-xl  m-auto">
        @foreach ($likers as $liker)

            <x-post-card :post="$liker" />
        @endforeach
    </div>

    {{-- affiche les utilisateurs grâce à la recherche et si pas d'utilisateur, alors un message apparait --}}
    @if (isset($userALL[0]) )
        <h1 class="font-bold text-3xl mb-4 text-center pt-5">Le(s) profil(s) utilisateur(s)</h1>
        @foreach ($userALL as $user)
            <x-profil-accueil :user="$user" />
    @endforeach
    @elseif (request()->query('search'))
    <h1 class="font-bold text-3xl mb-4 text-center pt-5">Pas de nom utilisateur</h1>
    @endif


    <div class="mt-8 text-center">{{ $likers->links() }}</div>


</x-app-layout>
