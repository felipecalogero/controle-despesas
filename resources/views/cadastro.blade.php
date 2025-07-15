@extends('layouts.app')

@section('page-title', 'Nova Despesa')
@section('page-subtitle', 'Adicione uma nova despesa ao seu controle financeiro')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Card Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header do Card -->
            <div class="px-8 py-6 bg-gradient-to-r from-purple-500 to-pink-500">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i data-lucide="plus-circle" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Cadastrar Nova Despesa</h2>
                        <p class="text-purple-100">Preencha os dados abaixo para registrar sua despesa</p>
                    </div>
                </div>
            </div>

            <!-- Conteúdo do Card -->
            <div class="p-8">
                @if(session('sucesso'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center space-x-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        <span>{{ session('sucesso') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl mb-6">
                        <div class="flex items-start space-x-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mt-0.5"></i>
                            <div>
                                <h4 class="font-medium mb-2">Corrija os seguintes erros:</h4>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $erro)
                                        <li class="text-sm">{{ $erro }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('despesas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Campo Descrição -->
                    <div class="space-y-2">
                        <label for="descricao" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Descrição</span>
                        </label>
                        <div class="relative">
                            <textarea name="descricao" id="descricao" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Descreva sua despesa (opcional)...">{{ old('descricao') }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <i data-lucide="edit-3" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Data -->
                    <div class="space-y-2">
                        <label for="data" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>Data do Gasto</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" name="data" id="data" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   value="{{ old('data') }}">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="calendar-days" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Valor -->
                    <div class="space-y-2">
                        <label for="valor" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                            <span>Valor (R$)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <span class="text-gray-500 font-medium">R$</span>
                            </div>
                            <input type="number" name="valor" id="valor" required step="0.01" min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   placeholder="0,00"
                                   value="{{ old('valor') }}">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="banknote" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('despesas.index') }}"
                           class="inline-flex items-center space-x-2 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Voltar</span>
                        </a>

                        <button type="submit"
                                class="inline-flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Salvar Despesa</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card de Dicas -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i data-lucide="lightbulb" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-blue-900 mb-2">Dicas para um melhor controle:</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Seja específico na descrição para facilitar a análise posterior</li>
                        <li>• Registre as despesas no mesmo dia para não esquecer</li>
                        <li>• Use valores exatos para um controle mais preciso</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para inicializar ícones e melhorias UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Auto-focus no primeiro campo
            const descricaoField = document.getElementById('descricao');
            if (descricaoField) {
                descricaoField.focus();
            }

            // Formatação automática do valor
            const valorField = document.getElementById('valor');
            if (valorField) {
                valorField.addEventListener('input', function(e) {
                    let value = e.target.value;
                    // Remove caracteres não numéricos exceto ponto e vírgula
                    value = value.replace(/[^\d.,]/g, '');
                    e.target.value = value;
                });
            }

            // Data padrão como hoje
            const dataField = document.getElementById('data');
            if (dataField && !dataField.value) {
                const today = new Date().toISOString().split('T')[0];
                dataField.value = today;
            }
        });
    </script>
@endsection
