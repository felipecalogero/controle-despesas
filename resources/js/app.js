import './bootstrap';

class ExpenseManager {
    constructor() {
        this.despesaAtualId = null;
        this.exclusaoDespesaId = null;
        this.despesasSelecionadas = [];
        this.selecionarTodos = false;
        this.init();
    }

    init() {
        this.inicializarSidebar();
        this.inicializarFiltros();
        this.inicializarAnimacoes();
        this.inicializarEventListenersGlobais();
        this.inicializarSelecaoMultipla();
    }

    // ==================== INICIALIZAÇÃO ====================

    inicializarSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        if (!sidebar || !overlay || !openBtn || !closeBtn) return;

        // Abrir sidebar
        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        // Fechar sidebar
        const closeSidebar = () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        };

        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Fechar sidebar ao clicar em links/botões (mobile)
        const sidebarLinks = document.querySelectorAll('#sidebar nav a, #sidebar nav button');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });

        // Fechar sidebar ao redimensionar para desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    }

    inicializarFiltros() {
        const container = document.getElementById('filtros-container');
        const seta = document.getElementById('seta-filtros');

        if (container && seta && this.hasActiveFilters()) {
            container.classList.add('aberto');
            seta.classList.add('rotacionar');
        }
    }

    inicializarAnimacoes() {
        const cards = document.querySelectorAll('.hover-scale');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'scale(1.02)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'scale(1)';
            });
        });
    }

    inicializarEventListenersGlobais() {
        // Fechar modais com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.fecharModalComEsc();
            }
        });
    }

    fecharModalComEsc() {
        if (!document.getElementById('modal-nova-despesa').classList.contains('hidden')) {
            this.fecharModalNovaDespesa();
        } else if (!document.getElementById('modal-editar-despesa').classList.contains('hidden')) {
            this.fecharModalEditar();
        } else if (!document.getElementById('modal-confirmar-exclusao').classList.contains('hidden')) {
            this.fecharModalExclusao();
        }
    }

    // ==================== FILTROS ====================
    hasActiveFilters() {
        const descricao = document.getElementById('filter-nome')?.value || '';
        const mes = document.getElementById('filter-mes')?.value || '';
        const dataInicio = document.getElementById('filter-data-inicio')?.value || '';
        const dataFim = document.getElementById('filter-data-fim')?.value || '';

        return descricao !== '' || mes !== '' || dataInicio !== '' || dataFim !== '';
    }

    toggleFiltros(event) {
        if (event.target.closest('input') || event.target.closest('select') ||
            event.target.closest('button') || event.target.closest('label')) {
            return;
        }

        const container = document.getElementById('filtros-container');
        const seta = document.getElementById('seta-filtros');

        if (container && seta) {
            const isAberto = container.classList.toggle('aberto');
            seta.classList.toggle('rotacionar', isAberto);
            // ❌ REMOVIDO: this.inicializarIcones();
        }
    }

    limparFiltros(event) {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }
        window.location.href = '/despesas';
    }

    // ==================== MODAL NOVA DESPESA ====================
    abrirModalNovaDespesa() {
        this.abrirModalGenerico(
            'modal-nova-despesa',
            'modal-overlay',
            'modal-content',
            () => {
                const descricaoField = document.getElementById('modal-descricao');
                if (descricaoField) descricaoField.focus();

                const dataField = document.getElementById('modal-data');
                if (dataField && !dataField.value) {
                    const today = new Date().toISOString().split('T')[0];
                    dataField.value = today;
                }
            }
        );
    }

    fecharModalNovaDespesa() {
        this.fecharModalGenerico(
            'modal-nova-despesa',
            'modal-overlay',
            'modal-content',
            () => {
                const messages = document.getElementById('modal-messages');
                if (messages) {
                    messages.classList.add('hidden');
                    messages.innerHTML = '';
                }
                document.getElementById('form-nova-despesa')?.reset();
            }
        );
    }

    // ==================== MODAL EDITAR DESPESA ====================
    abrirModalEditar(id, descricao, data, valor) {
        this.despesaAtualId = id;

        // Atualizar dados do modal
        const subtitle = document.getElementById('modal-editar-subtitle');
        const descricaoField = document.getElementById('modal-editar-descricao');
        const dataField = document.getElementById('modal-editar-data');
        const valorField = document.getElementById('modal-editar-valor');
        const form = document.getElementById('form-editar-despesa');

        if (subtitle) subtitle.textContent = `Atualize os dados da despesa #${id}`;
        if (descricaoField) descricaoField.value = descricao || '';
        if (dataField) dataField.value = data;
        if (valorField) valorField.value = valor;
        if (form) form.action = `/despesas/${id}`;

        this.abrirModalGenerico(
            'modal-editar-despesa',
            'modal-editar-overlay',
            'modal-editar-content',
            () => {
                if (descricaoField) {
                    descricaoField.focus();
                    descricaoField.setSelectionRange(descricaoField.value.length, descricaoField.value.length);
                }

                // Formatação automática do valor
                if (valorField) {
                    valorField.addEventListener('input', (e) => {
                        let value = e.target.value;
                        value = value.replace(/[^\d.,]/g, '');
                        e.target.value = value;
                    });
                }
            }
        );
    }

    fecharModalEditar() {
        this.fecharModalGenerico(
            'modal-editar-despesa',
            'modal-editar-overlay',
            'modal-editar-content',
            () => {
                this.despesaAtualId = null;
                document.getElementById('form-editar-despesa')?.reset();
            }
        );
    }

    // ==================== EXCLUSÃO DO MODAL DE EDIÇÃO ====================
    abrirModalExclusaoDoModalEditar() {
        if (!this.despesaAtualId) {
            console.error('Nenhuma despesa selecionada para exclusão');
            return;
        }

        // Pega a descrição do campo do formulário
        const descricaoField = document.getElementById('modal-editar-descricao');
        const descricao = descricaoField ? descricaoField.value : 'Despesa sem descrição';

        // Fecha o modal de edição e abre o de exclusão
        this.fecharModalEditar();
        this.abrirModalExclusao(this.despesaAtualId, descricao);
    }

    // ==================== SELEÇÃO MÚLTIPLA ====================

    inicializarSelecaoMultipla() {
        this.atualizarBotoesExclusao();

        // Verificar se os elementos existem
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.checkbox-despesa');
        const btnExcluir = document.getElementById('btn-excluir-selecionados');
    }

    limparSelecoes() {
        this.despesasSelecionadas = [];
        this.selecionarTodos = false;

        const checkboxes = document.querySelectorAll('.checkbox-despesa');
        const selectAll = document.getElementById('select-all');

        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        if (selectAll) {
            selectAll.checked = false;
        }

        this.atualizarBotoesExclusao();
    }

    // Alternar seleção de uma despesa
    toggleSelecionarDespesa(id, element) {
        const index = this.despesasSelecionadas.indexOf(id);

        if (index > -1) {
            this.despesasSelecionadas.splice(index, 1);
            element.checked = false;
        } else {
            this.despesasSelecionadas.push(id);
            element.checked = true;
        }

        this.atualizarBotoesExclusao();
        this.atualizarSelecionarTodos();
    }

    // Selecionar/Deselecionar todas as despesas
    toggleSelecionarTodas() {
        this.selecionarTodos = !this.selecionarTodos;

        const checkboxes = document.querySelectorAll('.checkbox-despesa');
        const ids = [];

        checkboxes.forEach(checkbox => {
            checkbox.checked = this.selecionarTodos;
            if (this.selecionarTodos) {
                ids.push(parseInt(checkbox.value));
            }
        });

        this.despesasSelecionadas = this.selecionarTodos ? ids : [];
        this.atualizarBotoesExclusao();
        this.atualizarSelecionarTodos();
    }

    // Atualizar o estado do checkbox "Selecionar Todos"
    atualizarSelecionarTodos() {
        const selectAllCheckbox = document.getElementById('select-all');
        const totalCheckboxes = document.querySelectorAll('.checkbox-despesa').length;

        if (selectAllCheckbox) {
            if (this.despesasSelecionadas.length === totalCheckboxes && totalCheckboxes > 0) {
                selectAllCheckbox.checked = true;
                this.selecionarTodos = true;
            } else {
                selectAllCheckbox.checked = false;
                this.selecionarTodos = false;
            }
        }
    }

    // Atualizar a visibilidade dos botões de exclusão
    atualizarBotoesExclusao() {
        const btnExcluirSelecionados = document.getElementById('btn-excluir-selecionados');
        const textoExcluir = document.getElementById('texto-excluir-selecionadas');
        const btnExcluirUnico = document.querySelectorAll('.btn-excluir-unico');
        const btnNovaDespesa = document.getElementById('btn-nova-despesa');

        if (btnExcluirSelecionados && textoExcluir) {
            if (this.despesasSelecionadas.length > 0) {
                btnExcluirSelecionados.classList.remove('hidden');
                textoExcluir.textContent = `Excluir Selecionadas (${this.despesasSelecionadas.length})`;
            } else {
                btnExcluirSelecionados.classList.add('hidden');
            }
        }

        // Mostrar/ocultar botões de exclusão individual E botão Nova Despesa
        if (btnExcluirUnico && btnExcluirUnico.length > 0) {
            btnExcluirUnico.forEach(btn => {
                if (this.despesasSelecionadas.length > 0) {
                    btn.classList.add('hidden');
                } else {
                    btn.classList.remove('hidden');
                }
            });
        }

        // Controlar visibilidade do botão Nova Despesa
        if (btnNovaDespesa) {
            if (this.despesasSelecionadas.length > 0) {
                btnNovaDespesa.classList.add('hidden');
            } else {
                btnNovaDespesa.classList.remove('hidden');
            }
        }
    }

    // Abrir modal de exclusão múltipla
    abrirModalExclusaoMultipla() {
        if (this.despesasSelecionadas.length === 0) return;

        const modal = document.getElementById('modal-confirmar-exclusao');
        const overlay = document.getElementById('modal-exclusao-overlay');
        const content = document.getElementById('modal-exclusao-content');
        const form = document.getElementById('form-exclusao-despesa');
        const mensagem = document.getElementById('exclusao-mensagem');
        const titulo = document.getElementById('exclusao-titulo');
        const botaoTexto = document.getElementById('exclusao-botao-texto');

        if (!modal || !overlay || !content || !form || !mensagem || !titulo || !botaoTexto) return;

        // Configurar o formulário para exclusão múltipla
        form.action = "/despesas/excluir-multiplas";

        // Criar input hidden para cada ID selecionado
        form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove());

        this.despesasSelecionadas.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        // Atualizar mensagem do modal baseado na quantidade
        if (this.despesasSelecionadas.length === 1) {
            titulo.textContent = 'Tem certeza que deseja excluir esta despesa?';
            // Para uma única despesa, você pode buscar o nome se necessário
            mensagem.innerHTML = `<span class="font-medium text-gray-900">1 despesa</span> será permanentemente removida do sistema.`;
            botaoTexto.textContent = 'Excluir Despesa';
        } else {
            titulo.textContent = 'Tem certeza que deseja excluir estas despesas?';
            mensagem.innerHTML = `<span class="font-medium text-gray-900">${this.despesasSelecionadas.length} despesas</span> serão permanentemente removidas do sistema.`;
            botaoTexto.textContent = 'Excluir Despesas';
        }

        // Mostrar modal usando a função genérica existente
        this.abrirModalGenerico(
            'modal-confirmar-exclusao',
            'modal-exclusao-overlay',
            'modal-exclusao-content'
        );
    }

    // Limpar seleções quando o modal de exclusão fechar
    fecharModalExclusao() {
        this.fecharModalGenerico(
            'modal-confirmar-exclusao',
            'modal-exclusao-overlay',
            'modal-exclusao-content',
            () => {
                this.exclusaoDespesaId = null;
                // Não limpar as seleções automaticamente - só após exclusão bem-sucedida
            }
        );
    }

    // ==================== MODAL EXCLUSÃO ====================
    abrirModalExclusao(id, descricao) {
        // Limpar seleções múltiplas quando for exclusão individual
        this.despesasSelecionadas = [];
        this.atualizarBotoesExclusao();
        this.atualizarSelecionarTodos();

        this.exclusaoDespesaId = id;

        // Atualizar dados do modal
        const descricaoElement = document.getElementById('exclusao-descricao');
        const form = document.getElementById('form-exclusao-despesa');
        const mensagem = document.getElementById('exclusao-mensagem');
        const titulo = document.getElementById('exclusao-titulo');
        const botaoTexto = document.getElementById('exclusao-botao-texto');

        if (descricaoElement) descricaoElement.textContent = descricao;
        if (form) form.action = `/despesas/${id}`;

        // Configurar para exclusão individual
        if (titulo) titulo.textContent = 'Tem certeza que deseja excluir esta despesa?';
        if (mensagem) {
            mensagem.innerHTML = `A despesa <span class="font-medium text-gray-900">"${descricao}"</span> será permanentemente removida do sistema.`;
        }
        if (botaoTexto) botaoTexto.textContent = 'Sim, Excluir Despesa';

        // Limpar quaisquer inputs de múltiplas IDs
        if (form) {
            form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove());
        }

        this.abrirModalGenerico(
            'modal-confirmar-exclusao',
            'modal-exclusao-overlay',
            'modal-exclusao-content'
        );
    }

    fecharModalExclusao() {
        this.fecharModalGenerico(
            'modal-confirmar-exclusao',
            'modal-exclusao-overlay',
            'modal-exclusao-content',
            () => {
                this.exclusaoDespesaId = null;
            }
        );
    }

    confirmarExclusao() {
        if (this.despesaAtualId && confirm('Tem certeza que deseja excluir esta despesa?')) {
            this.submeterExclusao(this.despesaAtualId);
        }
    }

    submeterExclusao(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/despesas/${id}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="${this.getCsrfToken()}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }

    // ==================== FUNÇÕES GENÉRICAS DE MODAL ====================
    abrirModalGenerico(modalId, overlayId, contentId, callback = null) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById(overlayId);
        const content = document.getElementById(contentId);

        if (!modal || !overlay || !content) return;

        modal.classList.remove('hidden');

        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            content.classList.remove('opacity-0', 'scale-95', '-translate-y-4');
            content.classList.add('opacity-100', 'scale-100', 'translate-y-0');
        }, 10);

        document.body.classList.add('overflow-hidden');

        if (callback) {
            setTimeout(callback, 100);
        }

        // ❌ REMOVIDO: this.inicializarIcones();
    }

    fecharModalGenerico(modalId, overlayId, contentId, callback = null) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById(overlayId);
        const content = document.getElementById(contentId);

        if (!modal || !overlay || !content) return;

        overlay.classList.add('opacity-0');
        content.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        content.classList.add('opacity-0', 'scale-95', '-translate-y-4');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            overlay.classList.remove('opacity-0');

            if (callback) callback();
        }, 300);
    }

    // ==================== EVENT HANDLERS ====================
    handleKeydown(e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('modal-nova-despesa').classList.contains('hidden')) {
                this.fecharModalNovaDespesa();
            } else if (!document.getElementById('modal-editar-despesa').classList.contains('hidden')) {
                this.fecharModalEditar();
            } else if (!document.getElementById('modal-confirmar-exclusao').classList.contains('hidden')) {
                this.fecharModalExclusao();
            }
        }
    }

    handleOverlayClick(e) {
        if (e.target.id === 'modal-overlay') {
            this.fecharModalNovaDespesa();
        } else if (e.target.id === 'modal-editar-overlay') {
            this.fecharModalEditar();
        } else if (e.target.id === 'modal-exclusao-overlay') {
            this.fecharModalExclusao();
        }
    }

    // ==================== UTILITÁRIOS ====================
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }
}

