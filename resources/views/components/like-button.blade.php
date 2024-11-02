
 <form action="{{ route('front.posts.likes.addandremove', $post->id) }}" method="POST"
        class="">
        @csrf
   {{-- gère l'animation du like --}}
        @if    (
            ($post->likes->contains('post_id', $post->id)) &&
            ($post->likes->contains('user_id', auth()->user()->id))
        )
        <button type="submit" class="font-bold px-4 py-2 rounded text-center flex">
                <p><x-heroicon-o-heart class="w-5 h-5 fill-current text-red-700" /></p>
                <p class="pl-2">{{ $post->likes()->count()}} j'aime</p>
        </button>
        @else
        <button type="submit" class="font-bold px-4 py-2 rounded  text-center flex">
            <p><x-heroicon-o-heart class="w-5 h-5 fill-current text-black-700" /></p>
            <p class="pl-2">{{ $post->likes()->count()}} j'aime</p>
    </button>
        @endif

    </form>


