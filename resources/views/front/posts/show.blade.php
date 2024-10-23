<x-guest-layout>
    <h1 class="font-bold text-xl mb-4 capitalize">{{ $post->title }}</h1>

    <div class="mb-4 text-xs text-gray-500">
      {{ $post->published_at?->diffForHumans() }}
    </div>

    <div class="flex items-center justify-center">
      <img
        src="{{ asset('storage/' . $post->img_path) }}"
        alt="illustration de l'post"
        class="rounded shadow aspect-auto object-cover object-center"
      />
    </div>

    <div class="mt-4">{!! \nl2br(e($post->body)) !!}</div>

    <div class="flex mt-8">
      <x-avatar class="h-20 w-20" :user="$post->user" />
      <div class="ml-4 flex flex-col justify-center">
        <div class="text-gray-700">{{ $post->user->name }}</div>
        <div class="text-gray-500">{{ $post->user->email }}</div>
      </div>
    </div>

    <div class="mt-8 flex items-center justify-center">
      <a
        href="{{ route('front.posts.index') }}"
        class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow"
      >
        Retour à la liste des posts
      </a>
    </div>
  </x-guest-layout>