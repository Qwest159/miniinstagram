    @auth

 <form action="{{ route('front.posts.likes.addandremove', $post->id) }}" method="POST"
        class="">
        @csrf
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
@else
    <div class="flex bg-white rounded-md shadow p-4 text-gray-700 justify-between items-center">
        <span> Vous devez être connecté </span>
        <a href="{{ route('login') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow-md">Se
            connecter</a>
    </div>
@endauth

