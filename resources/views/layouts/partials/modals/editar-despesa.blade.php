<!-- Modal Editar Despesa -->
<div id="modal-editar-despesa" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 opacity-0"
             id="modal-editar-overlay"
             onclick="fecharModalEditar()"></div>

        <!-- Conteúdo do Modal -->
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transform transition-all duration-300 bg-white shadow-xl rounded-2xl opacity-0 scale-95 -translate-y-4"
             id="modal-editar-content">
            <!-- Header do Modal -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-500 sm:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="edit-2" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">Editar Despesa</h2>
                            <p class="text-blue-100 text-sm" id="modal-editar-subtitle">Atualize os dados da despesa</p>
                        </div>
                    </div>
                    <button onclick="fecharModalEditar()" class="text-white hover:text-blue-200 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Conteúdo do Formulário -->
            <div class="px-6 py-6 sm:px-8 max-h-[70vh] overflow-y-auto">
                <form id="form-editar-despesa" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Campo Descrição -->
                    <div class="space-y-2">
                        <label for="modal-editar-descricao" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Descrição</span>
                        </label>
                        <div class="relative">
                            <textarea name="descricao" id="modal-editar-descricao" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Descreva sua despesa (opcional)..."></textarea>
                            <div class="absolute bottom-3 right-3">
                                <i data-lucide="edit-3" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Data -->
                    <div class="space-y-2">
                        <label for="modal-editar-data" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span>Data do Gasto</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" name="data" id="modal-editar-data" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="calendar-days" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Valor -->
                    <div class="space-y-2">
                        <label for="modal-editar-valor" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                            <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                            <span>Valor (R$)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                <span class="text-gray-500 font-medium">R$</span>
                            </div>
                            <input type="number" name="valor" id="modal-editar-valor" required step="0.01" min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="0,00">
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i data-lucide="banknote" class="w-4 h-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex flex-col sm:flex-row items-center justify-between pt-6 border-t border-gray-200 space-y-4 sm:space-y-0">
                        <button type="button" onclick="fecharModalEditar()"
                                class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 order-2 sm:order-1">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            <span>Cancelar</span>
                        </button>

                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 order-1 sm:order-2 w-full sm:w-auto">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                <span>Atualizar</span>
                            </button>

                            <!-- Botão Excluir -->
                            <button type="button" onclick="abrirModalExclusaoDoModalEditar()"
                                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition-all duration-200">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                <span>Excluir</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
