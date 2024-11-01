<div class="flex flex-col space-y-4 vg-white rounded-md shadow-md p-8 max-w-xl">
    <a href="{{ route('front.posts.show', $post) }}" class="m-auto">
        <figure>
            <img src="{{ Storage::url($post->img_path) }}" alt="{{ Str::limit(\nl2br(e($post->body)), 150) }}">
        </figure>
    </a>

    <div class="mt-4 flex">
        <a href="{{ route('profile.show', $post->user->id) }}" class="group justify-items-center text-center">
            <x-avatar class="h-16 w-16" :user="$post->user" />
            <span class="text-xl font-semibold text-red-600 transition duration-200 group-hover:text-red-700 group-hover:underline underline-offset-2">
                {{ \nl2br(e($post->user->name)) }}
            </span>
        </a>
        <p class="text-gray-700 pl-5 max-w-[85%] break-words">
            {{ Str::limit(\nl2br(e($post->body)), 150) }}
        </p>
    </div>

    <div>
        <x-like-button :post="$post"/>
    </div>

    {{-- Si l'utilisateur est celui qui a créé le post ou admin, montre edit et delete --}}
    @if ($post->user_id === Auth::id() || Auth::user()->role_id === 1  )
        <div class="flex space-x-4 mt-2">
            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-400">
                <x-heroicon-o-pencil class="w-5 h-5" />
            </a>

            <button
                x-data="{ id: {{ $post->id }} }"
                x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-post-deletion');"
                type="button"
                class="text-red-400"
            >
                <x-heroicon-o-trash class="w-5 h-5" />
            </button>
        </div>
    @endif
</div>
