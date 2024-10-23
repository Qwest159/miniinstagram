<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Posts') }}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="flex justify-between mt-8">
              <div class="text-2xl">Liste des posts</div>

              <div class="flex  items-center justify-center space-x-8">
                <a
                  href="{{ route('posts.create') }}"
                  class="text-gray-500 font-bold py-2 px-4 rounded hover:bg-gray-200 transition flex items-center"
                >
                <x-heroicon-o-heart class="w-6 h-6 text-red-600" />
                  Ajouter un post
                </a>
              </div>
            </div>

            <div class="mt-6 text-gray-500">
              <table class="table-auto w-full">
                <thead>
                  <tr class="uppercase text-left">
                    <th class="px-4 py-2 border">Auteur</th>
                    <th class="px-4 py-2 border">Dernière modification</th>
                    <th class="px-4 py-2 border">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)
                  <tr
                    class="hover:bg-gray-50 odd:bg-gray-100 hover:odd:bg-gray-200 transition"
                  >
                    <td class="border px-4 py-2">{{ $post->user->name }}</td>

                    <td class="border px-4 py-2">
                      {{ $post->updated_at->diffForHumans() }}
                    </td>
                    <td class="border px-4 py-2 space-x-4">
                      <div class="flex space-x-4">
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
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="mt-4">{{ $posts->links() }}</div>
            </div>
          </div>
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
    </div>
  </x-app-layout>