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
 * Módulo AMD para funcionalidades de acessibilidade do tema UFPel
 *
 * @module     theme_ufpel/accessibility
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import Ajax from 'core/ajax';
import {get_string as getString} from 'core/str';

/**
 * Classe principal de acessibilidade
 */
class AccessibilityTools {
    /**
     * Construtor
     */
    constructor() {
        this.fontSizeKey = 'theme_ufpel_fontsize';
        this.contrastKey = 'theme_ufpel_highcontrast';
        this.vlibrasKey = 'theme_ufpel_vlibras';
        
        // Estados
        this.fontSize = 100; // Porcentagem
        this.highContrast = false;
        this.vlibrasEnabled = false;
        
        // Elementos
        this.toolbar = null;
        
        // Carrega configurações salvas
        this.loadSettings();
    }
    
    /**
     * Inicializa as ferramentas de acessibilidade
     */
    init() {
        // Cria toolbar de acessibilidade
        this.createToolbar();
        
        // Aplica configurações iniciais
        this.applySettings();
        
        // Inicializa VLibras se disponível
        this.initVLibras();
        
        // Adiciona atalhos de teclado
        this.addKeyboardShortcuts();
        
        // Adiciona link de pular para conteúdo
        this.addSkipLinks();
        
        // Melhora navegação por teclado
        this.enhanceKeyboardNavigation();
        
        // Adiciona indicadores de foco visíveis
        this.enhanceFocusIndicators();
    }
    
    /**
     * Cria toolbar de acessibilidade
     */
    createToolbar() {
        // Verifica se já existe
        if (document.querySelector('.accessibility-toolbar')) {
            return;
        }
        
        const toolbar = document.createElement('div');
        toolbar.className = 'accessibility-toolbar';
        toolbar.setAttribute('role', 'toolbar');
        toolbar.setAttribute('aria-label', 'Ferramentas de acessibilidade');
        
        toolbar.innerHTML = `
            <div class="accessibility-toolbar-content">
                <button class="a11y-toggle-btn" aria-label="Abrir ferramentas de acessibilidade">
                    <i class="fa fa-universal-access" aria-hidden="true"></i>
                </button>
                
                <div class="a11y-tools" style="display: none;">
                    <!-- Controle de fonte -->
                    <div class="a11y-tool-group">
                        <span class="a11y-label">Tamanho da fonte:</span>
                        <button class="a11y-btn" id="font-decrease" aria-label="Diminuir fonte">
                            A-
                        </button>
                        <button class="a11y-btn" id="font-reset" aria-label="Redefinir fonte">
                            A
                        </button>
                        <button class="a11y-btn" id="font-increase" aria-label="Aumentar fonte">
                            A+
                        </button>
                        <span class="a11y-value" id="font-size-value">100%</span>
                    </div>
                    
                    <!-- Alto contraste -->
                    <div class="a11y-tool-group">
                        <button class="a11y-btn a11y-toggle" id="toggle-contrast" 
                                aria-label="Alternar alto contraste" 
                                aria-pressed="false">
                            <i class="fa fa-adjust" aria-hidden="true"></i>
                            Alto Contraste
                        </button>
                    </div>
                    
                    <!-- VLibras -->
                    <div class="a11y-tool-group">
                        <button class="a11y-btn a11y-toggle" id="toggle-vlibras" 
                                aria-label="Ativar tradutor de Libras"
                                aria-pressed="false">
                            <i class="fa fa-sign-language" aria-hidden="true"></i>
                            Libras
                        </button>
                    </div>
                    
                    <!-- Links úteis -->
                    <div class="a11y-tool-group">
                        <a href="#main-content" class="a11y-btn a11y-link">
                            <i class="fa fa-arrow-down" aria-hidden="true"></i>
                            Ir para conteúdo
                        </a>
                    </div>
                    
                    <!-- Resetar tudo -->
                    <div class="a11y-tool-group">
                        <button class="a11y-btn" id="reset-all-a11y" 
                                aria-label="Redefinir todas as configurações">
                            <i class="fa fa-redo" aria-hidden="true"></i>
                            Redefinir
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Adiciona ao corpo
        document.body.appendChild(toolbar);
        this.toolbar = toolbar;
        
        // Adiciona estilos
        this.addToolbarStyles();
        
        // Adiciona eventos
        this.attachToolbarEvents();
    }
    
    /**
     * Adiciona estilos do toolbar
     */
    addToolbarStyles() {
        const styles = `
            .accessibility-toolbar {
                position: fixed;
                top: 100px;
                right: 0;
                z-index: 9998;
                background: #fff;
                border: 2px solid #0080FF;
                border-right: none;
                border-radius: 8px 0 0 8px;
                box-shadow: -2px 2px 10px rgba(0, 0, 0, 0.1);
                font-family: "DM Sans", sans-serif;
            }
            
            .accessibility-toolbar-content {
                padding: 8px;
            }
            
            .a11y-toggle-btn {
                background: #0080FF;
                color: white;
                border: none;
                border-radius: 4px;
                padding: 10px;
                cursor: pointer;
                font-size: 20px;
                transition: all 0.3s ease;
            }
            
            .a11y-toggle-btn:hover {
                background: #00408F;
            }
            
            .a11y-tools {
                margin-top: 10px;
                min-width: 200px;
            }
            
            .a11y-tool-group {
                margin-bottom: 12px;
                padding-bottom: 12px;
                border-bottom: 1px solid #e0e0e0;
            }
            
            .a11y-tool-group:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }
            
