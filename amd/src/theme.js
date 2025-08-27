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
 * Módulo JavaScript principal do tema UFPel
 *
 * @module     theme_ufpel/theme
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import $ from 'jquery';
import * as DarkMode from 'theme_ufpel/darkmode';
import * as Accessibility from 'theme_ufpel/accessibility';
import {get_string as getString} from 'core/str';
import Notification from 'core/notification';
import Log from 'core/log';

/**
 * Classe principal do tema UFPel
 */
class UFPelTheme {
    /**
     * Construtor
     * 
     * @param {Object} config Configurações do tema
     */
    constructor(config = {}) {
        this.config = {
            darkModeEnabled: true,
            highContrastEnabled: true,
            vLibrasEnabled: false,
            animations: true,
            ...config
        };
        
        this.initialized = false;
    }
    
    /**
     * Inicializa o tema
     */
    async init() {
        if (this.initialized) {
            return;
        }
        
        try {
            // Log de inicialização
            Log.debug('UFPel Theme: Iniciando...');
            
            // Inicializa componentes base
            this.initBaseComponents();
            
            // Inicializa modo escuro se habilitado
            if (this.config.darkModeEnabled) {
                await this.initDarkMode();
            }
            
            // Inicializa acessibilidade se habilitado
            if (this.config.highContrastEnabled || this.config.vLibrasEnabled) {
                await this.initAccessibility();
            }
            
            // Inicializa animações e efeitos
            if (this.config.animations) {
                this.initAnimations();
            }
            
            // Inicializa melhorias de UX
            this.initUXEnhancements();
            
            // Inicializa handlers de curso
            this.initCourseHandlers();
            
            // Marca como inicializado
            this.initialized = true;
            
            Log.debug('UFPel Theme: Inicialização completa');
            
        } catch (error) {
            Log.error('UFPel Theme: Erro na inicialização', error);
            Notification.exception(error);
        }
    }
    
    /**
     * Inicializa componentes base
     */
    initBaseComponents() {
        // Adiciona classes ao body baseadas no contexto
        this.addBodyClasses();
        
        // Configura tooltips do Bootstrap
        this.initTooltips();
        
        // Configura popovers do Bootstrap
        this.initPopovers();
        
        // Melhora formulários
        this.enhanceForms();
        
        // Adiciona smooth scroll
        this.initSmoothScroll();
    }
    
    /**
     * Adiciona classes contextuais ao body
     */
    addBodyClasses() {
        const body = document.body;
        
        // Detecta dispositivo
        if (/Mobi|Android/i.test(navigator.userAgent)) {
            body.classList.add('is-mobile');
        }
        
        // Detecta modo de curso
        const courseId = this.getCourseId();
        if (courseId && courseId !== '1') {
            body.classList.add('in-course');
            body.setAttribute('data-courseid', courseId);
        }
        
        // Detecta página
        const pageType = body.id || '';
        if (pageType) {
            body.classList.add(`page-${pageType}`);
        }
    }
    
    /**
     * Inicializa modo escuro
     */
    async initDarkMode() {
        try {
            // O módulo darkmode se auto-inicializa
            // Aqui podemos adicionar configurações extras
            
            // Adiciona transições suaves
            const style = document.createElement('style');
            style.textContent = `
                /* Transições para modo escuro */
                body.theme-dark-mode {
                    background-color: #1a1a1a;
                    color: #e0e0e0;
                }
                
                body.theme-dark-mode .card {
                    background-color: #2d2d2d;
                    border-color: #404040;
                }
                
                body.theme-dark-mode .navbar {
                    background-color: #2d2d2d !important;
                }
                
                body.theme-dark-mode .btn-primary {
                    background-color: #0066cc;
                    border-color: #0066cc;
                }
                
                body.theme-dark-mode .btn-secondary {
                    background-color: #404040;
                    border-color: #404040;
                }
                
                body.theme-dark-mode input,
                body.theme-dark-mode textarea,
                body.theme-dark-mode select {
                    background-color: #2d2d2d;
                    color: #e0e0e0;
                    border-color: #404040;
                }
                
                body.theme-dark-mode .dropdown-menu {
                    background-color: #2d2d2d;
                    border-color: #404040;
                }
                
                body.theme-dark-mode .dropdown-item {
                    color: #e0e0e0;
                }
                
                body.theme-dark-mode .dropdown-item:hover {
                    background-color: #404040;
                }
            `;
            document.head.appendChild(style);
            
        } catch (error) {
            Log.error('UFPel Theme: Erro ao inicializar modo escuro', error);
        }
    }
    