// ==================== VALIDACAO DE SENHA ====================

/**
 * Toggle para mostrar/esconder senha
 */
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye-off');
    } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye');
    }
    // ❌ REMOVIDO: createIcons();
}

/**
 * Verifica a força da senha
 */
function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';

    // Verificar comprimento
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Determinar força e feedback
    if (password.length === 0) {
        feedback = 'Digite uma senha';
    } else if (password.length < 8) {
        feedback = 'Muito curta';
    } else if (strength <= 2) {
        feedback = 'Fraca';
    } else if (strength <= 3) {
        feedback = 'Média';
    } else {
        feedback = 'Forte';
    }

    return { strength, feedback };
}

/**
 * Atualiza a barra de força da senha
 */
function updatePasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');

    if (!strengthBar || !strengthText) return;

    let strength = 0;
    let feedback = 'Digite uma senha';
    let width = '0%';
    let color = 'bg-gray-300';
    let textColor = 'text-gray-500';

    // Critérios de força
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Definir força baseada na pontuação
    if (password.length === 0) {
        feedback = 'Digite uma senha';
        width = '0%';
        color = 'bg-gray-300';
        textColor = 'text-gray-500';
    } else if (password.length < 8) {
        feedback = 'Muito curta';
        width = '20%';
        color = 'bg-red-500';
        textColor = 'text-red-500';
    } else if (strength <= 2) {
        feedback = 'Fraca';
        width = '40%';
        color = 'bg-orange-500';
        textColor = 'text-orange-500';
    } else if (strength <= 3) {
        feedback = 'Média';
        width = '60%';
        color = 'bg-yellow-500';
        textColor = 'text-yellow-500';
    } else if (strength <= 4) {
        feedback = 'Forte';
        width = '80%';
        color = 'bg-blue-500';
        textColor = 'text-blue-500';
    } else {
        feedback = 'Muito Forte';
        width = '100%';
        color = 'bg-green-500';
        textColor = 'text-green-500';
    }

    // Aplicar estilos
    strengthBar.className = `h-1 rounded-full transition-all duration-300 ${color}`;
    strengthBar.style.width = width;
    strengthText.textContent = feedback;
    strengthText.className = `text-xs ${textColor}`;
}

