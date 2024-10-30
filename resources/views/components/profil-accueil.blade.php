
<div class="flex flex-col space-y-4 vg-white rounded-md shadow-md p-8 max-w-xl m-auto">
    <div class="mt-4 flex">
        <a href="{{ route('profile.show', $user->id) }}" class="group justify-items-center text-center">
            <x-avatar class="h-16 w-16" :user="$user" />
            <span class="text-xl font-semibold text-red-600 transition duration-200 group-hover:text-red-700 group-hover:underline underline-offset-2">
                {{ \nl2br(e($user->name)) }}
            </span>
        </a>
        @if ($user->biography !== Null)
        <p class="text-gray-700 pl-5 max-w-[85%] break-words">
            {{ Str::limit(\nl2br(e($user->biography)), 150) }}
        </p>
        @else
        <p class="text-gray-700 pl-5 max-w-[85%] break-words">
            No Biography
        </p>
        @endif

        </div>

</div>
