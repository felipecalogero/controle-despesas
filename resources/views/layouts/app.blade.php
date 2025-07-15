<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Controle de Gastos')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-gradient {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .expense-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen">

<!-- Layout Principal -->
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 sidebar-gradient shadow-2xl">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6 text-white"></i>
                </div>
                <h1 class="text-xl font-bold text-white">ExpenseTracker</h1>
            </div>

            <!-- Menu de Navegação -->
            <nav class="space-y-2">
                <a href="{{ route('despesas.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <i data-lucide="home" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('despesas.create') }}"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <i data-lucide="plus-circle" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Nova Despesa</span>
                </a>

                <a href="#"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Relatórios</span>
                </a>

                <a href="#"
                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group">
                    <i data-lucide="settings" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Configurações</span>
                </a>
            </nav>
        </div>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 right-0 p-6">
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
    </aside>

    <!-- Conteúdo Principal -->
    <main class="flex-1 overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-gray-600 mt-1">@yield('page-subtitle', 'Gerencie suas despesas de forma inteligente')</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notificações -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="bell" class="w-6 h-6"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Data atual -->
                        <div class="text-sm text-gray-500">
                            {{ date('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Conteúdo da Página -->
        <div class="p-8 overflow-y-auto h-full animate-fade-in">
            @yield('content')
        </div>
    </main>
</div>

<!-- Scripts -->
<script>
    // Inicializar ícones Lucide
    lucide.createIcons();

    // Adicionar animações suaves
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.hover-scale');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>

</body>
</html>
