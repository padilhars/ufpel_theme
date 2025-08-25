/**
 * UFPel Theme Lazy Loading Module
 * 
 * Provides efficient lazy loading functionality for images and content
 * using Intersection Observer API with fallback support.
 *
 * @module     theme_ufpel/lazy-loading
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/log'], function($, Log) {
    'use strict';

    /**
     * Lazy Loading Class
     * @class LazyLoading
     */
    class LazyLoading {
        
        /**
         * Constructor
         * @param {Object} options Configuration options
         */
        constructor(options = {}) {
            this.options = {
                selector: '[data-src]',
                loadedClass: 'loaded',
                loadingClass: 'loading',
                errorClass: 'error',
                threshold: 0.1,
                rootMargin: '50px 0px',
                fadeInDuration: 300,
                retryAttempts: 2,
                retryDelay: 1000,
                enablePreload: true,
                placeholder: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E',
                ...options
            };
            
            this.elements = [];
            this.observer = null;
            this.loaded = new Set();
            this.loading = new Set();
            this.failed = new Set();
            
            // Bind methods to maintain context
            this.handleIntersection = this.handleIntersection.bind(this);
            this.loadElement = this.loadElement.bind(this);
            this.handleImageLoad = this.handleImageLoad.bind(this);
            this.handleImageError = this.handleImageError.bind(this);
            
            this.init();
        }
        
        /**
         * Initialize the lazy loading system
         */
        init() {
            this.elements = document.querySelectorAll(this.options.selector);
            
            if (this.elements.length === 0) {
                Log.debug('theme_ufpel/lazy-loading: No lazy loading elements found');
                return;
            }
            
            // Check for Intersection Observer support
            if (this.supportsIntersectionObserver()) {
                this.setupIntersectionObserver();
            } else {
                // Fallback for older browsers
                this.setupScrollListener();
            }
            
            // Set up preloading if enabled
            if (this.options.enablePreload) {
                this.setupPreloading();
            }
            
            Log.debug(`theme_ufpel/lazy-loading: Initialized with ${this.elements.length} elements`);
        }
        
        /**
         * Check if Intersection Observer is supported
         * @returns {boolean} True if supported
         */
        supportsIntersectionObserver() {
            return 'IntersectionObserver' in window &&
                   'IntersectionObserverEntry' in window &&
                   'intersectionRatio' in window.IntersectionObserverEntry.prototype;
        }
        
        /**
         * Set up Intersection Observer
         */
        setupIntersectionObserver() {
            const observerOptions = {
                root: null,
                rootMargin: this.options.rootMargin,
                threshold: this.options.threshold
            };
            
            this.observer = new IntersectionObserver(this.handleIntersection, observerOptions);
            
            this.elements.forEach(element => {
                this.observer.observe(element);
                this.setPlaceholder(element);
            });
        }
        
        /**
         * Set up scroll listener fallback for older browsers
         */
        setupScrollListener() {
            this.elements.forEach(element => {
                this.setPlaceholder(element);
            });
            
            // Use debounced scroll listener
            let scrollTimeout;
            const checkElements = () => {
                this.elements.forEach(element => {
                    if (this.isElementInViewport(element) && !this.loaded.has(element)) {
                        this.loadElement(element);
                    }
                });
            };
            
            const handleScroll = () => {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(checkElements, 100);
            };
            
            window.addEventListener('scroll', handleScroll, { passive: true });
            window.addEventListener('resize', handleScroll, { passive: true });
            
            // Initial check
            checkElements();
        }
        
        /**
         * Handle intersection observer callback
         * @param {Array} entries Intersection observer entries
         */
        handleIntersection(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    this.loadElement(element);
                    this.observer.unobserve(element);
                }
            });
        }
        
        /**
         * Check if element is in viewport (fallback method)
         * @param {HTMLElement} element The element to check
         * @returns {boolean} True if in viewport
         */
        isElementInViewport(element) {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const windowWidth = window.innerWidth || document.documentElement.clientWidth;
            
            return rect.bottom >= 0 &&
                   rect.right >= 0 &&
                   rect.top <= windowHeight &&
                   rect.left <= windowWidth;
        }
        
        /**
         * Load an element
         * @param {HTMLElement} element The element to load
         * @param {number} attempt Current attempt number
         */
        loadElement(element, attempt = 1) {
            if (this.loaded.has(element) || this.loading.has(element)) {
                return;
            }
            
            this.loading.add(element);
            element.classList.add(this.options.loadingClass);
            
            const src = element.dataset.src;
            const srcset = element.dataset.srcset;
            const sizes = element.dataset.sizes;
            
            if (!src && !srcset) {
                Log.warn('theme_ufpel/lazy-loading: No data-src or data-srcset found', element);
                this.handleLoadError(element, new Error('No source found'));
                return;
            }
            
            if (element.tagName.toLowerCase() === 'img') {
                this.loadImage(element, src, srcset, sizes, attempt);
            } else {
                this.loadBackground(element, src, attempt);
            }
        }
        
        /**
         * Load an image element
         * @param {HTMLElement} element The image element
         * @param {string} src Image source URL
         * @param {string} srcset Image srcset
         * @param {string} sizes Image sizes
         * @param {number} attempt Current attempt number
         */
        loadImage(element, src, srcset, sizes, attempt) {
            const img = new Image();
            
            // Set up event listeners
            img.onload = () => this.handleImageLoad(element, img, attempt);
            img.onerror = () => this.handleImageError(element, attempt);
            
            // Set image attributes
            if (srcset) {
                img.srcset = srcset;
            }
            if (sizes) {
                img.sizes = sizes;
            }
            if (src) {
                img.src = src;
            }
            
            // Set loading attribute for modern browsers
            if ('loading' in HTMLImageElement.prototype) {
                img.loading = 'lazy';
            }
            
            // Add timeout for slow connections
            setTimeout(() => {
                if (this.loading.has(element)) {
                    img.onload = null;
                    img.onerror = null;
                    this.handleImageError(element, attempt);
                }
            }, 10000); // 10 second timeout
        }
        
        /**
         * Load a background image
         * @param {HTMLElement} element The element
         * @param {string} src Background image URL
         * @param {number} attempt Current attempt number
         */
        loadBackground(element, src, attempt) {
            const img = new Image();
            
            img.onload = () => {
                element.style.backgroundImage = `url("${src}")`;
                this.handleImageLoad(element, img, attempt);
            };
            
            img.onerror = () => this.handleImageError(element, attempt);
            
            img.src = src;
        }
        
        /**
         * Handle successful image load
         * @param {HTMLElement} element The element
         * @param {HTMLImageElement} img The image
         * @param {number} attempt Current attempt number
         */
        handleImageLoad(element, img, attempt) {
            if (element.tagName.toLowerCase() === 'img') {
                // Copy attributes to original element
                if (img.src) element.src = img.src;
                if (img.srcset) element.srcset = img.srcset;
                if (img.sizes) element.sizes = img.sizes;
                
                // Copy alt text if not present
                if (!element.alt && img.alt) {
                    element.alt = img.alt;
                }
            }
            
            // Remove data attributes
            delete element.dataset.src;
            delete element.dataset.srcset;
            delete element.dataset.sizes;
            
            // Update state
            this.loading.delete(element);
            this.loaded.add(element);
            
            // Update classes
            element.classList.remove(this.options.loadingClass);
            element.classList.add(this.options.loadedClass);
            
            // Fade in effect
            this.fadeIn(element);
            
            // Dispatch custom event
            this.dispatchEvent(element, 'lazyloaded', {
                attempt: attempt,
                element: element
            });
            
            Log.debug('theme_ufpel/lazy-loading: Successfully loaded', element);
        }
        
        /**
         * Handle image load error
         * @param {HTMLElement} element The element
         * @param {number} attempt Current attempt number
         */
        handleImageError(element, attempt) {
            this.loading.delete(element);
            element.classList.remove(this.options.loadingClass);
            
            if (attempt <= this.options.retryAttempts) {
                // Retry after delay
                setTimeout(() => {
                    Log.debug(`theme_ufpel/lazy-loading: Retrying load (attempt ${attempt + 1})`, element);
                    this.loadElement(element, attempt + 1);
                }, this.options.retryDelay);
                return;
            }
            
            // Max attempts reached
            this.failed.add(element);
            element.classList.add(this.options.errorClass);
            
            // Set fallback image if available
            const fallback = element.dataset.fallback;
            if (fallback && element.tagName.toLowerCase() === 'img') {
                element.src = fallback;
                element.alt = element.dataset.fallbackAlt || 'Image unavailable';
            }
            
            // Dispatch error event
            this.dispatchEvent(element, 'lazyerror', {
                attempt: attempt,
                element: element
            });
            
            Log.error('theme_ufpel/lazy-loading: Failed to load after retries', element);
        }
        
        /**
         * Handle load error
         * @param {HTMLElement} element The element
         * @param {Error} error The error
         */
        handleLoadError(element, error) {
            this.loading.delete(element);
            this.failed.add(element);
            element.classList.remove(this.options.loadingClass);
            element.classList.add(this.options.errorClass);
            
            this.dispatchEvent(element, 'lazyerror', {
                element: element,
                error: error
            });
        }
        
        /**
         * Set placeholder for element
         * @param {HTMLElement} element The element
         */
        setPlaceholder(element) {
            if (element.tagName.toLowerCase() === 'img' && !element.src) {
                element.src = this.options.placeholder;
            }
        }
        
        /**
         * Fade in element with CSS transition
         * @param {HTMLElement} element The element
         */
        fadeIn(element) {
            if (this.options.fadeInDuration <= 0) return;
            
            element.style.opacity = '0';
            element.style.transition = `opacity ${this.options.fadeInDuration}ms ease`;
            
            // Force reflow
            element.offsetHeight;
            
            element.style.opacity = '1';
            
            // Clean up after transition
            setTimeout(() => {
                element.style.transition = '';
            }, this.options.fadeInDuration);
        }
        
        /**
         * Set up preloading for priority images
         */
        setupPreloading() {
            const priorityElements = document.querySelectorAll('[data-src][data-priority="high"]');
            
            priorityElements.forEach(element => {
                const src = element.dataset.src;
                if (src) {
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = src;
                    
                    if (element.dataset.srcset) {
                        link.imagesrcset = element.dataset.srcset;
                    }
                    if (element.dataset.sizes) {
                        link.imagesizes = element.dataset.sizes;
                    }
                    
                    document.head.appendChild(link);
                }
            });
        }
        
        /**
         * Dispatch custom event
         * @param {HTMLElement} element The element
         * @param {string} eventName Event name
         * @param {Object} detail Event detail
         */
        dispatchEvent(element, eventName, detail) {
            const event = new CustomEvent(eventName, {
                detail: detail,
                bubbles: true,
                cancelable: false
            });
            element.dispatchEvent(event);
        }
        
        /**
         * Load all remaining elements immediately
         */
        loadAll() {
            this.elements.forEach(element => {
                if (!this.loaded.has(element) && !this.loading.has(element)) {
                    this.loadElement(element);
                }
            });
        }
        
        /**
         * Refresh and scan for new elements
         */
        refresh() {
            const newElements = document.querySelectorAll(this.options.selector);
            const elementsToAdd = Array.from(newElements).filter(el => 
                !Array.from(this.elements).includes(el)
            );
            
            if (elementsToAdd.length > 0) {
                this.elements = newElements;
                
                elementsToAdd.forEach(element => {
                    this.setPlaceholder(element);
                    
                    if (this.observer) {
                        this.observer.observe(element);
                    } else {
                        // Check if immediately visible for fallback mode
                        if (this.isElementInViewport(element)) {
                            this.loadElement(element);
                        }
                    }
                });
                
                Log.debug(`theme_ufpel/lazy-loading: Added ${elementsToAdd.length} new elements`);
            }
        }
        
        /**
         * Get loading statistics
         * @returns {Object} Statistics object
         */
        getStats() {
            return {
                total: this.elements.length,
                loaded: this.loaded.size,
                loading: this.loading.size,
                failed: this.failed.size,
                pending: this.elements.length - this.loaded.size - this.loading.size - this.failed.size
            };
        }
        
        /**
         * Destroy the lazy loading instance
         */
        destroy() {
            if (this.observer) {
                this.observer.disconnect();
                this.observer = null;
            }
            
            // Clear all sets
            this.loaded.clear();
            this.loading.clear();
            this.failed.clear();
            
            // Remove event listeners would be handled by the scroll listener setup
            
            Log.debug('theme_ufpel/lazy-loading: Instance destroyed');
        }
    }
    
    /**
     * Module instance
     */
    let lazyInstance = null;
    
    /**
     * Public API
     */
    return {
        /**
         * Initialize lazy loading
         * @param {Object} options Configuration options
         */
        init: function(options = {}) {
            // Destroy existing instance if any
            if (lazyInstance) {
                lazyInstance.destroy();
            }
            
            // Create new instance
            lazyInstance = new LazyLoading(options);
            
            // Set up global event listeners for dynamic content
            $(document).ready(function() {
                // Listen for dynamic content additions
                const observer = new MutationObserver(function(mutations) {
                    let hasNewLazyElements = false;
                    
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) { // Element node
                                if (node.matches && node.matches(options.selector || '[data-src]')) {
                                    hasNewLazyElements = true;
                                } else if (node.querySelector) {
                                    const found = node.querySelector(options.selector || '[data-src]');
                                    if (found) {
                                        hasNewLazyElements = true;
                                    }
                                }
                            }
                        });
                    });
                    
                    if (hasNewLazyElements && lazyInstance) {
                        lazyInstance.refresh();
                    }
                });
                
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            });
            
            Log.debug('theme_ufpel/lazy-loading: Module initialized');
        },
        
        /**
         * Load all elements immediately
         */
        loadAll: function() {
            if (lazyInstance) {
                lazyInstance.loadAll();
            }
        },
        
        /**
         * Refresh and scan for new elements
         */
        refresh: function() {
            if (lazyInstance) {
                lazyInstance.refresh();
            }
        },
        
        /**
         * Get loading statistics
         * @returns {Object} Statistics object
         */
        getStats: function() {
            return lazyInstance ? lazyInstance.getStats() : null;
        },
        
        /**
         * Destroy the lazy loading instance
         */
        destroy: function() {
            if (lazyInstance) {
                lazyInstance.destroy();
                lazyInstance = null;
            }
        }
    };
});