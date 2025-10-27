<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }

        .form-transition {
            transition: all 0.3s ease-in-out;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .input-focus {
            transition: all 0.2s ease-in-out;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
<!-- Container Principal -->
<div class="w-full max-w-md">
    <!-- Header com Logo/Título -->
    <div class="text-center mb-8 fade-in">
        <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-4 hover-scale">
            <i data-lucide="user-circle" class="w-8 h-8 text-purple-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">Bem-vindo!</h1>
        <p class="text-purple-100">Faça login ou crie sua conta</p>
    </div>

    <!-- Card Principal -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover-scale fade-in">
        <!-- Tabs de Navegação -->
        <div class="flex">
            <button id="loginTab" class="flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                <div class="flex items-center justify-center space-x-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    <span>Login</span>
                </div>
            </button>
            <button id="registerTab" class="flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200">
                <div class="flex items-center justify-center space-x-2">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    <span>Cadastro</span>
                </div>
            </button>
        </div>

        <!-- Formulário de Login -->
        <div id="loginForm" class="p-8 form-transition">

            @if ($errors->has('login'))
                <div class="text-red-500 text-sm mt-2 text-center">
                    {{ $errors->first('login') }}
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login.store') }}" method="POST" name="login">
                @csrf
                <div>
                    <input type="hidden" name="tipo" value="login">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="mail" class="w-4 h-4 inline mr-2"></i>
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus"
                           placeholder="seu@email.com"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="lock" class="w-4 h-4 inline mr-2"></i>
                        Senha
                    </label>
                    <div class="relative">
                        <input type="password"
                               name="password"
                               id="loginPassword"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus pr-12"
                               placeholder="••••••••"
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePassword('loginPassword', this)">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                    </label>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Esqueceu a senha?
                    </a>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl hover-scale">
                        <div class="flex items-center justify-center space-x-2">
                                <i data-lucide="log-in" class="w-5 h-5"></i>
                                <span>Entrar</span>
                        </div>
                </button>
            </form>

            <!-- Divisor -->
            <div class="mt-6 flex items-center">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-sm text-gray-500">ou</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Login Social -->
            <div class="mt-6 space-y-3">
                <a href="{{ route('facebook.redirect') }}">
                <button class="w-full py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 hover-scale">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Continuar com Google</span>
                    </div>
                </button>
                </a>

                <a href="{{ route('facebook.redirect') }}">
                    <button class="mt-3 w-full py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 hover-scale">
                        <div class="flex items-center justify-center space-x-2">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                            <span class="text-gray-700 font-medium">Continuar com Facebook</span>
                        </div>
                    </button>
                </a>

                <button class="w-full py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 hover-scale">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="github" class="w-5 h-5"></i>
                        <span class="text-gray-700 font-medium">Continuar com GitHub</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Formulário de Cadastro -->
        <div id="registerForm" class="p-8 form-transition hidden">
            <form class="space-y-6" method="POST" action="{{ route('login.store') }}" name="cadastro">
                @csrf
                <input type="hidden" name="tipo" value="cadastro">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                            Nome
                        </label>
                        <input type="text"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus"
                               placeholder="João"
                               name="name"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                            Sobrenome
                        </label>
                        <input type="text"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus"
                               placeholder="Silva"
                               name="last_name"
                               required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="mail" class="w-4 h-4 inline mr-2"></i>
                        Email
                    </label>
                    <input type="email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus"
                           placeholder="seu@email.com"
                           name="email"
                           required>
                </div>

{{--                <div>--}}
{{--                    <label class="block text-sm font-medium text-gray-700 mb-2">--}}
{{--                        <i data-lucide="phone" class="w-4 h-4 inline mr-2"></i>--}}
{{--                        Telefone--}}
{{--                    </label>--}}
{{--                    <input type="tel"--}}
{{--                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus"--}}
{{--                           placeholder="(11) 99999-9999"--}}
{{--                           required>--}}
{{--                </div>--}}

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="lock" class="w-4 h-4 inline mr-2"></i>
                        Senha
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="registerPassword"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus pr-12"
                               placeholder="••••••••"
                               name="password"
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePassword('registerPassword', this)">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="mt-2">
                        <div class="flex items-center space-x-2 text-xs">
                            <div class="flex-1 bg-gray-200 rounded-full h-1">
                                <div id="passwordStrength" class="h-1 rounded-full transition-all duration-300"></div>
                            </div>
                            <span id="passwordStrengthText" class="text-gray-500">Fraca</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i data-lucide="lock" class="w-4 h-4 inline mr-2"></i>
                        Confirmar Senha
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="confirmPassword"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus pr-12"
                               placeholder="••••••••"
                               name="verify_password"
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePassword('confirmPassword', this)">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-start space-x-2">
                    <input type="checkbox" class="mt-1 rounded border-gray-300 text-purple-600 focus:ring-purple-500" required>
                    <span class="text-sm text-gray-600">
                            Eu concordo com os
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">Termos de Uso</a>
                            e
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">Política de Privacidade</a>
                        </span>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl hover-scale">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="user-plus" class="w-5 h-5"></i>
                        <span>Criar Conta</span>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-8 fade-in">
        <p class="text-purple-100 text-sm">
            © 2024 Sua Empresa. Todos os direitos reservados.
        </p>
    </div>
</div>

<script src="js/login.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
</body>
</html>

