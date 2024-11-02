<x-app-layout>

    {{-- route pour la recherche de l'utilisateur personnalisé à ses posts--}}
    <form action="{{ route('profile.index', $user->id) }}" method="GET" class="mb-4">
        <div class="flex items-center justify-center">
            <input
              type="text"
              name="search"
              id="search"
              placeholder="Rechercher un post"
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

<x-informations-profile :user="$user"></x-informations-profile>
<p class="text-gray-700 font-medium">Abonnés : {{ $user->follower()->count() }}</p>

    <h1 class="font-bold text-3xl mb-4 text-center">Mon profil</h1>

    <div class="grid grid-cols-1 gap-4 max-w-xl  m-auto">
        <div class="grid grid-cols-1 gap-4 max-w-xl  m-auto">
            @forelse ($posts as $post)
            <div class="">
                <x-post-card :post="$post" />
            </div>
              @empty
              <div class="text-gray-700">Aucun posts</div>
              @endforelse
          </div>
    </div>
    <div class="mt-8 text-center">{{ $posts->links() }}</div>
</x-app-layout>