            .a11y-label {
                display: block;
                font-size: 12px;
                color: #666;
                margin-bottom: 5px;
                font-weight: 600;
            }
            
            .a11y-btn {
                background: #f0f0f0;
                border: 1px solid #ccc;
                border-radius: 4px;
                padding: 6px 10px;
                margin: 2px;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.2s ease;
            }
            
            .a11y-btn:hover {
                background: #e0e0e0;
                border-color: #0080FF;
            }
            
            .a11y-btn:focus {
                outline: 3px solid #F7A600;
                outline-offset: 2px;
            }
            
            .a11y-toggle {
                display: block;
                width: 100%;
                text-align: left;
            }
            
            .a11y-toggle[aria-pressed="true"] {
                background: #0080FF;
                color: white;
                border-color: #0080FF;
            }
            
            .a11y-link {
                display: block;
                width: 100%;
                text-decoration: none;
                color: #333;
                text-align: left;
            }
            
            .a11y-value {
                display: inline-block;
                margin-left: 8px;
                font-weight: bold;
                color: #0080FF;
            }
            
            /* Alto contraste */
            body.high-contrast {
                background: #000 !important;
                color: #fff !important;
            }
            
            body.high-contrast * {
                background-color: #000 !important;
                color: #fff !important;
                border-color: #fff !important;
            }
            
            body.high-contrast a {
                color: #ffff00 !important;
                text-decoration: underline !important;
            }
            
            body.high-contrast button,
            body.high-contrast .btn {
                background: #fff !important;
                color: #000 !important;
                border: 2px solid #fff !important;
            }
            
            body.high-contrast img {
                opacity: 0.8 !important;
                filter: contrast(1.5);
            }
            
            body.high-contrast .accessibility-toolbar {
                background: #000 !important;
                border-color: #fff !important;
            }
            
            body.high-contrast .a11y-btn {
                background: #fff !important;
                color: #000 !important;
            }
            
            /* Indicadores de foco melhorados */
            *:focus-visible {
                outline: 3px solid #F7A600 !important;
                outline-offset: 2px !important;
            }
            
            /* Skip links */
            .skip-links {
                position: absolute;
                top: -9999px;
                left: -9999px;
                z-index: 999999;
            }
            
            .skip-links:focus-within {
                position: fixed;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
            }
            
            .skip-link {
                display: inline-block;
                background: #0080FF;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 0 0 8px 8px;
                font-weight: bold;
            }
            
