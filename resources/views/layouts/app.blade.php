<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <div
            x-data="toastNotification()"
            x-init="startChecking()"
            class="fixed top-5 right-5 z-50 space-y-3">

            <template x-for="toast in toasts" :key="toast.id">
                <div
                    x-show="toast.show"
                    x-transition
                    class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg w-72">

                    🔔 <span x-text="toast.message"></span>
                </div>
            </template>
        </div>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
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

        <script>
            function toastNotification() {
                return {
                    toasts: [],

                    startChecking() {
                        setInterval(() => {
                            fetch('/notifications/latest')
                                .then(res => res.json())
                                .then(data => {

                                    if (data.length) {
                                        data.forEach(n => {
                                            this.addToast(n.message);
                                        });
                                    }

                                });
                        }, 10000); // كل 10 ثواني
                    },

                    addToast(message) {

                        let id = Date.now();

                        this.toasts.push({
                            id: id,
                            message: message,
                            show: true
                        });

                        setTimeout(() => {
                            this.toasts =
                                this.toasts.filter(t => t.id !== id);
                        }, 5000);
                    }
                }
            }
        </script>


        <audio id="notifSound" src="/public/sounds/soundsNotify.mp3" preload="auto"></audio>


    </body>
</html>
