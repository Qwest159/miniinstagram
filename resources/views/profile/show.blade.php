<x-app-layout>
       {{-- route pour la recherche de l'utilisateur personnalisé à ses posts--}}
    <form action="{{ route('profile.show', $user->id) }}" method="GET" class="mb-4">
        @csrf
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


<x-follow-button :user="$user" :follows="$follows"/>
    <div class="grid grid-cols-1 gap-4 max-w-xl  m-auto">
      @forelse ($posts as $post)

          <x-post-card :post="$post"/>

        @empty
        <div class="text-gray-700 text-center">Aucun posts</div>
        @endforelse
    </div>

  </x-app-layout>