            /* Animações reduzidas */
            @media (prefers-reduced-motion: reduce) {
                * {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
            
            /* VLibras Widget customização */
            .vw-plugin-top-wrapper {
                top: 150px !important;
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);
    }
    
    /**
     * Anexa eventos ao toolbar
     */
    attachToolbarEvents() {
        const toggleBtn = this.toolbar.querySelector('.a11y-toggle-btn');
        const tools = this.toolbar.querySelector('.a11y-tools');
        
        // Toggle do toolbar
        toggleBtn.addEventListener('click', () => {
            const isVisible = tools.style.display !== 'none';
            tools.style.display = isVisible ? 'none' : 'block';
            toggleBtn.setAttribute('aria-expanded', !isVisible);
        });
        
        // Controles de fonte
        document.getElementById('font-decrease').addEventListener('click', () => {
            this.adjustFontSize(-10);
        });
        
        document.getElementById('font-reset').addEventListener('click', () => {
            this.resetFontSize();
        });
        
        document.getElementById('font-increase').addEventListener('click', () => {
            this.adjustFontSize(10);
        });
        
        // Alto contraste
        document.getElementById('toggle-contrast').addEventListener('click', (e) => {
            this.toggleHighContrast();
            e.target.setAttribute('aria-pressed', this.highContrast);
        });
        
        // VLibras
        document.getElementById('toggle-vlibras').addEventListener('click', (e) => {
            this.toggleVLibras();
            e.target.setAttribute('aria-pressed', this.vlibrasEnabled);
        });
        
        // Resetar tudo
        document.getElementById('reset-all-a11y').addEventListener('click', () => {
            this.resetAll();
        });
    }
    
    /**
     * Carrega configurações salvas
     */
    loadSettings() {
        // Tamanho da fonte
        const savedFontSize = localStorage.getItem(this.fontSizeKey);
        if (savedFontSize) {
            this.fontSize = parseInt(savedFontSize, 10);
        }
        
        // Alto contraste
        const savedContrast = localStorage.getItem(this.contrastKey);
        this.highContrast = savedContrast === 'true';
        
        // VLibras
        const savedVLibras = localStorage.getItem(this.vlibrasKey);
        this.vlibrasEnabled = savedVLibras === 'true';
    }
    
    /**
     * Aplica configurações salvas
     */
    applySettings() {
        // Aplica tamanho de fonte
        this.applyFontSize();
        
        // Aplica alto contraste
        if (this.highContrast) {
            document.body.classList.add('high-contrast');
        }
        
        // Atualiza estados visuais
        this.updateVisualStates();
    }
    
    /**
     * Ajusta tamanho da fonte
     * 
     * @param {Number} delta Mudança em porcentagem
     */
    adjustFontSize(delta) {
        this.fontSize = Math.max(80, Math.min(150, this.fontSize + delta));
        this.applyFontSize();
        this.saveFontSize();
        this.updateVisualStates();
    }
    
    /**
     * Reseta tamanho da fonte
     */
    resetFontSize() {
        this.fontSize = 100;
        this.applyFontSize();
        this.saveFontSize();
        this.updateVisualStates();
    }
    
    /**
     * Aplica tamanho de fonte ao documento
     */
    applyFontSize() {
        document.documentElement.style.fontSize = `${this.fontSize}%`;
    }
    
    /**
     * Salva tamanho de fonte
     */
    saveFontSize() {
        localStorage.setItem(this.fontSizeKey, this.fontSize.toString());
        
        // Salva no servidor
        this.savePreference('theme_ufpel_fontsize', this.fontSize.toString());
    }
    
    /**
     * Alterna alto contraste
     */
    toggleHighContrast() {
        this.highContrast = !this.highContrast;
        
        if (this.highContrast) {
            document.body.classList.add('high-contrast');
        } else {
            document.body.classList.remove('high-contrast');
        }
        
        localStorage.setItem(this.contrastKey, this.highContrast.toString());
        this.savePreference('theme_ufpel_highcontrast', this.highContrast ? '1' : '0');
        
        this.updateVisualStates();
    }
    
    /**
     * Inicializa VLibras
     */
    initVLibras() {
        if (this.vlibrasEnabled && !window.VLibras) {
            const script = document.createElement('script');
            script.src = 'https://vlibras.gov.br/app/vlibras-plugin.js';
            script.onload = () => {
                new window.VLibras.Widget('https://vlibras.gov.br/app');
            };
            document.head.appendChild(script);
        }
    }
    
    /**
     * Alterna VLibras
     */
    toggleVLibras() {
        this.vlibrasEnabled = !this.vlibrasEnabled;
        
        if (this.vlibrasEnabled) {
            if (!window.VLibras) {
                this.initVLibras();
            } else {
                // Mostra widget se já carregado
                const widget = document.querySelector('[vw]');
                if (widget) {
                    widget.style.display = 'block';
                }
            }
        } else {
            // Esconde widget
            const widget = document.querySelector('[vw]');
            if (widget) {
                widget.style.display = 'none';
            }
        }
        
        localStorage.setItem(this.vlibrasKey, this.vlibrasEnabled.toString());
        this.savePreference('theme_ufpel_vlibras', this.vlibrasEnabled ? '1' : '0');
    }
    
    /**
     * Reseta todas as configurações
     */
    resetAll() {
        this.fontSize = 100;
        this.highContrast = false;
        this.vlibrasEnabled = false;
        
        // Remove classes
        document.body.classList.remove('high-contrast');
        document.documentElement.style.fontSize = '';
        
        // Limpa localStorage
        localStorage.removeItem(this.fontSizeKey);
        localStorage.removeItem(this.contrastKey);
        localStorage.removeItem(this.vlibrasKey);
        
        // Atualiza UI
        this.updateVisualStates();
        
        // Esconde VLibras
        const widget = document.querySelector('[vw]');
        if (widget) {
            widget.style.display = 'none';
        }
    }
    
    /**
     * Atualiza estados visuais do toolbar
     */
    updateVisualStates() {
        // Atualiza display do tamanho de fonte
        const fontSizeValue = document.getElementById('font-size-value');
        if (fontSizeValue) {
            fontSizeValue.textContent = `${this.fontSize}%`;
        }
        
        // Atualiza botão de contraste
        const contrastBtn = document.getElementById('toggle-contrast');
        if (contrastBtn) {
            contrastBtn.setAttribute('aria-pressed', this.highContrast.toString());
        }
        
        // Atualiza botão VLibras
        const vlibrasBtn = document.getElementById('toggle-vlibras');
        if (vlibrasBtn) {
            vlibrasBtn.setAttribute('aria-pressed', this.vlibrasEnabled.toString());
        }
    }
    
    /**
     * Adiciona skip links
     */
    addSkipLinks() {
        const skipLinks = document.createElement('div');
        skipLinks.className = 'skip-links';
        skipLinks.innerHTML = `
            <a href="#main-content" class="skip-link">
                Pular para conteúdo principal
            </a>
            <a href="#nav-drawer" class="skip-link">
                Pular para navegação
            </a>
            <a href="#page-footer" class="skip-link">
                Pular para rodapé
            </a>
        `;
        
        document.body.insertBefore(skipLinks, document.body.firstChild);
    }
    
    /**
     * Adiciona atalhos de teclado
     */
    addKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Alt + A: Abre toolbar de acessibilidade
            if (e.altKey && e.key === 'a') {
                e.preventDefault();
                this.toolbar.querySelector('.a11y-toggle-btn').click();
            }
            
            // Alt + C: Toggle contraste
            if (e.altKey && e.key === 'c') {
                e.preventDefault();
                this.toggleHighContrast();
            }
            
            // Alt + Plus: Aumenta fonte
            if (e.altKey && e.key === '+') {
                e.preventDefault();
                this.adjustFontSize(10);
            }
            
            // Alt + Minus: Diminui fonte
            if (e.altKey && e.key === '-') {
                e.preventDefault();
                this.adjustFontSize(-10);
            }
            
            // Alt + 0: Reseta fonte
            if (e.altKey && e.key === '0') {
                e.preventDefault();
                this.resetFontSize();
            }
        });
    }
    
    /**
     * Melhora navegação por teclado
     */
    enhanceKeyboardNavigation() {
        // Adiciona tabindex aos elementos importantes
        const importantElements = document.querySelectorAll(
            'main, nav, section, article, aside, footer'
        );
        
        importantElements.forEach(el => {
            if (!el.hasAttribute('tabindex')) {
                el.setAttribute('tabindex', '-1');
            }
        });
        
        // Adiciona ID ao conteúdo principal se não existir
        const main = document.querySelector('main, [role="main"], #region-main');
        if (main && !main.id) {
            main.id = 'main-content';
        }
    }
    
    /**
     * Melhora indicadores de foco
     */
    enhanceFocusIndicators() {
        // Remove outline padrão apenas para cliques
        document.addEventListener('mousedown', () => {
            document.body.classList.add('using-mouse');
        });
        
        document.addEventListener('keydown', () => {
            document.body.classList.remove('using-mouse');
        });
        
        // Adiciona classe para ocultar outline quando usando mouse
        const style = document.createElement('style');
        style.textContent = `
            body.using-mouse *:focus {
                outline: none !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    /**
     * Salva preferência no servidor
     * 
     * @param {String} name Nome da preferência
     * @param {String} value Valor
     */
    async savePreference(name, value) {
        try {
            await Ajax.call([{
                methodname: 'core_user_update_user_preferences',
                args: {
                    preferences: [{
                        name: name,
                        value: value
                    }]
                }
            }]);
        } catch (error) {
            console.warn(`Failed to save ${name} preference:`, error);
        }
    }
}

/**
 * Inicializa as ferramentas de acessibilidade
 */
export const init = () => {
    const accessibility = new AccessibilityTools();
    accessibility.init();
    
    // Expõe globalmente para debugging
    window.UFPelAccessibility = accessibility;
};

// Auto-inicializa
$(document).ready(() => {
    init();
});
