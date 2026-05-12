<nav class="bg-white/95 backdrop-blur-sm shadow-sm fixed w-full z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="text-xl font-bold text-indigo-600 tracking-tight">
            Sponsor<span class="text-indigo-400">ea</span>
        </a>

        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->isEvent())
                    <a href="{{ route('event.dashboard') }}"
                       class="text-gray-600 hover:text-indigo-600 transition text-sm font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('company.dashboard') }}"
                       class="text-gray-600 hover:text-indigo-600 transition text-sm font-medium">
                        Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition text-sm font-medium">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-gray-600 hover:text-indigo-600 transition text-sm font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</nav>