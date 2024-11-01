<div>
    @if ($user->avatar_path)
    <figure   class="w-16 h-16  overflow-hidden rounded-full">
        <img class="w-full h-full  object-cover object-center"

        src="{{ asset('storage/' . $user->avatar_path) }}"
        alt="{{ $user->name }}"
      />
    </figure>

    @else
    <div class="w-full h-full aspect-square flex items-center justify-center bg-indigo-100 p-8 rounded-full">
      <span class="text-2xl font-medium text-indigo-800">
        {{ $user->name[0] }}
      </span>
    </div>
    @endif
</div>
