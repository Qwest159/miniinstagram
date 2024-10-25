
    <div class="flex flex-col h-full space-y-4 bg-white rounded-md shadow-md p-5 w-full">

        <a href="{{ route('front.posts.show', $post->id) }}">
        <figure>   <img src="{{ Storage::url($post->img_path) }}" alt="illustration du post"></figure>

            <div class="flex-grow text-gray-700 text-sm text-justify">
                {{ Str::limit($post->body, 120) }}
                </div>
                </a>
                <div class="flex">
                    <a
                    href="{{ route('posts.edit', $post->id) }}"
                    class="text-blue-400"
                >
                    <x-heroicon-o-pencil class="w-5 h-5" />
                </a>

                <button
                    x-data="{ id: {{ $post->id }} }"
                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-post-deletion');"
                    type="submit"
                    class="text-red-400"
                >
                    <x-heroicon-o-trash class="w-5 h-5" />
                </button>
                </a>
            </div>
    </div>
    <x-modal name="confirm-post-deletion" focusable>
        <form
          method="post"
          onsubmit="event.target.action= '/admin/posts/' + window.selected"
          class="p-6"
        >
          @csrf @method('DELETE')

          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Êtes-vous sûr de vouloir supprimer cet post ?
          </h2>

          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Cette action est irréversible. Toutes les données seront supprimées.
          </p>

          <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
              Annuler
            </x-secondary-button>

            <x-danger-button class="ml-3" type="submit">
              Supprimer
            </x-danger-button>
          </div>
        </form>
      </x-modal>


