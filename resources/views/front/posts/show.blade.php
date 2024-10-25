<x-app-layout>

    {{-- <div class="mb-4 text-xs text-gray-500">
      {{ $post->published_at?->diffForHumans() }}
    </div> --}}




    <div class="border-solid bg-slate-300 flex flex-col  justify-center max-w-xl p-5  m-auto">

        <img
        src="{{ asset('storage/' . $post->img_path) }}"
        alt="illustration du post"
        class="rounded shadow aspect-auto object-cover object-center"
      />
      <div class="mt-4 flex">
        <a href="{{ route('profil_perso.show', $post->user->id) }}" class="group justify-items-center text-center">
            <x-avatar class="h-16 w-16" :user="$post->user" />
            <span class="text-xl font-semibold text-red-600 transition duration-200 group-hover:text-red-700 group-hover:underline underline-offset-2">
                {{ \nl2br(e($post->user->name)) }}
            </span>
        </a>
        <p class="text-gray-700 pl-5 max-w-[85%] break-words">{{ Str::limit(\nl2br(e($post->body)))}}</p>
    </div>
    </div>

    <div class="flex items-center mt-6 ">
        <a href="{{ route('profil_perso.show', $post->user->id) }}" class="flex items-center">
            <x-avatar class="h-16 w-16" :user="$post->user" />
            <div class="ml-4 flex flex-col justify-center">
                <div class=" font-semibold text-lg">{{ $post->user->name }}</div> {{-- Augmente la taille du nom --}}
                <div class="text-gray-700 ">{{ $post->user->email }}</div> {{-- Augmente la taille de l'email --}}
                <div class="text-gray-700 ">{{ $post->user->biography }}</div> {{-- Augmente la taille de la biographie --}}
            </div>
        </a>
    </div>

    <div class="mt-8 flex items-center justify-center">
        <a
            href="{{ route('front.posts.index') }}"
            class="font-bold bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition"
        >
            Retour à la liste des posts
        </a>
    </div>
  </x-app-layout>
