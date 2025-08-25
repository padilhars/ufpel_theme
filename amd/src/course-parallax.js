/**
 * UFPel Theme Course Header Parallax Effect
 * 
 * Provides smooth parallax scrolling effect for course header backgrounds.
 * Optimized for performance with requestAnimationFrame and intersection observer.
 *
 * @module     theme_ufpel/course-parallax
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery', 'core/log'], function($, Log) {
    'use strict';

    /**
     * Course Parallax Class
     * @class CourseParallax
     */
    class CourseParallax {
        
        /**
         * Constructor
         * @param {Object} options Configuration options
         */
        constructor(options = {}) {
            this.options = {
                selector: '.course-header__background',
                speed: 0.5,
                threshold: 0.1,
                enableOnMobile: false,
                ...options
            };
            
            this.elements = [];
            this.isScrolling = false;
            this.observer = null;
            this.rafId = null;
            this.isMobile = this.detectMobile();
            
            // Bind methods to maintain context
            this.handleScroll = this.handleScroll.bind(this);
            this.updateParallax = this.updateParallax.bind(this);
            this.handleIntersection = this.handleIntersection.bind(this);
            
            this.init();
        }
        
        /**
         * Initialize the parallax effect
         */
        init() {
            // Skip initialization on mobile if disabled
            if (this.isMobile && !this.options.enableOnMobile) {
                Log.debug('theme_ufpel/course-parallax: Skipping parallax on mobile device');
                return;
            }
            
            // Check for reduced motion preference
            if (this.prefersReducedMotion()) {
                Log.debug('theme_ufpel/course-parallax: Skipping parallax due to reduced motion preference');
                return;
            }
            
            // Find parallax elements
            this.elements = document.querySelectorAll(this.options.selector);
            
            if (this.elements.length === 0) {
                Log.debug('theme_ufpel/course-parallax: No parallax elements found');
                return;
            }
            
            this.setupIntersectionObserver();
            this.addEventListeners();
            this.updateParallax(); // Initial update
            
            Log.debug('theme_ufpel/course-parallax: Initialized with ' + this.elements.length + ' elements');
        }
        
        /**
         * Set up intersection observer for performance optimization
         */
        setupIntersectionObserver() {
            if (!window.IntersectionObserver) {
                // Fallback for older browsers
                this.addScrollListener();
                return;
            }
            
            const observerOptions = {
                rootMargin: '50px 0px',
                threshold: this.options.threshold
            };
            
            this.observer = new IntersectionObserver(this.handleIntersection, observerOptions);
            
            this.elements.forEach(element => {
                this.observer.observe(element.parentElement || element);
            });
        }
        
        /**
         * Handle intersection observer callback
         * @param {Array} entries Intersection observer entries
         */
        handleIntersection(entries) {
            let hasVisibleElements = false;
            
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    hasVisibleElements = true;
                }
            });
            
            if (hasVisibleElements && !this.isScrolling) {
                this.addScrollListener();
            } else if (!hasVisibleElements && this.isScrolling) {
                this.removeScrollListener();
            }
        }
        
        /**
         * Add scroll event listener
         */
        addScrollListener() {
            if (this.isScrolling) return;
            
            window.addEventListener('scroll', this.handleScroll, { passive: true });
            this.isScrolling = true;
        }
        
        /**
         * Remove scroll event listener
         */
        removeScrollListener() {
            if (!this.isScrolling) return;
            
            window.removeEventListener('scroll', this.handleScroll);
            this.isScrolling = false;
            
            if (this.rafId) {
                cancelAnimationFrame(this.rafId);
                this.rafId = null;
            }
        }
        
        /**
         * Handle scroll events
         */
        handleScroll() {
            if (this.rafId) return;
            
            this.rafId = requestAnimationFrame(() => {
                this.updateParallax();
                this.rafId = null;
            });
        }
        
        /**
         * Update parallax effect
         */
        updateParallax() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            
            this.elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const elementTop = rect.top + scrollTop;
                const elementHeight = rect.height;
                
                // Check if element is in viewport
                if (rect.bottom < 0 || rect.top > windowHeight) {
                    return;
                }
                
                // Calculate parallax offset
                const relativePos = (scrollTop - elementTop) * this.options.speed;
                const translateY = Math.round(relativePos * 100) / 100; // Round for better performance
                
                // Apply transform using CSS custom property for better performance
                element.style.setProperty('--parallax-y', `${translateY}px`);
                
                // Fallback transform for browsers that don't support CSS custom properties
                if (!CSS.supports('transform', 'translateY(var(--parallax-y))')) {
                    element.style.transform = `translateY(${translateY}px)`;
                }
            });
        }
        
        /**
         * Add event listeners
         */
        addEventListeners() {
            // Handle window resize
            window.addEventListener('resize', this.debounce(() => {
                this.updateParallax();
            }, 250), { passive: true });
            
            // Handle orientation change on mobile
            window.addEventListener('orientationchange', () => {
                setTimeout(() => {
                    this.updateParallax();
                }, 100);
            }, { passive: true });
        }
        
        /**
         * Check if user prefers reduced motion
         * @returns {boolean} True if reduced motion is preferred
         */
        prefersReducedMotion() {
            return window.matchMedia && 
                   window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        }
        
        /**
         * Detect mobile device
         * @returns {boolean} True if mobile device
         */
        detectMobile() {
            return window.matchMedia && 
                   window.matchMedia('(max-width: 768px)').matches ||
                   /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }
        
        /**
         * Debounce utility function
         * @param {Function} func Function to debounce
         * @param {number} wait Wait time in milliseconds
         * @returns {Function} Debounced function
         */
        debounce(func, wait) {
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
        
        /**
         * Destroy parallax instance
         */
        destroy() {
            this.removeScrollListener();
            
            if (this.observer) {
                this.observer.disconnect();
                this.observer = null;
            }
            
            // Remove transforms from elements
            this.elements.forEach(element => {
                element.style.removeProperty('--parallax-y');
                element.style.removeProperty('transform');
            });
            
            this.elements = [];
            
            Log.debug('theme_ufpel/course-parallax: Instance destroyed');
        }
    }
    
    /**
     * Initialize parallax effect on DOM ready
     */
    let parallaxInstance = null;
    
    /**
     * Public API
     */
    return {
        /**
         * Initialize the parallax effect
         * @param {Object} options Configuration options
         */
        init: function(options = {}) {
            $(document).ready(function() {
                // Destroy existing instance if any
                if (parallaxInstance) {
                    parallaxInstance.destroy();
                }
                
                // Create new instance
                parallaxInstance = new CourseParallax(options);
                
                Log.debug('theme_ufpel/course-parallax: Module initialized');
            });
        },
        
        /**
         * Destroy the current parallax instance
         */
        destroy: function() {
            if (parallaxInstance) {
                parallaxInstance.destroy();
                parallaxInstance = null;
            }
        },
        
        /**
         * Update parallax calculations (useful after dynamic content changes)
         */
        update: function() {
            if (parallaxInstance) {
                parallaxInstance.updateParallax();
            }
        }
    };
});