<x-app-layout>

{{-- Affichage du show grâce au controller --}}
    <div class="border-solid bg-slate-300 flex flex-col  justify-center max-w-xl p-5  m-auto">

        <img
        src="{{ asset('storage/' . $post->img_path) }}"
        alt="{{ Str::limit(\nl2br(e($post->body)), 150) }}"
        class="rounded shadow aspect-auto object-cover object-center"
      />
      <div class="mt-4 flex">
        <a href="{{ route('profile.show', $post->user->id) }}" class="group justify-items-center text-center">
            <x-avatar class="h-16 w-16" :user="$post->user" />
            <span class="text-xl font-semibold text-red-600 transition duration-200 group-hover:text-red-700 group-hover:underline underline-offset-2">
                {{ \nl2br(e($post->user->name)) }}
            </span>
        </a>
        <p class="text-gray-700 pl-5 max-w-[85%] break-words">{{ Str::limit(\nl2br(e($post->body)))}}</p>

 {{-- LIKE  --}}
    </div>
    <x-like-button :post="$post" />
    </div>

    <div class="mt-8 flex items-center justify-center">
        <a
            href="{{ route('front.posts.index') }}"
            class="font-bold bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition"
        >
            Retour à la liste des posts
        </a>
    </div>
    <h2 class="font-bold text-xl mb-4">Commentaires</h2>

    <div class="flex-col space-y-4">
{{-- Affichage des commentaires --}}
        @forelse ($post->comments as $comment)
            <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                <div class="flex justify-start items-start h-full">
                    <x-avatar class="h-10 w-10" :user="$comment->user" />
                </div>
                <div class="flex flex-col justify-center w-full space-y-4">
                    <div class="flex justify-between">
                        <div class="flex space-x-4 items-center justify-center">
                            <div class="flex flex-col justify-center">
                                <div class="text-gray-700">{{ $comment->user->name }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            @can('delete', $comment)
                                <button x-data="{ id: {{ $comment->id }} }"
                                    x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-comment-deletion');"
                                    type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                                    <x-heroicon-o-trash class="h-5 w-5" />
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="flex flex-col justify-center w-full btext-gray-700">
                        <p class="border bg-gray-100 rounded-md p-4">
                            {{ $comment->body }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
                <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                    Aucun commentaire pour l'instant
                </div>
            @endforelse

{{-- IDENTIFICATION COMMENTAIRE --}}
             @auth
        <form action="{{ route('front.posts.comments.add', $post) }}" method="POST"
        class="flex bg-white rounded-md shadow p-4">
        @csrf
        <div class="flex justify-start items-start h-full mr-4">
            <x-avatar class="h-10 w-10" :user="auth()->user()" />
        </div>
        <div class="flex flex-col justify-center w-full">
            <div class="text-gray-700">{{ auth()->user()->name }}</div>
            <div class="text-gray-500 text-sm">{{ auth()->user()->email }}</div>
            <div class="text-gray-700">
                <textarea name="body" id="body" rows="4" placeholder="Votre commentaire"
                    class="w-full rounded-md shadow-sm border-gray-300 bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-4"></textarea>
            </div>
            <div class="text-gray-700 mt-2 flex justify-end">
                <button type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                    Ajouter un commentaire
                </button>
            </div>
        </div>
    </form>
@else
    <div class="flex bg-white rounded-md shadow p-4 text-gray-700 justify-between items-center">
        <span> Vous devez être connecté pour ajouter un commentaire </span>
        <a href="{{ route('login') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow-md">Se
            connecter</a>
    </div>
@endauth
</div>
<x-modal name="confirm-comment-deletion" focusable>
<form method="post"
    onsubmit="event.target.action= '/posts/{{ $post->id }}/comments/' + window.selected"
    class="p-6">
    @csrf @method('DELETE')

    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Êtes-vous sûr de vouloir supprimer ce commentaire ?
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
