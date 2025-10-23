<!-- Modal Confirmar Exclusão -->
<div id="modal-confirmar-exclusao" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 opacity-0"
             id="modal-exclusao-overlay"
             onclick="fecharModalExclusao()"></div>

        <!-- Conteúdo do Modal -->
        <div class="inline-block w-full max-w-md my-8 overflow-hidden text-left align-middle transform transition-all duration-300 bg-white shadow-xl rounded-2xl opacity-0 scale-95 -translate-y-4"
             id="modal-exclusao-content">
            <!-- Header do Modal -->
            <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-pink-500 sm:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Confirmar Exclusão</h2>
                        </div>
                    </div>
                    <button onclick="fecharModalExclusao()" class="text-white hover:text-red-200 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Conteúdo do Modal -->
            <div class="px-6 py-6 sm:px-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="trash-2" class="w-6 h-6 text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tem certeza que deseja excluir esta despesa?</h3>
                        <p class="text-gray-600 mb-4">
                            A despesa <span id="exclusao-descricao" class="font-medium text-gray-900"></span>
                            será permanentemente removida do sistema.
                        </p>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="fecharModalExclusao()"
                            class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        <span>Cancelar</span>
                    </button>

                    <form id="form-exclusao-despesa" method="POST" class="inline-block m-0 w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            <span>Sim, Excluir Despesa</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
