<x-app-layout>
    <div class="flex items-center justify-center space-x-8 mb-6">
        <a
          href="{{ route('posts.create') }}"
          class="text-white bg-blue-500 font-bold py-2 px-4 rounded hover:bg-blue-600 transition flex items-center"
        >
          Ajouter un post
        </a>
    </div>

    <h1 class="font-bold text-3xl mb-4 text-center">Mon profil</h1>



      <div class="flex flex-col w-full pb-5">
        <div class="w-5 p-5">  <x-avatar class="" :user="$user" /></div>
          <div class="text-gray-700">{{ $user->name }}</div>
          <div class="text-gray-500">{{ $user->email }}</div>
          <div class="text-gray-500  break-words">{{ $user->biography }}</div>
      </div>

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
