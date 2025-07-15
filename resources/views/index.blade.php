@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral das suas despesas')

@section('content')
    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total de Despesas -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Despesas</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-red-400 to-pink-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="trending-down" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Quantidade de Despesas -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Quantidade</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($despesas) }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>

        <!-- Média por Despesa -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Média por Despesa</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        R$ {{ count($despesas) > 0 ? number_format($total / count($despesas), 2, ',', '.') : '0,00' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="calculator" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    @if(session('sucesso'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center space-x-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    <!-- Seção Principal -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header da Tabela -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                    <i data-lucide="list" class="w-5 h-5"></i>
                    <span>Suas Despesas</span>
                </h3>

                <a href="{{ route('despesas.create') }}"
                   class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Nova Despesa</span>
                </a>
            </div>
        </div>

        @if(count($despesas) === 0)
            <!-- Estado Vazio -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-12 h-12 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma despesa cadastrada</h3>
                <p class="text-gray-500 mb-6">Comece adicionando sua primeira despesa para acompanhar seus gastos.</p>
                <a href="{{ route('despesas.create') }}"
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>Adicionar Primeira Despesa</span>
                </a>
            </div>
        @else
            <!-- Tabela de Despesas -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descrição
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Valor
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($despesas as $despesa)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                        <i data-lucide="receipt" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $despesa->descricao ?? 'Sem descrição' }}
                                        </p>
                                        <p class="text-xs text-gray-500">ID: #{{ $despesa->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                    <span class="text-sm text-gray-900">{{ $despesa->data->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                    </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('despesas.edit', $despesa->id) }}"
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors">
                                        <i data-lucide="edit-2" class="w-4 h-4 mr-1"></i>
                                        Editar
                                    </a>

                                    <form action="{{ route('despesas.destroy', $despesa->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Script para inicializar ícones -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endsection