/**
 * Verifica se as senhas coincidem
 */
function checkPasswordMatch() {
    const novaSenha = document.getElementById('nova_senha');
    const confirmarSenha = document.getElementById('confirmar_senha');
    const matchMessage = document.getElementById('passwordMatchMessage');

    if (!novaSenha || !confirmarSenha || !matchMessage) return;

    if (confirmarSenha.value.length === 0) {
        matchMessage.className = 'hidden';
        confirmarSenha.classList.remove('border-red-500', 'border-green-500');
    } else if (novaSenha.value === confirmarSenha.value) {
        matchMessage.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4 text-green-500 mr-1"></i> Senhas coincidem';
        matchMessage.className = 'text-sm text-green-600 mt-1 flex items-center space-x-1';
        confirmarSenha.classList.remove('border-red-500');
        confirmarSenha.classList.add('border-green-500');
    } else {
        matchMessage.innerHTML = '<i data-lucide="x-circle" class="w-4 h-4 text-red-500 mr-1"></i> Senhas não coincidem';
        matchMessage.className = 'text-sm text-red-600 mt-1 flex items-center space-x-1';
        confirmarSenha.classList.remove('border-green-500');
        confirmarSenha.classList.add('border-red-500');
    }
}

/**
 * Valida o formulário completo
 */
