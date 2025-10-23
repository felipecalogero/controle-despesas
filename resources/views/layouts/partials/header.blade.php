<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Botão Menu Hamburger (Mobile) -->
                <button id="open-sidebar" class="lg:hidden p-2 text-gray-600 hover:text-gray-900">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">@yield('page-subtitle', 'Gerencie suas despesas de forma inteligente')</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notificações -->
                <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                    <i data-lucide="bell" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                </button>

                <!-- Data atual -->
                <div class="text-sm text-gray-500 hidden sm:block">
                    {{ date('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
</header>
