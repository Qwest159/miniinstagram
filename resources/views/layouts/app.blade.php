<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class=" bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <x-modal name="confirm-post-deletion" focusable>
            <form
              method="post"
              onsubmit="event.target.action= '/admin/posts/' + window.selected"
              class="p-6"
            >
              @csrf @method('DELETE')

              <h2 class="text-lg font-medium text-black">
                Êtes-vous sûr de vouloir supprimer ce post ?
              </h2>

              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Cette action est irréversible. Toutes les données seront supprimées.
              </p>

              <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                  Annuler
                </x-secondary-button>

                <x-danger-button class="ml-3" type="submit">
                  Supprimer
                </x-danger-button>
              </div>
            </form>
          </x-modal>
    </body>
</html>