function validatePasswordForm() {
    // Seleciona o formulário de alteração de senha especificamente
    const passwordForm = document.getElementById('form-alterar-senha');
    if (!passwordForm) return;

    const novaSenha = passwordForm.querySelector('#nova_senha');
    const confirmarSenha = passwordForm.querySelector('#confirmar_senha');
    const submitBtn = passwordForm.querySelector('#btn-password');

    if (!novaSenha || !confirmarSenha || !submitBtn) {
        console.log('❌ Elementos não encontrados no formulário de senha:', {
            novaSenha: !!novaSenha,
            confirmarSenha: !!confirmarSenha,
            submitBtn: !!submitBtn
        });
        return;
    }

    const isPasswordValid = novaSenha.value.length >= 8;
    const isPasswordMatch = novaSenha.value === confirmarSenha.value && confirmarSenha.value.length > 0;

    // Habilitar/desabilitar botão
    if (isPasswordValid && isPasswordMatch) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        submitBtn.classList.add(
            'bg-gradient-to-r', 'from-purple-500', 'to-pink-500',
            'hover:from-purple-600', 'hover:to-pink-600',
            'shadow-lg', 'hover:shadow-xl', 'cursor-pointer'
        );
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove(
            'bg-gradient-to-r', 'from-purple-500', 'to-pink-500',
            'hover:from-purple-600', 'hover:to-pink-600',
            'shadow-lg', 'hover:shadow-xl', 'cursor-pointer'
        );
        submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
    }
}

