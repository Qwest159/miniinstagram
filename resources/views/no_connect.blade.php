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
 <h1>   CECI EST MON INSTA accueil</h1>
</main>
</body>
</html>
