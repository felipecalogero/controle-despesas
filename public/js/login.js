// Elementos DOM
const loginTab = document.getElementById('loginTab');
const registerTab = document.getElementById('registerTab');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const registerPassword = document.getElementById('registerPassword');
const confirmPassword = document.getElementById('confirmPassword');
const passwordStrength = document.getElementById('passwordStrength');
const passwordStrengthText = document.getElementById('passwordStrengthText');

// Estado atual
let currentTab = 'login';

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    initializePasswordValidation();
    initializeFormValidation();
    addAnimations();
});

// Inicializar sistema de tabs
function initializeTabs() {
    loginTab.addEventListener('click', () => switchTab('login'));
    registerTab.addEventListener('click', () => switchTab('register'));
}

// Alternar entre login e cadastro
function switchTab(tab) {
    if (currentTab === tab) return;
    
    currentTab = tab;
    
    if (tab === 'login') {
        // Ativar tab de login
        loginTab.className = 'flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white';
        registerTab.className = 'flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200';
        
        // Mostrar formulário de login
        registerForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
        
        // Animação
        setTimeout(() => {
            loginForm.classList.add('fade-in');
        }, 50);
        
    } else {
        // Ativar tab de cadastro
        registerTab.className = 'flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-pink-500 text-white';
        loginTab.className = 'flex-1 py-4 px-6 text-center font-medium transition-all duration-200 bg-gray-100 text-gray-600 hover:bg-gray-200';
        
        // Mostrar formulário de cadastro
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        
        // Animação
        setTimeout(() => {
            registerForm.classList.add('fade-in');
        }, 50);
    }
    
    // Recriar ícones após mudança de DOM
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
}

// Toggle de visibilidade da senha
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
    
    // Recriar ícone
    lucide.createIcons();
}

// Inicializar validação de senha
function initializePasswordValidation() {
    if (registerPassword) {
        registerPassword.addEventListener('input', validatePasswordStrength);
        registerPassword.addEventListener('input', validatePasswordMatch);
    }
    
    if (confirmPassword) {
        confirmPassword.addEventListener('input', validatePasswordMatch);
    }
}

// Validar força da senha
function validatePasswordStrength() {
    const password = registerPassword.value;
    let strength = 0;
    let strengthText = 'Muito Fraca';
    let strengthColor = 'bg-red-500';
    let strengthWidth = '20%';
    
    // Critérios de força
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Definir força baseada na pontuação
    switch (strength) {
        case 0:
        case 1:
            strengthText = 'Muito Fraca';
            strengthColor = 'bg-red-500';
            strengthWidth = '20%';
            break;
        case 2:
            strengthText = 'Fraca';
            strengthColor = 'bg-orange-500';
            strengthWidth = '40%';
            break;
        case 3:
            strengthText = 'Média';
            strengthColor = 'bg-yellow-500';
            strengthWidth = '60%';
            break;
        case 4:
            strengthText = 'Forte';
            strengthColor = 'bg-blue-500';
            strengthWidth = '80%';
            break;
        case 5:
            strengthText = 'Muito Forte';
            strengthColor = 'bg-green-500';
            strengthWidth = '100%';
            break;
    }
    
    // Aplicar estilos
    passwordStrength.className = `h-1 rounded-full transition-all duration-300 ${strengthColor}`;
    passwordStrength.style.width = strengthWidth;
    passwordStrengthText.textContent = strengthText;
    passwordStrengthText.className = `text-xs ${strengthColor.replace('bg-', 'text-')}`;
}

// Validar se as senhas coincidem
function validatePasswordMatch() {
    if (!confirmPassword || !registerPassword) return;
    
    const password = registerPassword.value;
    const confirm = confirmPassword.value;
    
    if (confirm && password !== confirm) {
        confirmPassword.classList.add('border-red-500');
        confirmPassword.classList.remove('border-gray-300');
        
        // Adicionar mensagem de erro se não existir
        let errorMsg = confirmPassword.parentNode.querySelector('.error-message');
        if (!errorMsg) {
            errorMsg = document.createElement('div');
            errorMsg.className = 'error-message text-red-500 text-xs mt-1 flex items-center space-x-1';
            errorMsg.innerHTML = '<i data-lucide="alert-circle" class="w-3 h-3"></i><span>As senhas não coincidem</span>';
            confirmPassword.parentNode.appendChild(errorMsg);
            lucide.createIcons();
        }
    } else {
        confirmPassword.classList.remove('border-red-500');
        confirmPassword.classList.add('border-gray-300');
        
        // Remover mensagem de erro
        const errorMsg = confirmPassword.parentNode.querySelector('.error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    }
}

// Inicializar validação de formulários
function initializeFormValidation() {
    // Validação de email em tempo real
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', validateEmail);
    });
    
    // Máscara para telefone
    const phoneInput = document.querySelector('input[type="tel"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', formatPhone);
    }
    
    // Submissão dos formulários
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
}