function initializePasswordValidation() {
    const passwordForm = document.querySelector('form[action*="alterar-senha"]');
    if (!passwordForm) return;

    const novaSenha = passwordForm.querySelector('#nova_senha');
    const confirmarSenha = passwordForm.querySelector('#confirmar_senha');

    if (novaSenha) {
        novaSenha.addEventListener('input', function() {
            updatePasswordStrength(this.value);
            checkPasswordMatch();
            validatePasswordForm();
        });
    }

    if (confirmarSenha) {
        confirmarSenha.addEventListener('input', function() {
            checkPasswordMatch();
            validatePasswordForm();
        });
    }

    validatePasswordForm();
}


// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    initializePasswordValidation();
    window.expenseManager = new ExpenseManager();
});

// Funções globais para acesso via HTML
window.abrirModalNovaDespesa = () => window.expenseManager?.abrirModalNovaDespesa();
window.fecharModal = () => window.expenseManager?.fecharModalNovaDespesa();
window.abrirModalEditar = (id, descricao, data, valor) => window.expenseManager?.abrirModalEditar(id, descricao, data, valor);
window.fecharModalEditar = () => window.expenseManager?.fecharModalEditar();
window.abrirModalExclusaoDoModalEditar = () => window.expenseManager?.abrirModalExclusaoDoModalEditar();
window.abrirModalExclusao = (id, descricao) => window.expenseManager?.abrirModalExclusao(id, descricao);
window.fecharModalExclusao = () => window.expenseManager?.fecharModalExclusao();
window.confirmarExclusao = () => window.expenseManager?.confirmarExclusao();

// FUNÇÕES PARA SELEÇÃO MÚLTIPLA
window.toggleSelecionarDespesa = (id, element) => window.expenseManager?.toggleSelecionarDespesa(id, element);
window.toggleSelecionarTodas = () => window.expenseManager?.toggleSelecionarTodas();
window.abrirModalExclusaoMultipla = () => window.expenseManager?.abrirModalExclusaoMultipla();
window.limparSelecoes = () => window.expenseManager?.limparSelecoes(); // ← ADICIONE ESTA LINHA

// Funções existentes de filtros e senha
window.toggleFiltros = (event) => window.expenseManager?.toggleFiltros(event);
window.limparFiltros = (event) => window.expenseManager?.limparFiltros(event);
window.togglePassword = togglePassword;
window.checkPasswordMatch = checkPasswordMatch;
window.updatePasswordStrength = updatePasswordStrength;
window.validatePasswordForm = validatePasswordForm;
window.initializePasswordValidation = initializePasswordValidation;
