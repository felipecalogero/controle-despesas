@extends('layouts.app')

@section('page-title', 'Configurações')
@section('page-subtitle', 'Gerencie suas preferências e dados pessoais')

@section('content')

    @if(session('sucesso'))
        <div
            class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center space-x-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl mb-6">
            <div class="flex items-center space-x-3 mb-2">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                <span class="font-medium">Por favor, corrija os seguintes erros:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Informações Pessoais -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span>Informações Pessoais</span>
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('configuracoes.atualizar-perfil') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Avatar com preview e hover -->
                        <div class="flex flex-col items-center mb-8">
                            <div class="relative group">
                                <img
                                    src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'U') . '&background=random' }}"
                                    alt="Avatar do Usuário"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg transition-all duration-300 group-hover:brightness-75"
                                >

                                <!-- Botões aparecem ao passar o mouse -->
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="flex space-x-3">
                                        <!-- Botão de editar -->
                                        <label for="avatar-upload" class="cursor-pointer bg-white/90 p-2 rounded-full shadow-md hover:bg-white transition">
                                            <i data-lucide="camera" class="w-5 h-5 text-gray-700"></i>
                                        </label>
                                        <!-- Botão de remover -->
                                        <button type="button" id="remove-avatar" class="bg-white/90 p-2 rounded-full shadow-md hover:bg-white transition">
                                            <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Input oculto para upload -->
                                <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="hidden">
                            </div>

                            <p class="text-sm text-gray-500 mt-3 text-center">
                                Clique na foto para alterar ou remover seu avatar
                            </p>
                        </div>

                        <!-- Campos de texto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="nome" class="block text-sm font-medium text-gray-700">
                                    Nome <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nome" name="nome" value="{{ auth()->user()->name ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="Seu nome" required>
                            </div>

                            <div class="space-y-2">
                                <label for="sobrenome" class="block text-sm font-medium text-gray-700">
                                    Sobrenome
                                </label>
                                <input type="text" id="sobrenome" name="sobrenome"
                                       value="{{ auth()->user()->last_name ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="Seu sobrenome">
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    E-mail <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="seu@email.com" required>
                            </div>

                            <div class="space-y-2">
                                <label for="telefone" class="block text-sm font-medium text-gray-700">
                                    Telefone
                                </label>
                                <input type="tel" id="telefone" name="telefone"
                                       value="{{ auth()->user()->telefone ?? '' }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                       placeholder="(11) 99999-9999">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" id="btnSave"
                                    class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                <span>Salvar Alterações</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Configurações Financeiras -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                        <span>Configurações Financeiras</span>
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('configuracoes.atualizar-financeiro') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="salario_mensal" class="block text-sm font-medium text-gray-700">
                                    Salário Mensal
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">R$</span>
                                    <input type="number" id="salario_mensal" name="salario_mensal"
                                           value="{{ old('salario_mensal', $configFinanceiro->salario ?? '') }}"
                                           step="0.01"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                           placeholder="0,00">
                                </div>
                                <p class="text-sm text-gray-500">
                                    Configure seu salário para acompanhar seus gastos em relação à sua renda.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <label for="limite_alertas" class="block text-sm font-medium text-gray-700">
                                    Limite para Alertas (% do salário)
                                </label>
                                <div class="relative">
                                    <input type="number" id="limite_alertas" name="limite_alertas"
                                           value="{{ old('limite_alertas', $configFinanceiro->limite ?? '') }}" min="1"
                                           max="100"
                                           class="w-full pr-12 pl-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                    <span
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">%</span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Receba alertas quando seus gastos atingirem esta porcentagem do seu salário.
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                <span>Salvar Configurações</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Alteração de Senha -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                        <span>
                @if($isOAuthUser)
                                Criar Senha
                            @else
                                Alterar Senha
                            @endif
            </span>
                    </h3>
                </div>
                <div class="p-6">

                    @if($isOAuthUser)
                        <!-- Banner Informativo para OAuth -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <i data-lucide="shield" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-blue-800 font-medium">Crie uma senha para sua conta</p>
                                    <p class="text-blue-600 text-sm mt-1">
                                        Como você entrou com {{ $usuario->provider ?? 'rede social' }},
                                        crie uma senha para acessar com email também.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="form-alterar-senha" action="{{ route('configuracoes.alterar-senha') }}" method="POST">
                        @csrf

                        @if(!$isOAuthUser)
                            <!-- Campo Senha Atual (APENAS para usuários com senha existente) -->
                            <div class="space-y-2 mb-4">
                                <label for="senha_atual" class="block text-sm font-medium text-gray-700">
                                    Senha Atual <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="senha_atual" name="senha_atual"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 pr-12"
                                           placeholder="Sua senha atual" required>
                                    <button type="button" onclick="togglePassword('senha_atual', this)"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Nova Senha -->
                        <div class="space-y-2">
                            <label for="nova_senha" class="block text-sm font-medium text-gray-700">
                                @if($isOAuthUser)
                                    Criar Senha <span class="text-red-500">*</span>
                                @else
                                    Nova Senha <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <div class="relative">
                                <input type="password" id="nova_senha" name="nova_senha"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 pr-12"
                                       placeholder="Escolha uma senha segura" required>
                                <button type="button" onclick="togglePassword('nova_senha', this)"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>

                            <!-- Indicador de Força da Senha -->
                            <div class="mt-2">
                                <div class="flex items-center space-x-2 text-xs">
                                    <div class="flex-1 bg-gray-200 rounded-full h-1">
                                        <div id="passwordStrength"
                                             class="h-1 rounded-full transition-all duration-300 bg-gray-300"></div>
                                    </div>
                                    <span id="passwordStrengthText" class="text-gray-500">Digite uma senha</span>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="space-y-2 mt-4">
                            <label for="confirmar_senha" class="block text-sm font-medium text-gray-700">
                                @if($isOAuthUser)
                                    Confirmar Senha <span class="text-red-500">*</span>
                                @else
                                    Confirmar Nova Senha <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <div class="relative">
                                <input type="password" id="confirmar_senha" name="nova_senha_confirmation"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 pr-12"
                                       placeholder="Digite a senha novamente" required>
                                <button type="button" onclick="togglePassword('confirmar_senha', this)"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMessage" class="hidden"></div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" id="btn-password" disabled
                                    class="inline-flex items-center space-x-2 px-6 py-3 bg-gray-400 text-white font-medium rounded-xl cursor-not-allowed transition-all duration-200">
                                <i data-lucide="key" class="w-5 h-5"></i>
                                <span>
                                    @if($isOAuthUser)
                                        Criar Senha
                                    @else
                                        Alterar Senha
                                    @endif
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="space-y-8">
            <!-- Resumo Financeiro -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                        <span>Resumo Financeiro</span>
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @php
                        $salario = $configFinanceiro->salario ?? 0;
                        $totalMes = $totalMes ?? 0; // Você precisará passar esta variável do controller
                        $percentual = $salario > 0 ? ($totalMes / $salario) * 100 : 0;
                    @endphp

                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Salário Configurado:</span>
                            <span class="font-medium text-gray-900">
                                R$ {{ number_format($configFinanceiro->salario, 2, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Gastos do Mês:</span>
                            <span class="font-medium text-gray-900">
                                R$ {{ number_format($totalMes, 2, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Percentual Usado:</span>
                            <span
                                class="font-medium {{ $percentual > 80 ? 'text-red-600' : ($percentual > 60 ? 'text-yellow-600' : 'text-green-600') }}">
                                {{ number_format($percentual, 1) }}%
                            </span>
                        </div>
                    </div>

                    <!-- Barra de Progresso -->
                    <div class="pt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div
                                class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500"
                                style="width: {{ min($percentual, 100) }}%"></div>
                        </div>
                    </div>

                    @if($salario > 0)
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-600">
                                @if($percentual > 100)
                                    <span
                                        class="text-red-600 font-medium">⚠️ Você está gastando mais do que ganha!</span>
                                @elseif($percentual > 80)
                                    <span
                                        class="text-yellow-600 font-medium">⚠️ Cuidado! Gastos próximos ao limite.</span>
                                @else
                                    <span class="text-green-600 font-medium">✅ Suas finanças estão sob controle.</span>
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="text-center pt-2">
                            <p class="text-sm text-gray-500">
                                Configure seu salário para acompanhar seus gastos.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Preferências do Sistema -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Preferências</span>
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Notificações por E-mail</p>
                            <p class="text-xs text-gray-500">Alertas de gastos e relatórios</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Relatório Semanal</p>
                            <p class="text-xs text-gray-500">Receba resumo toda segunda-feira</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="button"
                                class="w-full inline-flex items-center justify-center space-x-2 px-4 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all duration-200">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            <span>Exportar Meus Dados</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar ícones do Lucide
        lucide.createIcons();
    </script>
@endsection