// Validar email
function validateEmail(event) {
    const input = event.target;
    const email = input.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        input.classList.add('border-red-500');
        input.classList.remove('border-gray-300');
        
        // Adicionar mensagem de erro
        let errorMsg = input.parentNode.querySelector('.email-error');
        if (!errorMsg) {
            errorMsg = document.createElement('div');
            errorMsg.className = 'email-error text-red-500 text-xs mt-1 flex items-center space-x-1';
            errorMsg.innerHTML = '<i data-lucide="alert-circle" class="w-3 h-3"></i><span>Email inválido</span>';
            input.parentNode.appendChild(errorMsg);
            lucide.createIcons();
        }
    } else {
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
        
        const errorMsg = input.parentNode.querySelector('.email-error');
        if (errorMsg) {
            errorMsg.remove();
        }
    }
}

// Formatar telefone
function formatPhone(event) {
    let value = event.target.value.replace(/\D/g, '');
    
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        value = value.replace(/(\d{2})(\d{1,5})/, '($1) $2');
        value = value.replace(/(\d{2})/, '($1');
    }
    
    event.target.value = value;
}

// Manipular submissão do formulário
function handleFormSubmit(event) {
    const form = event.target;
    const isLoginForm = form.closest('#loginForm') !== null;
    
    // Animação de loading no botão
    const submitButton = form.querySelector('button[type="submit"]');
    const originalContent = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = `
        <div class="flex items-center justify-center space-x-2">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
            <span>${isLoginForm ? 'Entrando...' : 'Criando conta...'}</span>
        </div>
    `;
    
    // Simular processamento
    setTimeout(() => {
        // Mostrar mensagem de sucesso
        showSuccessMessage(isLoginForm ? 'Login realizado com sucesso!' : 'Conta criada com sucesso!');
        
        // Restaurar botão
        submitButton.disabled = false;
        submitButton.innerHTML = originalContent;
        
        // Recriar ícones
        lucide.createIcons();
    }, 2000);
}

// Mostrar mensagem de sucesso
function showSuccessMessage(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'fixed top-4 right-4 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-lg flex items-center space-x-3 z-50 fade-in';
    successDiv.innerHTML = `
        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(successDiv);
    lucide.createIcons();
    
    // Remover após 3 segundos
    setTimeout(() => {
        successDiv.style.opacity = '0';
        successDiv.style.transform = 'translateX(100%)';
        setTimeout(() => {
            successDiv.remove();
        }, 300);
    }, 3000);
}

// Adicionar animações e efeitos
function addAnimations() {
    // Efeito de parallax no fundo
    document.addEventListener('mousemove', (e) => {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        document.body.style.backgroundPosition = `${mouseX * 20}px ${mouseY * 20}px`;
    });
    
    // Animação de entrada dos elementos
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    });
    
    // Observar elementos para animação
    const elementsToAnimate = document.querySelectorAll('.hover-scale');
    elementsToAnimate.forEach(el => observer.observe(el));
    
    // Efeito de digitação no título
    const title = document.querySelector('h1');
    if (title) {
        const text = title.textContent;
        title.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                title.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        };
        
        setTimeout(typeWriter, 500);
    }
}

// Função utilitária para debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Adicionar efeitos de hover personalizados
document.addEventListener('DOMContentLoaded', function() {
    // Efeito de ripple nos botões
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', createRipple);
    });
});

// Criar efeito ripple
function createRipple(event) {
    const button = event.currentTarget;
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;
    
    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - (button.offsetLeft + radius)}px`;
    circle.style.top = `${event.clientY - (button.offsetTop + radius)}px`;
    circle.classList.add('ripple');
    
    const ripple = button.getElementsByClassName('ripple')[0];
    if (ripple) {
        ripple.remove();
    }
    
    button.appendChild(circle);
}

// Adicionar estilos CSS para o ripple
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    button {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(rippleStyle);
