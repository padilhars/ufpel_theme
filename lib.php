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
 * Theme UFPel library functions.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Get SCSS content for the theme.
 *
 * @param theme_config $theme The theme configuration object.
 * @return string SCSS content.
 */
function theme_ufpel_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : 'default';
    $fs = get_file_storage();

    $context = context_system::instance();
    $filepath = "/{$context->id}/theme_ufpel/preset/0/{$filename}.scss";
    $file = $fs->get_file_by_hash(sha1($filepath));
    
    if (!$file) {
        // Use default preset if file not found.
        $scss .= file_get_contents($CFG->dirroot . '/theme/ufpel/scss/preset/default.scss');
    } else {
        $scss .= $file->get_content();
    }

    // Add post SCSS.
    $scss .= file_get_contents($CFG->dirroot . '/theme/ufpel/scss/post.scss');

    return $scss;
}

/**
 * Get pre SCSS variables.
 *
 * @param theme_config $theme The theme configuration object.
 * @return string Pre SCSS variables.
 */
function theme_ufpel_get_pre_scss($theme) {
    $scss = '';

    // UFPel color variables.
    $primarycolor = get_config('theme_ufpel', 'primarycolor') ?: '#00408F';
    $secondarycolor = get_config('theme_ufpel', 'secondarycolor') ?: '#0080FF';
    $accentcolor = get_config('theme_ufpel', 'accentcolor') ?: '#F7A600';
    $backgroundcolor = get_config('theme_ufpel', 'backgroundcolor') ?: '#EBF5FF';
    $textcolor = get_config('theme_ufpel', 'textcolor') ?: '#212529';
    $texthighlightcolor = get_config('theme_ufpel', 'texthighlightcolor') ?: '#FFFFFF';

    // Bootstrap 5 variable overrides.
    $scss .= '$primary: ' . $primarycolor . ';' . "\n";
    $scss .= '$secondary: ' . $secondarycolor . ';' . "\n";
    $scss .= '$warning: ' . $accentcolor . ';' . "\n";
    $scss .= '$light: ' . $backgroundcolor . ';' . "\n";
    $scss .= '$dark: ' . $textcolor . ';' . "\n";
    $scss .= '$white: ' . $texthighlightcolor . ';' . "\n";

    // UFPel specific variables.
    $scss .= '$ufpel-primary: ' . $primarycolor . ';' . "\n";
    $scss .= '$ufpel-secondary: ' . $secondarycolor . ';' . "\n";
    $scss .= '$ufpel-accent: ' . $accentcolor . ';' . "\n";
    $scss .= '$ufpel-background: ' . $backgroundcolor . ';' . "\n";
    $scss .= '$ufpel-text: ' . $textcolor . ';' . "\n";
    $scss .= '$ufpel-text-highlight: ' . $texthighlightcolor . ';' . "\n";

    // Dark mode support.
    $scss .= '$ufpel-primary-dark: lighten(' . $primarycolor . ', 20%);' . "\n";
    $scss .= '$ufpel-background-dark: #1a1a1a;' . "\n";
    $scss .= '$ufpel-text-dark: #f8f9fa;' . "\n";

    return $scss;
}

/**
 * Get extra SCSS for the theme.
 *
 * @param theme_config $theme The theme configuration object.
 * @return string Extra SCSS content.
 */
function theme_ufpel_get_extra_scss($theme) {
    $content = '';
    
    // Load UFPel custom SCSS files.
    $content .= theme_ufpel_load_scss_file('ufpel/variables');
    $content .= theme_ufpel_load_scss_file('ufpel/colors'); 
    $content .= theme_ufpel_load_scss_file('ufpel/components');
    $content .= theme_ufpel_load_scss_file('ufpel/utilities');

    // Add custom SCSS from settings.
    if (!empty($theme->settings->scss)) {
        $content .= $theme->settings->scss;
    }

    return $content;
}

/**
 * Load SCSS file content.
 *
 * @param string $filename The SCSS file name without extension.
 * @return string SCSS file content or empty string.
 */
function theme_ufpel_load_scss_file($filename) {
    global $CFG;
    
    $filepath = $CFG->dirroot . '/theme/ufpel/scss/' . $filename . '.scss';
    
    if (file_exists($filepath)) {
        return file_get_contents($filepath);
    }
    
    return '';
}

/**
 * Process CSS after compilation.
 *
 * @param string $css The compiled CSS.
 * @param theme_config $theme The theme configuration object.
 * @return string Processed CSS.
 */
function theme_ufpel_process_css($css, $theme) {
    // Add any post-processing logic here.
    return $css;
}

/**
 * Get theme setting value with fallback.
 *
 * @param string $setting The setting name.
 * @param mixed $default The default value.
 * @return mixed The setting value or default.
 */
function theme_ufpel_get_setting($setting, $default = null) {
    $theme = theme_config::load('ufpel');
    
    if (property_exists($theme->settings, $setting)) {
        return $theme->settings->{$setting};
    }
    
    return $default;
}