    /**
     * Inicializa ferramentas de acessibilidade
     */
    async initAccessibility() {
        try {
            // O módulo accessibility se auto-inicializa
            Log.debug('UFPel Theme: Acessibilidade inicializada');
        } catch (error) {
            Log.error('UFPel Theme: Erro ao inicializar acessibilidade', error);
        }
    }
    
    /**
     * Inicializa animações e efeitos
     */
    initAnimations() {
        // Parallax em imagens de header
        this.initParallax();
        
        // Animações de entrada ao rolar
        this.initScrollAnimations();
        
        // Loading animations
        this.initLoadingAnimations();
        
        // Hover effects nos cards
        this.initCardEffects();
    }
    
    /**
     * Inicializa efeito parallax
     */
    initParallax() {
        const parallaxElements = document.querySelectorAll('.course-header-image, .hero-image');
        
        if (parallaxElements.length === 0) return;
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(el => {
                const speed = el.dataset.parallaxSpeed || 0.5;
                el.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    }
    
    /**
     * Inicializa animações ao rolar
     */
    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observa elementos com classe animate-on-scroll
        document.querySelectorAll('.animate-on-scroll, .course-card, .activity-item').forEach(el => {
            observer.observe(el);
        });
    }
    
    /**
     * Inicializa animações de loading
     */
    initLoadingAnimations() {
        // Adiciona spinner ao carregar AJAX
        $(document).ajaxStart(() => {
            this.showLoadingOverlay();
        }).ajaxStop(() => {
            this.hideLoadingOverlay();
        });
    }
    
    /**
     * Mostra overlay de loading
     */
    showLoadingOverlay() {
        if (!document.querySelector('.ufpel-loading-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'ufpel-loading-overlay';
            overlay.innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Carregando...</span>
                </div>
            `;
            document.body.appendChild(overlay);
        }
    }
    
    /**
     * Esconde overlay de loading
     */
    hideLoadingOverlay() {
        const overlay = document.querySelector('.ufpel-loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    }
    
    /**
     * Inicializa efeitos nos cards
     */
    initCardEffects() {
        $('.course-card, .dashboard-card').on('mouseenter', function() {
            $(this).addClass('hover-effect');
        }).on('mouseleave', function() {
            $(this).removeClass('hover-effect');
        });
    }
    
    /**
     * Inicializa melhorias de UX
     */
    initUXEnhancements() {
        // Melhora navegação mobile
        this.enhanceMobileNavigation();
        
        // Adiciona feedback visual em ações
        this.addActionFeedback();
        
        // Melhora mensagens de erro/sucesso
        this.enhanceNotifications();
        
        // Adiciona confirmações em ações perigosas
        this.addDangerousActionConfirmations();
        
        // Sticky header ao rolar
        this.initStickyHeader();
    }
    
    /**
     * Melhora navegação mobile
     */
    enhanceMobileNavigation() {
        // Adiciona swipe para abrir/fechar drawer
        let touchStartX = 0;
        let touchEndX = 0;
        
        document.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        document.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        });
        
        this.handleSwipe = () => {
            const swipeThreshold = 50;
            const drawer = document.getElementById('nav-drawer');
            
            if (!drawer) return;
            
            if (touchEndX - touchStartX > swipeThreshold) {
                // Swipe right - abre drawer
                drawer.classList.add('show');
            }
            
            if (touchStartX - touchEndX > swipeThreshold) {
                // Swipe left - fecha drawer
                drawer.classList.remove('show');
