import './bootstrap';

// app.js - Controle Completo da Aplicação
class ExpenseManager {
    constructor() {
        this.despesaAtualId = null;
        this.exclusaoDespesaId = null;
        this.init();
    }

    init() {
        this.inicializarIcones();
        this.inicializarSidebar();
        this.inicializarFiltros();
        this.inicializarAnimacoes();
        this.inicializarEventListenersGlobais();
    }

    // ==================== INICIALIZAÇÃO ====================
    inicializarIcones() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

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
            this.inicializarIcones();
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

    // ==================== MODAL EXCLUSÃO ====================
    abrirModalExclusao(id, descricao) {
        this.exclusaoDespesaId = id;

        // Atualizar dados do modal
        const descricaoElement = document.getElementById('exclusao-descricao');
        const form = document.getElementById('form-exclusao-despesa');

        if (descricaoElement) descricaoElement.textContent = descricao;
        if (form) form.action = `/despesas/${id}`;

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

        this.inicializarIcones();
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
    lucide.createIcons();
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
    lucide.createIcons();
}

/**
 * Valida o formulário completo
 */
function validatePasswordForm() {
    const novaSenha = document.getElementById('nova_senha');
    const confirmarSenha = document.getElementById('confirmar_senha');
    const submitBtn = document.querySelector('button[type="submit"]');

    if (!novaSenha || !confirmarSenha || !submitBtn) return;

    const isPasswordValid = novaSenha.value.length >= 8;
    const isPasswordMatch = novaSenha.value === confirmarSenha.value && confirmarSenha.value.length > 0;

    // Habilitar/desabilitar botão
    if (isPasswordValid && isPasswordMatch) {
        submitBtn.disabled = false;
        submitBtn.className = submitBtn.className.replace(/bg-gray-400|cursor-not-allowed/g, '') +
            ' bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 shadow-lg hover:shadow-xl cursor-pointer';
    } else {
        submitBtn.disabled = true;
        submitBtn.className = submitBtn.className.replace(/bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 shadow-lg hover:shadow-xl cursor-pointer/g, '') +
            ' bg-gray-400 cursor-not-allowed';
    }
}

/**
 * Inicializa a validação de senha para um formulário
 */
function initializePasswordValidation() {
    const novaSenha = document.getElementById('nova_senha');
    const confirmarSenha = document.getElementById('confirmar_senha');

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

    // Validar inicialmente
    validatePasswordForm();
}

// Inicializar quando o DOM carregar
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    initializePasswordValidation();
});


// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
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
window.toggleFiltros = (event) => window.expenseManager?.toggleFiltros(event);
window.limparFiltros = (event) => window.expenseManager?.limparFiltros(event);
