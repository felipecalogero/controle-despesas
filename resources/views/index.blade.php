@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral das suas despesas')

<style>

    /* Seção de Filtros */
    .filters-section {
        background: white;
        border-radius: 1rem;
        padding: 0; /* Remove o padding principal */
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    #filtros-container {
        padding: 0 1.5rem 0 1.5rem;
    }

    .filters-header {
        padding: 1.5rem 1.5rem 0 1.5rem; /* Move o padding para o header */
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .filters-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }

    .filter-group input,
    .filter-group select {
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        outline: none;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-filter {
        padding: 0.75rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }
</style>

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
    <section id="filtros-despesas" class="mt-4">
        <form name="filtrosDespesas" method="POST" action="{{ route('despesas.filtrar') }}">
            @csrf
            <div class="filters-section" onclick="toggleFiltros()">
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
                    <div class="filters-grid" style="pointer-events: none;">

                        <div class="filter-group">
                            <label for="filter-nome">Nome da Despesa</label>
                            <input type="text" id="filter-nome" name="descricao" placeholder="Buscar por nome..."
                                   value="{{ $filtros['descricao'] ?? '' }}" style="pointer-events: auto;" onclick="event.stopPropagation()">
                        </div>

                        <div class="filter-group">
                            <label for="filter-mes">Mês</label>
                            <select id="filter-mes" name="mes" style="pointer-events: auto;" onclick="event.stopPropagation()">
                                <option value="">Todos os meses</option>
                                <option value="01" {{ ($filtros['mes'] ?? '') == '01' ? 'selected' : '' }}>Janeiro</option>
                                <option value="02" {{ ($filtros['mes'] ?? '') == '02' ? 'selected' : '' }}>Fevereiro</option>
                                <option value="03" {{ ($filtros['mes'] ?? '') == '03' ? 'selected' : '' }}>Março</option>
                                <option value="04" {{ ($filtros['mes'] ?? '') == '04' ? 'selected' : '' }}>Abril</option>
                                <option value="05" {{ ($filtros['mes'] ?? '') == '05' ? 'selected' : '' }}>Maio</option>
                                <option value="06" {{ ($filtros['mes'] ?? '') == '06' ? 'selected' : '' }}>Junho</option>
                                <option value="07" {{ ($filtros['mes'] ?? '') == '07' ? 'selected' : '' }}>Julho</option>
                                <option value="08" {{ ($filtros['mes'] ?? '') == '08' ? 'selected' : '' }}>Agosto</option>
                                <option value="09" {{ ($filtros['mes'] ?? '') == '09' ? 'selected' : '' }}>Setembro</option>
                                <option value="10" {{ ($filtros['mes'] ?? '') == '10' ? 'selected' : '' }}>Outubro</option>
                                <option value="11" {{ ($filtros['mes'] ?? '') == '11' ? 'selected' : '' }}>Novembro</option>
                                <option value="12" {{ ($filtros['mes'] ?? '') == '12' ? 'selected' : '' }}>Dezembro</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filter-data-inicio">Data Início</label>
                            <input type="date" id="filter-data-inicio" name="data_inicial"
                                   value="{{ $filtros['data_inicial'] ?? '' }}" style="pointer-events: auto;" onclick="event.stopPropagation()">
                        </div>

                        <div class="filter-group">
                            <label for="filter-data-fim">Data Fim</label>
                            <input type="date" id="filter-data-fim" name="data_final"
                                   value="{{ $filtros['data_final'] ?? '' }}" style="pointer-events: auto;" onclick="event.stopPropagation()">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="button" class="btn-filter btn-secondary"
                                onclick="limparFiltros(event)"
                                style="pointer-events: auto;">
                            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                            Limpar
                        </button>

                        <button class="btn-filter btn-primary" type="submit"
                                onclick="event.stopPropagation()"
                                style="pointer-events: auto;">
                            <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <style>
        /* Transição suave */
        #filtros-container {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.4s ease;
        }

        #filtros-container.aberto {
            max-height: 500px; /* Ajuste se tiver mais campos */
            opacity: 1;
        }

        /* Animação da seta */
        .rotacionar {
            transform: rotate(180deg);
        }
    </style>

    @if(session('sucesso'))
        <div
            class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center space-x-3">
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
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
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
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
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

                                    <form action="{{ route('despesas.destroy', $despesa->id) }}" method="POST"
                                          class="inline-block m-0"
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors">
                                            <i data-lucide="trash-2" class="w-4 mr-1"></i>
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
        function hasActiveFilters() {
            const descricao = document.getElementById('filter-nome').value;
            const mes = document.getElementById('filter-mes').value;
            const dataInicio = document.getElementById('filter-data-inicio').value;
            const dataFim = document.getElementById('filter-data-fim').value;

            return descricao !== '' || mes !== '' || dataInicio !== '' || dataFim !== '';
        }

        function toggleFiltros() {
            const container = document.getElementById('filtros-container');
            const seta = document.getElementById('seta-filtros');
            const isAberto = container.classList.toggle('aberto');

            if (isAberto) {
                seta.classList.add('rotacionar');
            } else {
                seta.classList.remove('rotacionar');
            }

            lucide.createIcons();
        }

        // Ao carregar a página, verifica se deve abrir os filtros
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('filtros-container');
            const seta = document.getElementById('seta-filtros');

            if (hasActiveFilters()) {
                container.classList.add('aberto');
                seta.classList.add('rotacionar');
            } else {
                container.classList.remove('aberto');
                seta.classList.remove('rotacionar');
            }

            lucide.createIcons();
        });

        function limparFiltros(event) {
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }

            window.location.href = "{{ route('despesas.index') }}";
        }
    </script>
@endsection
