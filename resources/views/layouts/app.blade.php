<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Prevent Alpine flicker -->
    <style>
        [x-cloak] { display:none !important; }
    </style>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

<div class="min-h-screen bg-gray-100 dark:bg-gray-900">

    @include('layouts.navigation')

    <!-- ✅ Toast Notifications -->
    <div
        x-data="toastNotification()"
        x-init="startChecking()"
        class="fixed top-5 right-5 z-50 space-y-3"
        x-cloak>

        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="toast.show"
                x-transition
                class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg w-72">

                🔔 <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
    </main>

</div>

<script>
function toastNotification() {
    return {

        toasts: [],
        lastNotificationId: localStorage.getItem('lastNotificationId') || null,

        startChecking() {

            setInterval(() => {

                fetch('/notifications/latest')
                    .then(res => res.json())
                    .then(data => {

                        // UPDATE BELL
                        window.dispatchEvent(
                            new CustomEvent('notifications-updated', {
                                detail: { count: data.count }
                            })
                        );

                        if (data.notifications.length) {

                            let newest = data.notifications[0];

                            // 🔥 PLAY SOUND ONLY IF NEW ID
                            if (this.lastNotificationId != newest.id) {

                                this.lastNotificationId = newest.id;
                                localStorage.setItem('lastNotificationId', newest.id);

                                const sound = document.getElementById('notifSound');
                                if(sound){
                                    sound.currentTime = 0;
                                    sound.play().catch(()=>{});
                                }

                                data.notifications.forEach(n => {
                                    this.addToast(n.message);
                                });
                            }
                        }

                    });

            }, 10000);
        },

        addToast(message) {

            let id = Date.now();

            this.toasts.push({
                id,
                message,
                show:true
            });

            setTimeout(()=>{
                this.toasts =
                    this.toasts.filter(t => t.id !== id);
            },5000);
        }
    }
}
</script>

<!-- SOUND -->
<audio id="notifSound" preload="auto">
    <source src="{{ asset('sounds/soundsNotify.mp3') }}" type="audio/mpeg">
</audio>

<script>
document.addEventListener('click', () => {
    const sound = document.getElementById('notifSound');
    if(sound){
        sound.play().then(()=>{
            sound.pause();
            sound.currentTime = 0;
        }).catch(()=>{});
    }
},{ once:true });
</script>

</body>
</html>