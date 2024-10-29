<x-app-layout>
    <div class="flex mt-8">
        <x-avatar class="h-20 w-20 mb-4" :user="$user" />
        <div class="ml-4 flex flex-col justify-center">
          <div class="text-gray-700">{{ $user->name }}</div>
          <div class="text-gray-500">{{ $user->email }}</div>
          <div class="text-gray-500">{{ $user->biography }}</div>
        </div>
      </div>

    <form action="{{ route('profile.show',$user->id) }}" method="GET" class="mb-4">
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
      @forelse ($posts as $post)
      <div class="">
          <x-post-card :post="$post" />
      </div>
        @empty
        <div class="text-gray-700">Aucun posts</div>
        @endforelse
    </div>

  </x-app-layout>
