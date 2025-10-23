<!-- Modal Nova Despesa -->
<div id="modal-nova-despesa" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 opacity-0"
             id="modal-overlay"
             onclick="fecharModal()"></div>

        <!-- Conteúdo do Modal -->
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transform transition-all duration-300 bg-white shadow-xl rounded-2xl opacity-0 scale-95 -translate-y-4"
             id="modal-content">
            <!-- Header do Modal -->
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 sm:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="plus-circle" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">Cadastrar Nova Despesa</h2>
                            <p class="text-purple-100 text-sm">Preencha os dados abaixo para registrar sua despesa</p>
                        </div>
                    </div>
                    <button onclick="fecharModal()" class="text-white hover:text-purple-200 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Conteúdo do Formulário -->
            <div class="px-6 py-6 sm:px-8 max-h-[70vh] overflow-y-auto">
                <form id="form-nova-despesa" action="{{ route('despesas.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Campo Descrição -->
                    <div class="space-y-2">
                        <label for="modal-descricao" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Descrição</span>
                        </label>
                        <div class="relative">
                            <textarea name="descricao" id="modal-descricao" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Descreva sua despesa (opcional)...">{{ old('descricao') }}</textarea>
                            <div class="absolute bottom-3 right-3">
                                <i data-lucide="edit-3" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Data -->
                    <div class="space-y-2">
                        <label for="modal-data" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>Data do Gasto</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" name="data" id="modal-data" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   value="{{ old('data') }}">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="calendar-days" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Valor -->
                    <div class="space-y-2">
                        <label for="modal-valor" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                            <span>Valor (R$)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <span class="text-gray-500 font-medium">R$</span>
                            </div>
                            <input type="number" name="valor" id="modal-valor" required step="0.01" min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   placeholder="0,00"
                                   value="{{ old('valor') }}">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="banknote" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Mensagens de Erro/Sucesso -->
                    <div id="modal-messages" class="hidden"></div>

                    <!-- Botões de Ação -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-6 border-t border-gray-200 space-y-4 sm:space-y-0">
                        <button type="button" onclick="fecharModal()"
                                class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 order-2 sm:order-1">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span>Cancelar</span>
                        </button>

                        <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl order-1 sm:order-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span>Salvar Despesa</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
