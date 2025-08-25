<?php
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
 * UFPel theme core renderer.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_ufpel\output;

use stdClass;
use html_writer;
use moodle_url;
use context_course;
use core_course_external;
use core_course\external\course_summary_exporter;

defined('MOODLE_INTERNAL') || die();

/**
 * UFPel core renderer class.
 *
 * Extends the Boost core renderer with UFPel-specific functionality.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Override the navbar brand rendering to use UFPel template.
     *
     * @return string HTML for the navbar brand
     */
    public function navbar_brand() {
        global $CFG, $SITE;
        
        $theme = \theme_config::load('ufpel');
        
        $templatecontext = [
            'sitename' => format_string($SITE->shortname),
            'siteurl' => $CFG->wwwroot,
            'ufpel_logo_url' => theme_ufpel_get_logo_url($theme),
            'ufpel_show_sitename' => theme_ufpel_get_setting('showsitename', true),
        ];
        
        return $this->render_from_template('theme_ufpel/navbar_brand', $templatecontext);
    }
    
    /**
     * Render the course header with UFPel customizations.
     *
     * @param stdClass $course The course object
     * @return string HTML for the course header
     */
    public function render_course_header($course) {
        global $CFG, $PAGE;
        
        if (!$course || $PAGE->pagelayout !== 'course') {
            return '';
        }
        
        $templatecontext = [
            'course' => [
                'id' => $course->id,
                'fullname' => format_string($course->fullname),
                'shortname' => format_string($course->shortname),
                'summary' => format_text($course->summary, $course->summaryformat, ['context' => context_course::instance($course->id)])
            ]
        ];
        
        // Add UFPel course header context
        $templatecontext = theme_ufpel_add_course_header_context($templatecontext, $course);
        $templatecontext['ufpel_enable_parallax'] = theme_ufpel_get_setting('enableparallax', true);
        
        return $this->render_from_template('theme_ufpel/course_header', $templatecontext);
    }
    
    /**
     * Render custom UFPel cards.
     *
     * @param array $cards Array of card data
     * @param string $cardtype Type of cards (course, activity, info, announcement)
     * @param array $options Additional options
     * @return string HTML for the cards
     */
    public function render_ufpel_cards($cards, $cardtype = 'course', $options = []) {
        $defaultoptions = [
            'show_images' => true,
            'lazy_loading' => theme_ufpel_get_setting('enablelazyloading', true),
            'card_type' => $cardtype
        ];
        
        $options = array_merge($defaultoptions, $options);
        
        $templatecontext = [
            'cards' => $cards,
            'card_type' => $cardtype,
            'show_images' => $options['show_images'],
            'lazy_loading' => $options['lazy_loading']
        ];
        
        return $this->render_from_template('theme_ufpel/cards', $templatecontext);
    }
    
    /**
     * Override the page footer rendering to use UFPel template.
     *
     * @return string HTML for the footer
     */
    public function standard_footer_html() {
        global $CFG, $SITE;
        
        $theme = \theme_config::load('ufpel');
        
        $templatecontext = [
            'sitename' => format_string($SITE->shortname),
            'homelink' => new moodle_url('/'),
            'ufpel_logo_url' => theme_ufpel_get_logo_url($theme),
            'ufpel_show_footer_links' => theme_ufpel_get_setting('showfooterlinks', true),
            'current_year' => date('Y'),
            'logininfo' => $this->login_info(),
            'output' => $this
        ];
        
        return $this->render_from_template('theme_ufpel/footer', $templatecontext);
    }
    
    /**
     * Render the main content area with UFPel enhancements.
     *
     * @return string HTML for main content
     */
    public function main_content() {
        global $PAGE;
        
        $content = parent::main_content();
        
        // Add UFPel course header for course pages
        if ($PAGE->pagelayout === 'course' && !empty($PAGE->course->id) && $PAGE->course->id != SITEID) {
            $course = $PAGE->course;
            $courseheader = $this->render_course_header($course);
            
            // Insert course header before main content
            if (!empty($courseheader)) {
                $content = $courseheader . $content;
            }
        }
        
        return $content;
    }
    
    /**
     * Get UFPel theme colors for use in JavaScript.
     *
     * @return array Theme colors
     */
    public function get_ufpel_theme_colors() {
        return theme_ufpel_get_theme_colors();
    }
    
    /**
     * Render a UFPel alert component.
     *
     * @param string $message Alert message
     * @param string $type Alert type (primary, success, warning, danger)
     * @param array $options Additional options
     * @return string HTML for the alert
     */
    public function render_ufpel_alert($message, $type = 'primary', $options = []) {
        $defaultoptions = [
            'dismissible' => false,
            'icon' => null,
            'title' => null
        ];
        
        $options = array_merge($defaultoptions, $options);
        
        $classes = ['alert', 'alert-ufpel', "alert-ufpel-{$type}"];
        
        if ($options['dismissible']) {
            $classes[] = 'alert-dismissible';
        }
        
        if ($options['icon']) {
            $classes[] = 'with-icon';
        }
        
        $html = html_writer::start_tag('div', [
            'class' => implode(' ', $classes),
            'role' => 'alert'
        ]);
        
        if ($options['icon']) {
            $html .= html_writer::tag('div', 
                html_writer::tag('i', '', ['class' => "fa {$options['icon']} alert-icon", 'aria-hidden' => 'true']),
                ['class' => 'alert-icon-container']
            );
        }
        
        $html .= html_writer::start_tag('div', ['class' => 'alert-content']);
        
        if ($options['title']) {
            $html .= html_writer::tag('h6', $options['title'], ['class' => 'alert-heading']);
        }
        
        $html .= html_writer::tag('p', $message, ['class' => 'mb-0']);
        
        $html .= html_writer::end_tag('div'); // alert-content
        
        if ($options['dismissible']) {
            $html .= html_writer::tag('button', '', [
                'type' => 'button',
                'class' => 'btn-close',
                'data-bs-dismiss' => 'alert',
                'aria-label' => get_string('close', 'core')
            ]);
        }
        
        $html .= html_writer::end_tag('div'); // alert
        
        return $html;
    }
    
    /**
     * Render a UFPel button component.
     *
     * @param string $text Button text
     * @param moodle_url|string $url Button URL
     * @param array $options Button options
     * @return string HTML for the button
     */
    public function render_ufpel_button($text, $url, $options = []) {
        $defaultoptions = [
            'type' => 'primary', // primary, secondary, accent
            'size' => 'md', // sm, md, lg
            'icon' => null,
            'disabled' => false,
            'class' => ''
        ];
        
        $options = array_merge($defaultoptions, $options);
        
        $classes = ['btn', "btn-ufpel-{$options['type']}"];
        
        if ($options['size'] !== 'md') {
            $classes[] = "btn-ufpel-{$options['size']}";
        }
        
        if ($options['class']) {
            $classes[] = $options['class'];
        }
        
        $attributes = [
            'class' => implode(' ', $classes),
            'href' => $url instanceof moodle_url ? $url->out(false) : $url
        ];
        
        if ($options['disabled']) {
            $attributes['aria-disabled'] = 'true';
            $attributes['class'] .= ' disabled';
        }
        
        $content = '';
        if ($options['icon']) {
            $content .= html_writer::tag('i', '', [
                'class' => "fa {$options['icon']} me-2",
                'aria-hidden' => 'true'
            ]);
        }
        
        $content .= $text;
        
        return html_writer::tag('a', $content, $attributes);
    }
    
    /**
     * Render a UFPel progress bar.
     *
     * @param int $value Progress value (0-100)
     * @param array $options Progress bar options
     * @return string HTML for the progress bar
     */
    public function render_ufpel_progress($value, $options = []) {
        $defaultoptions = [
            'type' => 'primary', // primary, accent
            'size' => 'md', // sm, md, lg
            'striped' => false,
            'show_text' => true,
            'label' => null
        ];
        
        $options = array_merge($defaultoptions, $options);
        
        $value = max(0, min(100, intval($value)));
        
        $classes = ['progress', 'progress-ufpel'];
        
        if ($options['size'] !== 'md') {
            $classes[] = "progress-{$options['size']}";
        }
        
        if ($options['type'] !== 'primary') {
            $classes[] = "progress-{$options['type']}";
        }
        
        $html = html_writer::start_tag('div', ['class' => implode(' ', $classes)]);
        
        if ($options['label']) {
            $html .= html_writer::tag('div', $options['label'], [
                'class' => 'progress-label mb-1 small text-muted'
            ]);
        }
        
        $barclasses = ['progress-ufpel__bar'];
        
        if ($options['striped']) {
            $barclasses[] = 'striped';
        }
        
        $html .= html_writer::start_tag('div', [
            'class' => implode(' ', $barclasses),
            'role' => 'progressbar',
            'style' => "width: {$value}%",
            'aria-valuenow' => $value,
            'aria-valuemin' => '0',
            'aria-valuemax' => '100'
        ]);
        
        if ($options['show_text']) {
            $html .= html_writer::tag('span', "{$value}%", [
                'class' => 'progress-ufpel__bar__text'
            ]);
        }
        
        $html .= html_writer::end_tag('div'); // progress-bar
        $html .= html_writer::end_tag('div'); // progress
        
        return $html;
    }
    
    /**
     * Render a UFPel badge component.
     *
     * @param string $text Badge text
     * @param array $options Badge options
     * @return string HTML for the badge
     */
    public function render_ufpel_badge($text, $options = []) {
        $defaultoptions = [
            'type' => 'primary', // primary, secondary, accent, outline
            'pulse' => false
        ];
        
        $options = array_merge($defaultoptions, $options);
        
        $classes = ['badge', 'badge-ufpel', "badge-ufpel-{$options['type']}"];
        
        if ($options['pulse']) {
            $classes[] = 'pulse';
        }
        
        return html_writer::tag('span', $text, [
            'class' => implode(' ', $classes)
        ]);
    }
    
    /**
     * Add UFPel head elements to the page.
     *
     * @return string HTML for head elements
     */
    public function ufpel_head_elements() {
        return theme_ufpel_add_head_elements();
    }
    
    /**
     * Check if dark mode is enabled.
     *
     * @return bool True if dark mode is enabled
     */
    public function is_dark_mode_enabled() {
        return theme_ufpel_get_setting('enabledarkmode', true);
    }
    
    /**
     * Get UFPel theme settings for JavaScript use.
     *
     * @return array Theme settings
     */
    public function get_ufpel_theme_settings() {
        return [
            'colors' => $this->get_ufpel_theme_colors(),
            'enableParallax' => theme_ufpel_get_setting('enableparallax', true),
            'enableLazyLoading' => theme_ufpel_get_setting('enablelazyloading', true),
            'enableDarkMode' => $this->is_dark_mode_enabled(),
        ];
    }
    
    /**
     * Render skip links for accessibility.
     *
     * @return string HTML for skip links
     */
    public function render_skip_links() {
        $links = [
            '#main-content' => get_string('skiptomaincontent', 'theme_ufpel'),
            '#page-navbar' => get_string('skiptonavigation', 'theme_ufpel'),
        ];
        
        // Add course content link if on course page
        global $PAGE;
        if ($PAGE->pagelayout === 'course') {
            $links['#region-main'] = get_string('skiptocoursecontent', 'theme_ufpel');
        }
        
        $html = html_writer::start_tag('div', ['class' => 'skip-links']);
        
        foreach ($links as $href => $text) {
            $html .= html_writer::link($href, $text, [
                'class' => 'sr-only sr-only-focusable'
            ]);
        }
        
        $html .= html_writer::end_tag('div');
        
        return $html;
    }
    
    /**
     * Initialize UFPel JavaScript modules.
     *
     * @return string JavaScript initialization code
     */
    public function init_ufpel_javascript() {
        global $PAGE;
        
        $js = [];
        
        // Initialize lazy loading if enabled
        if (theme_ufpel_get_setting('enablelazyloading', true)) {
            $PAGE->requires->js_call_amd('theme_ufpel/lazy-loading', 'init', [
                [
                    'selector' => '.lazy-load, [data-src]',
                    'threshold' => 0.1,
                    'fadeInDuration' => 300
                ]
            ]);
        }
        
        // Initialize parallax if enabled
        if (theme_ufpel_get_setting('enableparallax', true)) {
            $PAGE->requires->js_call_amd('theme_ufpel/course-parallax', 'init', [
                [
                    'selector' => '.course-header__background',
                    'speed' => 0.5,
                    'enableOnMobile' => false
                ]
            ]);
        }
        
        // Add theme settings to JavaScript
        $PAGE->requires->js_amd_inline("
            require(['jquery'], function($) {
                window.ufpelTheme = " . json_encode($this->get_ufpel_theme_settings()) . ";
            });
        ");
        
        return implode("\n", $js);
    }
    
    /**
     * Override standard_head_html to add UFPel customizations.
     *
     * @return string HTML for head
     */
    public function standard_head_html() {
        $html = parent::standard_head_html();
        
        // Add UFPel head elements
        $html .= $this->ufpel_head_elements();
        
        // Add UFPel theme colors as CSS custom properties
        $colors = $this->get_ufpel_theme_colors();
        $cssVars = '';
        foreach ($colors as $key => $value) {
            $cssVars .= "--ufpel-{$key}: {$value}; ";
        }
        
        if ($cssVars) {
            $html .= "<style>:root { {$cssVars} }</style>";
        }
        
        return $html;
    }
    
    /**
     * Override full_header to add skip links and UFPel customizations.
     *
     * @return string HTML for full header
     */
    public function full_header() {
        $html = $this->render_skip_links();
        $html .= parent::full_header();
        
        return $html;
    }
    
    /**
     * Override standard_end_of_body_html to add UFPel JavaScript initialization.
     *
     * @return string HTML for end of body
     */
    public function standard_end_of_body_html() {
        $html = parent::standard_end_of_body_html();
        $html .= $this->init_ufpel_javascript();
        
        return $html;
    }
}