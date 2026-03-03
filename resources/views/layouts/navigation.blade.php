@php
$user = auth()->user();
$notifications = $user->unreadNotifications;
@endphp

<nav
    x-data="navbarComponent()"
    x-init="init()"
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

<div class="max-w-7xl mx-auto px-4">
<div class="flex justify-between h-16 items-center">

    <!-- LEFT -->
    <div class="flex items-center">
        <a href="{{ route('dashboard') }}">
            <x-application-logo
                class="block h-9 w-auto text-gray-800 dark:text-gray-200"/>
        </a>
    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-6 relative">

        <!-- 🔔 NOTIFICATIONS -->
        <div class="relative">

            <button
                @click="openNotif = !openNotif"
                class="relative text-xl">

                🔔

                <span
                    x-show="liveCount > 0"
                    x-text="liveCount"
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full">
                </span>

            </button>

            <!-- DROPDOWN -->
            <div
                x-show="openNotif"
                @click.outside="openNotif=false"
                x-transition
                class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 shadow-lg rounded-xl border dark:border-gray-700 z-50">

                <div class="p-3 font-semibold border-b dark:border-gray-700">
                    Notifications
                </div>

                <div class="max-h-80 overflow-y-auto">

                    @forelse($notifications as $notification)
                        <div
                            @click="markAsRead('{{ $notification->id }}')"
                            class="p-3 text-sm border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">

                            ⏰ {{ $notification->data['title'] }}

                            <div class="text-xs text-gray-500">
                                at {{ $notification->data['time'] }}
                            </div>

                        </div>
                    @empty
                        <div class="p-3 text-sm text-gray-500 text-center">
                            No notifications
                        </div>
                    @endforelse

                </div>

            </div>
        </div>

        <!-- USER DROPDOWN (Logout etc) -->
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="right" width="48">

                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm rounded-md
                               text-gray-500 dark:text-gray-400
                               bg-white dark:bg-gray-800
                               hover:text-gray-700 dark:hover:text-gray-300">

                        <div>{{ $user->name }}</div>

                        <svg class="ms-1 h-4 w-4 fill-current"
                             viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586
                                     l3.293-3.293a1 1 0 111.414 1.414l-4 4
                                     a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Profile
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>

            </x-dropdown>
        </div>

    </div>
</div>
</div>

<!-- Alpine Component -->
<script>
function navbarComponent() {
    return {

        openNotif:false,
        liveCount: {{ $notifications->count() }},

        init() {
            window.addEventListener('notifications-updated', (e)=>{
                this.liveCount = e.detail.count;
            });
        },

        async markAsRead(id) {

            await fetch('/notifications/read/' + id, {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                    'Accept':'application/json'
                }
            });

            location.reload();
        }
    }
}
</script>

</nav>