@extends('layouts.app')
@include('layouts.partials.modals.editar-despesa')

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
                <div
                    class="w-12 h-12 bg-gradient-to-r from-red-400 to-pink-500 rounded-xl flex items-center justify-center">
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
                <div
                    class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-500 rounded-xl flex items-center justify-center">
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
                <div
                    class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="calculator" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Filtros -->
    <section id="filtros-despesas" class="mt-4 mb-5">
        <form name="filtrosDespesas" method="POST" action="{{ route('despesas.filtrar') }}">
            @csrf
            <div class="filters-section" onclick="toggleFiltros(event)">
                <!-- Cabeçalho -->
                <div class="filters-header" style="position: relative; z-index: 1;">
                    <h3>
                        <i data-lucide="filter" style="width: 20px; height: 20px;"></i>
                        Filtros
                    </h3>
                    <i id="seta-filtros" data-lucide="chevron-down"
                       style="width: 22px; height: 22px; transition: transform 0.3s ease;"></i>
                </div>

                <!-- Container dos filtros -->
                <div id="filtros-container" class="filtros-fechados" style="position: relative; z-index: 1;">
                    <div class="filters-grid">

                        <div class="filter-group">
                            <label for="filter-nome">Nome da Despesa</label>
                            <input type="text" id="filter-nome" name="descricao" placeholder="Buscar por nome..."
                                   value="{{ $filtros['descricao'] ?? '' }}"
                                   onclick="event.stopPropagation()">
                        </div>

                        <div class="filter-group">
                            <label for="filter-mes">Mês</label>
                            <select id="filter-mes" name="mes"
                                    onclick="event.stopPropagation()">
                                <option value="">Todos os meses</option>
                                <option value="01" {{ ($filtros['mes'] ?? '') == '01' ? 'selected' : '' }}>Janeiro
                                </option>
                                <option value="02" {{ ($filtros['mes'] ?? '') == '02' ? 'selected' : '' }}>Fevereiro
                                </option>
                                <option value="03" {{ ($filtros['mes'] ?? '') == '03' ? 'selected' : '' }}>Março
                                </option>
                                <option value="04" {{ ($filtros['mes'] ?? '') == '04' ? 'selected' : '' }}>Abril
                                </option>
                                <option value="05" {{ ($filtros['mes'] ?? '') == '05' ? 'selected' : '' }}>Maio</option>
                                <option value="06" {{ ($filtros['mes'] ?? '') == '06' ? 'selected' : '' }}>Junho
                                </option>
                                <option value="07" {{ ($filtros['mes'] ?? '') == '07' ? 'selected' : '' }}>Julho
                                </option>
                                <option value="08" {{ ($filtros['mes'] ?? '') == '08' ? 'selected' : '' }}>Agosto
                                </option>
                                <option value="09" {{ ($filtros['mes'] ?? '') == '09' ? 'selected' : '' }}>Setembro
                                </option>
                                <option value="10" {{ ($filtros['mes'] ?? '') == '10' ? 'selected' : '' }}>Outubro
                                </option>
                                <option value="11" {{ ($filtros['mes'] ?? '') == '11' ? 'selected' : '' }}>Novembro
                                </option>
                                <option value="12" {{ ($filtros['mes'] ?? '') == '12' ? 'selected' : '' }}>Dezembro
                                </option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filter-data-inicio">Data Início</label>
                            <input type="date" id="filter-data-inicio" name="data_inicial"
                                   value="{{ $filtros['data_inicial'] ?? '' }}"
                                   onclick="event.stopPropagation()">
                        </div>

                        <div class="filter-group">
                            <label for="filter-data-fim">Data Fim</label>
                            <input type="date" id="filter-data-fim" name="data_final"
                                   value="{{ $filtros['data_final'] ?? '' }}"
                                   onclick="event.stopPropagation()">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn-filter btn-secondary"
                                onclick="limparFiltros(event)">
                            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                            Limpar
                        </button>

                        <button class="btn-filter btn-primary" type="submit"
                                onclick="event.stopPropagation()">
                            <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @if(session('sucesso'))
        <div
            class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center space-x-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    <!-- Seção Principal -->
    <div class="secaoHeader bg-white rounded-2xl shadow-lg overflow-hidden mb-4">
        <!-- Header da Tabela -->
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                    <i data-lucide="list" class="w-5 h-5"></i>
                    <span>Suas Despesas</span>
                </h3>

                <div class="flex items-center space-x-2">
                    <!-- Botão Excluir Selecionadas -->
                    <button id="btn-excluir-selecionados" onclick="abrirModalExclusaoMultipla()"
                            class="hidden inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white font-medium rounded-xl hover:from-red-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span id="texto-excluir-selecionadas">Excluir Selecionadas</span>
                    </button>

                    <button id="btn-nova-despesa" onclick="abrirModalNovaDespesa()"
                            class="inline-flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Nova Despesa</span>
                    </button>
                </div>
            </div>
        </div>

        @if(empty($despesas))
            <!-- Estado Vazio -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-12 h-12 text-gray-400"></i>
                </div>

                @if(!empty($filtros))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma despesa encontrada</h3>
                    <p class="text-gray-500 mb-6">Tente ajustar os filtros para ver mais resultados.</p>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma despesa cadastrada</h3>
                    <p class="text-gray-500 mb-6">Comece adicionando sua primeira despesa para acompanhar seus
                        gastos.</p>
                    <button onclick="abrirModalNovaDespesa()"
                            class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        <span>Adicionar Primeira Despesa</span>
                    </button>
                @endif
            </div>
        @else
            <!-- Tabela de Despesas -->
            <div class="overflow-x-auto">
                <!-- Tabela Desktop (acima de 768px) -->
                <table class="w-full hidden md:table">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" onchange="toggleSelecionarTodas()"
                                   class="rounded border-gray-300 text-purple-500 focus:ring-purple-500">
                        </th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descrição
                        </th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data
                        </th>
                        <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Valor
                        </th>
                        <th class="px-4 lg:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($despesas as $despesa)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 lg:px-6 py-4">
                                <input type="checkbox" value="{{ $despesa->id }}"
                                       onchange="toggleSelecionarDespesa({{ $despesa->id }}, this)"
                                       class="checkbox-despesa rounded border-gray-300 text-purple-500 focus:ring-purple-500">
                            </td>
                            <td class="px-4 lg:px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="receipt" class="w-4 h-4 lg:w-5 lg:h-5 text-white"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $despesa->descricao ?? 'Sem descrição' }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">ID: #{{ $despesa->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 lg:px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                                    <span
                                        class="text-sm text-gray-900 whitespace-nowrap">{{ $despesa->data->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="px-4 lg:px-6 py-4 text-right">
                <span
                    class="inline-flex items-center px-2 py-1 lg:px-3 lg:py-1 rounded-full text-xs lg:text-sm font-medium bg-red-100 text-red-800 whitespace-nowrap">
                    R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                </span>
                            </td>
                            <td class="px-4 lg:px-6 py-4">
                                <div class="flex items-center justify-center space-x-1 lg:space-x-2">
                                    <button onclick="abrirModalEditar({{ $despesa->id }}, '{{ $despesa->descricao }}', '{{ $despesa->data->format('Y-m-d') }}', {{ $despesa->valor }})"
                                            class="inline-flex items-center px-2 py-1 lg:px-3 lg:py-1 bg-blue-100 text-blue-700 text-xs lg:text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors whitespace-nowrap">
                                        <i data-lucide="edit-2" class="w-3 h-3 lg:w-4 lg:h-4 mr-1"></i>
                                        Editar
                                    </button>

                                    <button onclick="abrirModalExclusao({{ $despesa->id }}, '{{ $despesa->descricao ?? 'Despesa sem descrição' }}')"
                                            class="btn-excluir-unico inline-flex items-center px-2 py-1 lg:px-3 lg:py-1 bg-red-100 text-red-700 text-xs lg:text-sm font-medium rounded-lg hover:bg-red-200 transition-colors whitespace-nowrap">
                                        <i data-lucide="trash-2" class="w-3 h-3 lg:w-4 lg:h-4 mr-1"></i>
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Cards Mobile (abaixo de 768px) -->
                <div class="md:hidden space-y-4">
                    @foreach($despesas as $despesa)
                        <div class="divCards mt-5">
                            <div
                                class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                                <!-- Header do Card -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                                        <input type="checkbox" value="{{ $despesa->id }}"
                                               onchange="toggleSelecionarDespesa({{ $despesa->id }}, this)"
                                               class="checkbox-despesa mt-1 rounded border-gray-300 text-purple-500 focus:ring-purple-500">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="receipt" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $despesa->descricao ?? 'Sem descrição' }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1">ID: #{{ $despesa->id }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full font-medium bg-red-100 text-red-800 whitespace-nowrap ml-2">
                        R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                    </span>
                                </div>

                                <!-- Informações -->
                                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center space-x-1">
                                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                        <span>{{ $despesa->data->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <!-- Ações -->
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <button onclick="abrirModalEditar({{ $despesa->id }}, '{{ $despesa->descricao }}', '{{ $despesa->data->format('Y-m-d') }}', {{ $despesa->valor }})"
                                            class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-colors flex-1 justify-center mr-2">
                                        <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i>
                                        Editar
                                    </button>

                                    <button onclick="abrirModalExclusao({{ $despesa->id }}, '{{ $despesa->descricao ?? 'Despesa sem descrição' }}')"
                                            class="btn-excluir-unico inline-flex items-center px-3 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors flex-1 justify-center">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                                        Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    @include('layouts.partials.modals.editar-despesa')
@endsection
