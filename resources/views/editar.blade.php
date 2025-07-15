@extends('layouts.app')

@section('page-title', 'Editar Despesa')
@section('page-subtitle', 'Atualize os dados da sua despesa')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Card Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header do Card -->
            <div class="px-8 py-6 bg-gradient-to-r from-blue-500 to-purple-500">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i data-lucide="edit-2" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Editar Despesa</h2>
                        <p class="text-blue-100">Atualize os dados da despesa #{{ $output->id }}</p>
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
                <form action="{{ route('despesas.update', $output->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Campo Descrição -->
                    <div class="space-y-2">
                        <label for="descricao" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Descrição</span>
                        </label>
                        <div class="relative">
                            <textarea name="descricao" id="descricao" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Descreva sua despesa (opcional)...">{{ old('descricao', $output->descricao) }}</textarea>
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
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   value="{{ old('data', $output->data->format('Y-m-d')) }}">
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
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="0,00"
                                   value="{{ old('valor', $output->valor) }}">
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

                        <!-- Botão Salvar -->
                        <button type="submit"
                                class="inline-flex items-center space-x-2 px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Atualizar Despesa</span>
                        </button>

                    </div>
                </form> <!-- <- aqui fecha o form de edição -->

                <!-- Botão Excluir fora do form de edição -->
                <div class="mt-4 flex justify-end">
                    <form action="{{ route('despesas.destroy', $output->id) }}" method="POST" class="inline-block"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center space-x-2 px-6 py-3 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition-all duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span>Excluir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card de Informações -->
        <div class="mt-8 bg-amber-50 border border-amber-200 rounded-2xl p-6">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i data-lucide="info" class="w-4 h-4 text-amber-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-amber-900 mb-2">Informações da Despesa:</h3>
                    <div class="text-sm text-amber-800 space-y-1">
                        <p><strong>ID:</strong> #{{ $output->id }}</p>
                        <p><strong>Criada
                                em: </strong>{{ $output->created_at ? $output->created_at->format('d/m/Y H:i') : 'Não disponível' }}
                        </p>
                        @if($output->updated_at != $output->created_at)
                            <p><strong>Última
                                    atualização:</strong> {{ $output->updated_at ? $output->updated_at->format('d/m/Y H:i') : 'Não disponível'}}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para inicializar ícones e melhorias UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();

            // Auto-focus no primeiro campo
            const descricaoField = document.getElementById('descricao');
            if (descricaoField) {
                descricaoField.focus();
                // Posicionar cursor no final do texto
                descricaoField.setSelectionRange(descricaoField.value.length, descricaoField.value.length);
            }

            // Formatação automática do valor
            const valorField = document.getElementById('valor');
            if (valorField) {
                valorField.addEventListener('input', function (e) {
                    let value = e.target.value;
                    // Remove caracteres não numéricos exceto ponto e vírgula
                    value = value.replace(/[^\d.,]/g, '');
                    e.target.value = value;
                });
            }
        });
    </script>
@endsection
