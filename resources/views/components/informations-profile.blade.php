<div class="flex m-9 p-9 bg-gray-200 rounded-lg shadow-md">
    <div class="flex flex-col w-24 h-24 mr-4">
        <x-avatar class="rounded-full border-4 border-blue-500" :user="$user" />
        <div class="text-lg font-semibold text-gray-800">{{ $user->name }}</div>
        <div class="text-gray-600">{{ $user->email }}</div>
    </div>

    <div class="flex-grow ml-9">
        <div class="text-gray-500 break-words">{{ $user->biography }}</div>
    </div>
</div>
