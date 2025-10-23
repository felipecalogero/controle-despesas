<!-- Overlay para Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 sidebar-gradient shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <div class="p-6 h-full flex flex-col">
        <!-- Logo e Botão Fechar -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6 text-white"></i>
                </div>
                <h1 class="text-xl font-bold text-white">ExpenseTracker</h1>
            </div>
            <!-- Botão Fechar (Mobile) -->
            <button id="close-sidebar" class="lg:hidden text-white p-1">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Menu de Navegação -->
        <nav class="space-y-2 flex-1">
            <a href="{{ route('despesas.index') }}"
               class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                <i data-lucide="home" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <button onclick="abrirModalNovaDespesa()"
                    class="w-full text-left flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group cursor-pointer">
                <i data-lucide="plus-circle" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Nova Despesa</span>
            </button>

            <a href="{{ route('configuracoes.index') }}"
               class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                <i data-lucide="settings" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">Configurações</span>
            </a>
        </nav>

        <!-- User Profile -->
        <div class="mt-auto">
            <div class="flex items-center space-x-3 p-3 bg-white/10 rounded-xl">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="text-white font-medium text-sm">Felipe</p>
                    <p class="text-gray-400 text-xs">Desenvolvedor</p>
                </div>
            </div>
        </div>
    </div>
</aside>
