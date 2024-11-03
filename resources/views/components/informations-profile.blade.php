<div class="flex m-9 p-9 bg-gray-200 rounded-lg shadow-md ">
    <div class="flex flex-col  mr-4">
        <x-avatar class="w-24 h-24 rounded-full border-4 border-blue-500" :user="$user" />
        <div class="text-lg text-center font-semibold text-gray-800">{{ $user->name }}</div>

    </div>

    <div class="flex-grow ml-9">
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
