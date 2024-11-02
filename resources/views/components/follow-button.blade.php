{{-- si l'utilisateur connecté est différents de celui qui voit le profil --}}
@if ( Auth::user()->id !== $user->id)
        <form action="{{ route('profile.follower', $user->id) }}" method="POST">
            @csrf

            @if (!$follows)
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold
            rounded-lg hover:bg-blue-600 focus:outline-none
            focus:ring-2 focus:ring-blue-300
            transition duration-200">
        Suivre

        </button>
            @else
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold
            rounded-lg hover:bg-blue-600 focus:outline-none
            focus:ring-2 focus:ring-blue-300
            transition duration-200">
            Désabonner
        </button>
            @endif

        </form>

<!-- Compteur d'abonnés -->
<p class="text-gray-700 font-medium">Abonnés : {{ $user->follower()->count() }}</p>
@endif
