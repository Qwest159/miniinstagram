<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini_instagam</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <nav class="flex justify-end p-4 bg-white shadow-md">
        <a
            href="{{ route('login') }}"
            class="mx-3 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20]"
        >
            Connexion
        </a>

        <a
            href="{{ route('register') }}"
            class="mx-3 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20]"
        >
            Enregistrer
        </a>
    </nav>
<main>
    <h1 class="max-w-xl m-auto text-center mt-5">
        Bienvenue sur mon Mini-Instagram, votre plateforme idéale pour partager vos moments préférés, découvrir de nouvelles personnes et vous connecter avec des amis à travers le monde. Plongez dans un univers riche en créativité et en inspiration, où chaque photo raconte une histoire unique.
    </h1>

</main>
</body>
</html>
