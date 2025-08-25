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
 * Theme UFPel configuration file.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$THEME->name = 'ufpel';
$THEME->doctype = 'html5';
$THEME->parents = ['boost']; // 100% inheritance from Boost 5.0.
$THEME->enable_dock = false;
$THEME->extrascsscallback = 'theme_ufpel_get_extra_scss';
$THEME->prescsscallback = 'theme_ufpel_get_pre_scss';
$THEME->yuicssmodules = [];
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_ufpel_process_css';

// SCSS compilation settings for Moodle 5.0.
$THEME->scss = function($theme) {
    return theme_ufpel_get_main_scss_content($theme);
};

// Custom templates to override from Boost.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// JavaScript modules for theme functionality.
$THEME->javascripts = [];

// Custom Mustache templates that override Boost templates.
// These will be loaded from theme/ufpel/templates/
$THEME->hidefromselector = false;

// Theme can be used on mobile devices.
$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = [];

// Define precompiled CSS for better performance.
$THEME->sheets = [];

// Define layouts if needed (inherits all from Boost).
$THEME->layouts = [];

// Custom functions for this theme.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Editor styles.
$THEME->editor_sheets = [];

// Remove unused CSS selectors for better performance.
$THEME->usefallback = true;

// Mobile app support.
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;