/**
 * Get logo URL.
 *
 * @param theme_config $theme The theme configuration object.
 * @return moodle_url|null Logo URL or null.
 */
function theme_ufpel_get_logo_url($theme) {
    static $logo = null;
    
    if ($logo !== null) {
        return $logo;
    }
    
    $logo = $theme->setting_file_url('logo', 'logo');
    return $logo;
}

/**
 * Get favicon URL.
 *
 * @param theme_config $theme The theme configuration object.
 * @return moodle_url|null Favicon URL or null.
 */
function theme_ufpel_get_favicon_url($theme) {
    static $favicon = null;
    
    if ($favicon !== null) {
        return $favicon;
    }
    
    $favicon = $theme->setting_file_url('favicon', 'favicon');
    return $favicon;
}

/**
 * Add course header context data.
 *
 * @param array $templatecontext The template context.
 * @param stdClass $course The course object.
 * @return array Modified template context.
 */
function theme_ufpel_add_course_header_context($templatecontext, $course) {
    global $CFG;
    
    $theme = theme_config::load('ufpel');
    
    // Add course header settings.
    $templatecontext['ufpel_course_header_overlay'] = theme_ufpel_get_setting('courseheaderoverlay', true);
    $templatecontext['ufpel_show_course_image'] = theme_ufpel_get_setting('showcourseimage', true);
    $templatecontext['ufpel_show_course_teachers'] = theme_ufpel_get_setting('showcourseteachers', true);
    $templatecontext['ufpel_show_course_participants'] = theme_ufpel_get_setting('showcourseparticipants', true);
    
    // Get course image URL.
    $courseimage = \core_course\external\course_summary_exporter::get_course_image($course);
    if (!$courseimage) {
        $courseimage = $CFG->wwwroot . '/theme/ufpel/pix/default-course-image.jpg';
    }
    $templatecontext['ufpel_course_image'] = $courseimage;
    
    // Get course teachers.
    if ($templatecontext['ufpel_show_course_teachers']) {
        $templatecontext['ufpel_course_teachers'] = theme_ufpel_get_course_teachers($course);
    }
    
    // Get course participants count.
    if ($templatecontext['ufpel_show_course_participants']) {
        $templatecontext['ufpel_participants_count'] = theme_ufpel_get_course_participants_count($course);
    }
    
    return $templatecontext;
}

/**
 * Get course teachers.
 *
 * @param stdClass $course The course object.
 * @return array Array of teacher objects.
 */
function theme_ufpel_get_course_teachers($course) {
    global $DB;
    
    $context = context_course::instance($course->id);
    $teachers = get_enrolled_users($context, 'mod/assign:grade', 0, 'u.id, u.firstname, u.lastname, u.picture, u.imagealt, u.email');
    
    $teacherslist = [];
    foreach ($teachers as $teacher) {
        $teacherpicture = new user_picture($teacher);
        $teacherpicture->size = 1; // Small size for course header.
        
        $teacherslist[] = [
            'id' => $teacher->id,
            'fullname' => fullname($teacher),
            'profileimage' => $teacherpicture->get_url(page_get_instance())->out(false),
            'profileurl' => new moodle_url('/user/profile.php', ['id' => $teacher->id])
        ];
    }
    
    return $teacherslist;
}

/**
 * Get course participants count.
 *
 * @param stdClass $course The course object.
 * @return int Number of participants.
 */
function theme_ufpel_get_course_participants_count($course) {
    $context = context_course::instance($course->id);
    return count_enrolled_users($context);
}

/**
 * Extend navigation for theme.
 *
 * @param global_navigation $navigation The global navigation object.
 */
function theme_ufpel_extend_navigation(global_navigation $navigation) {
    // Add any custom navigation items here.
}

/**
 * Add head elements for the theme.
 *
 * @return string HTML to add to head.
 */
function theme_ufpel_add_head_elements() {
    $theme = theme_config::load('ufpel');
    $html = '';
    
    // Add favicon if configured.
    $favicon = theme_ufpel_get_favicon_url($theme);
    if ($favicon) {
        $html .= '<link rel="icon" type="image/x-icon" href="' . $favicon . '">' . "\n";
    }
    
    // Add preload for fonts if needed.
    $html .= '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    
    return $html;
}

/**
 * Get theme colors for JavaScript use.
 *
 * @return array Theme colors.
 */
function theme_ufpel_get_theme_colors() {
    return [
        'primary' => get_config('theme_ufpel', 'primarycolor') ?: '#00408F',
        'secondary' => get_config('theme_ufpel', 'secondarycolor') ?: '#0080FF',
        'accent' => get_config('theme_ufpel', 'accentcolor') ?: '#F7A600',
        'background' => get_config('theme_ufpel', 'backgroundcolor') ?: '#EBF5FF',
        'text' => get_config('theme_ufpel', 'textcolor') ?: '#212529',
        'texthighlight' => get_config('theme_ufpel', 'texthighlightcolor') ?: '#FFFFFF'
    ];
}