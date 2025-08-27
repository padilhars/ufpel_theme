// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Módulo AMD para toggle de modo escuro do tema UFPel
 *
 * @module     theme_ufpel/darkmode
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import Ajax from 'core/ajax';
import Notification from 'core/notification';
import {get_string as getString} from 'core/str';
import Prefetch from 'core/prefetch';

// Pré-carrega strings necessárias
Prefetch.prefetchStrings('theme_ufpel', ['toggledarkmode']);

/**
 * Classe para gerenciar o modo escuro
 */
class DarkModeToggle {
    /**
     * Construtor
     */
    constructor() {
        this.storageKey = 'theme_ufpel_darkmode';
        this.bodyClass = 'theme-dark-mode';
        this.toggleBtn = null;
        this.isDarkMode = false;
        
        // Carrega estado salvo
        this.loadSavedState();
    }
    
    /**
     * Inicializa o toggle de modo escuro
     * 
     * @param {String} selector Seletor do botão de toggle
     */
    init(selector = '.darkmode-toggle') {
        // Procura o botão de toggle
        this.toggleBtn = document.querySelector(selector);
        
        if (!this.toggleBtn) {
            // Cria botão se não existir
            this.createToggleButton();
        }
        
        // Adiciona evento de clique
        if (this.toggleBtn) {
            this.toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggle();
            });
        }
        
        // Aplica estado inicial
        this.applyState();
        
        // Adiciona atalho de teclado (Alt + D)
        this.addKeyboardShortcut();
        
        // Observa mudanças no localStorage (sync entre abas)
        this.syncBetweenTabs();
    }
    
    /**
     * Cria botão de toggle dinamicamente
     */
    createToggleButton() {
        // Procura navbar ou header
        const navbar = document.querySelector('.navbar .navbar-nav');
        
        if (navbar) {
            const li = document.createElement('li');
            li.className = 'nav-item';
            
            const button = document.createElement('button');
            button.className = 'nav-link btn darkmode-toggle';
            button.setAttribute('aria-label', 'Toggle dark mode');
            button.setAttribute('title', 'Toggle dark mode');
            button.innerHTML = `
                <i class="fa fa-moon" aria-hidden="true"></i>
                <span class="sr-only">Toggle dark mode</span>
            `;
            
            li.appendChild(button);
            navbar.appendChild(li);
            
            this.toggleBtn = button;
        }
    }
    
    /**
     * Carrega estado salvo do localStorage ou preferência do usuário
     */
    loadSavedState() {
        // Primeiro verifica localStorage
        const saved = localStorage.getItem(this.storageKey);
        
        if (saved !== null) {
            this.isDarkMode = saved === 'true';
        } else {
            // Verifica preferência do sistema
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                this.isDarkMode = true;
            }
        }
    }
    
    /**
     * Salva estado no localStorage e no servidor
     */
    async saveState() {
        // Salva localmente
        localStorage.setItem(this.storageKey, this.isDarkMode.toString());
        
        // Salva no servidor via AJAX (preferência do usuário)
        try {
            await Ajax.call([{
                methodname: 'core_user_update_user_preferences',
                args: {
                    preferences: [{
                        name: 'theme_ufpel_darkmode',
                        value: this.isDarkMode ? '1' : '0'
                    }]
                }
            }]);
        } catch (error) {
            // Falha silenciosa - localStorage ainda funciona
            console.warn('Failed to save dark mode preference to server:', error);
        }
    }
    
    /**
     * Aplica o estado atual ao DOM
     */
    applyState() {
        const body = document.body;
        const icon = this.toggleBtn?.querySelector('i');
        
        if (this.isDarkMode) {
            body.classList.add(this.bodyClass);
            
            // Atualiza ícone
            if (icon) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
            
            // Atualiza meta theme-color
            this.updateThemeColor('#1a1a1a');
        } else {
            body.classList.remove(this.bodyClass);
            
            // Atualiza ícone
            if (icon) {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
            
            // Atualiza meta theme-color
            this.updateThemeColor('#0080FF');
        }
        
        // Dispara evento customizado
        window.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { darkMode: this.isDarkMode }
        }));
    }
    
    /**
     * Alterna entre modo claro e escuro
     */
    toggle() {
        this.isDarkMode = !this.isDarkMode;
        
        // Adiciona classe de transição
        document.body.classList.add('theme-transitioning');
        
        // Aplica novo estado
        this.applyState();
        
        // Salva preferência
        this.saveState();
        
        // Remove classe de transição após animação
        setTimeout(() => {
            document.body.classList.remove('theme-transitioning');
        }, 300);
        
        // Feedback visual
        this.showNotification();
    }
    
    /**
     * Exibe notificação do modo ativo
     */
    async showNotification() {
        const message = this.isDarkMode ? 
            'Modo escuro ativado' : 
            'Modo claro ativado';
        
        // Cria notificação temporária
        const notification = document.createElement('div');
        notification.className = 'darkmode-notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${this.isDarkMode ? '#333' : '#fff'};
            color: ${this.isDarkMode ? '#fff' : '#333'};
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            animation: slideInUp 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Remove após 2 segundos
        setTimeout(() => {
            notification.style.animation = 'slideOutDown 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
    
    /**
     * Atualiza meta theme-color para navegadores móveis
     * 
     * @param {String} color Cor hexadecimal
     */
    updateThemeColor(color) {
        let meta = document.querySelector('meta[name="theme-color"]');
        
        if (!meta) {
            meta = document.createElement('meta');
            meta.name = 'theme-color';
            document.head.appendChild(meta);
        }
        
        meta.content = color;
    }
    
    /**
     * Adiciona atalho de teclado para toggle
     */
    addKeyboardShortcut() {
        document.addEventListener('keydown', (e) => {
            // Alt + D
            if (e.altKey && e.key === 'd') {
                e.preventDefault();
                this.toggle();
            }
        });
    }
    
    /**
     * Sincroniza modo escuro entre abas
     */
    syncBetweenTabs() {
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey) {
                this.isDarkMode = e.newValue === 'true';
                this.applyState();
            }
        });
    }
    
    /**
     * Detecta mudanças na preferência do sistema
     */
    watchSystemPreference() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Listener para mudanças
            mediaQuery.addEventListener('change', (e) => {
                // Só aplica se não houver preferência salva
                if (localStorage.getItem(this.storageKey) === null) {
                    this.isDarkMode = e.matches;
                    this.applyState();
                }
            });
        }
    }
}

// Estilos de animação
const styles = `
    @keyframes slideInUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
    
    .theme-transitioning * {
        transition: background-color 0.3s ease, 
                    color 0.3s ease, 
                    border-color 0.3s ease !important;
    }
`;

// Adiciona estilos ao documento
const styleSheet = document.createElement('style');
styleSheet.textContent = styles;
document.head.appendChild(styleSheet);

/**
 * Função de inicialização exportada
 * 
 * @param {String} selector Seletor opcional do botão
 */
export const init = (selector) => {
    // Aguarda DOM carregar
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            const darkMode = new DarkModeToggle();
            darkMode.init(selector);
        });
    } else {
        const darkMode = new DarkModeToggle();
        darkMode.init(selector);
    }
};

// Auto-inicializa se configurado
$(document).ready(() => {
    // Verifica se o toggle está habilitado nas configurações
    const darkModeEnabled = document.body.dataset.darkmodetoggle === 'true' ||
                           $('body').hasClass('darkmode-enabled');
    
    if (darkModeEnabled) {
        init();
    }
});
