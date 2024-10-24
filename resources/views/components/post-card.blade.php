
    <a class="flex flex-col h-full space-y-4 bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition"
    href="{{ route('front.posts.show', $post) }}">
    <figure>   <img src="{{ Storage::url($post->img_path) }}" alt="illllustration du post"></figure>

    <div class="flex-grow text-gray-700 text-sm text-justify">
        {{ Str::limit($post->body, 120) }}
    </div>

</a>
