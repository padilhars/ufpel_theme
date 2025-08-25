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
 * Theme UFPel settings page.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // General Settings Tab.
    $settings->add(new admin_setting_heading(
        'theme_ufpel/generalsettings',
        get_string('generalsettings', 'theme_ufpel'),
        get_string('generalsettingsdesc', 'theme_ufpel')
    ));

    // Logo setting.
    $name = 'theme_ufpel/logo';
    $title = get_string('logo', 'theme_ufpel');
    $description = get_string('logodesc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Favicon setting.
    $name = 'theme_ufpel/favicon';
    $title = get_string('favicon', 'theme_ufpel');
    $description = get_string('favicondesc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Color Settings Tab.
    $settings->add(new admin_setting_heading(
        'theme_ufpel/colorsettings',
        get_string('colorsettings', 'theme_ufpel'),
        get_string('colorsettingsdesc', 'theme_ufpel')
    ));

    // Primary color.
    $name = 'theme_ufpel/primarycolor';
    $title = get_string('primarycolor', 'theme_ufpel');
    $description = get_string('primarycolordesc', 'theme_ufpel');
    $default = '#00408F';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Secondary color.
    $name = 'theme_ufpel/secondarycolor';
    $title = get_string('secondarycolor', 'theme_ufpel');
    $description = get_string('secondarycolordesc', 'theme_ufpel');
    $default = '#0080FF';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Accent color.
    $name = 'theme_ufpel/accentcolor';
    $title = get_string('accentcolor', 'theme_ufpel');
    $description = get_string('accentcolordesc', 'theme_ufpel');
    $default = '#F7A600';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Background color.
    $name = 'theme_ufpel/backgroundcolor';
    $title = get_string('backgroundcolor', 'theme_ufpel');
    $description = get_string('backgroundcolordesc', 'theme_ufpel');
    $default = '#EBF5FF';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Text color.
    $name = 'theme_ufpel/textcolor';
    $title = get_string('textcolor', 'theme_ufpel');
    $description = get_string('textcolordesc', 'theme_ufpel');
    $default = '#212529';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Text highlight color.
    $name = 'theme_ufpel/texthighlightcolor';
    $title = get_string('texthighlightcolor', 'theme_ufpel');
    $description = get_string('texthighlightcolordesc', 'theme_ufpel');
    $default = '#FFFFFF';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Course Settings Tab.
    $settings->add(new admin_setting_heading(
        'theme_ufpel/coursesettings',
        get_string('coursesettings', 'theme_ufpel'),
        get_string('coursesettingsdesc', 'theme_ufpel')
    ));

    // Course header overlay.
    $name = 'theme_ufpel/courseheaderoverlay';
    $title = get_string('courseheaderoverlay', 'theme_ufpel');
    $description = get_string('courseheaderoverlaydesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Show course image.
    $name = 'theme_ufpel/showcourseimage';
    $title = get_string('showcourseimage', 'theme_ufpel');
    $description = get_string('showcourseimagedesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Show course teachers.
    $name = 'theme_ufpel/showcourseteachers';
    $title = get_string('showcourseteachers', 'theme_ufpel');
    $description = get_string('showcourseteachersdesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Show course participants.
    $name = 'theme_ufpel/showcourseparticipants';
    $title = get_string('showcourseparticipants', 'theme_ufpel');
    $description = get_string('showcourseparticipantsdesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Advanced Settings Tab.
    $settings->add(new admin_setting_heading(
        'theme_ufpel/advancedsettings',
        get_string('advancedsettings', 'theme_ufpel'),
        get_string('advancedsettingsdesc', 'theme_ufpel')
    ));

    // Raw SCSS before.
    $name = 'theme_ufpel/scsspre';
    $title = get_string('rawscsspre', 'theme_ufpel');
    $description = get_string('rawscsspredesc', 'theme_ufpel');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Raw SCSS after.
    $name = 'theme_ufpel/scss';
    $title = get_string('rawscss', 'theme_ufpel');
    $description = get_string('rawscssdesc', 'theme_ufpel');
    $default = '';
    $setting = new admin_setting_scsscode($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Preset files setting.
    $name = 'theme_ufpel/preset';
    $title = get_string('preset', 'theme_ufpel');
    $description = get_string('presetdesc', 'theme_ufpel');
    $default = 'default.scss';
    
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_ufpel', 'preset', 0, 'itemid, filepath, filename', false);
    
    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // Always offer the default preset.
    $choices['default.scss'] = 'default.scss';
    
    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'ufpel');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Performance Settings Tab.
    $settings->add(new admin_setting_heading(
        'theme_ufpel/performancesettings',
        get_string('performancesettings', 'theme_ufpel'),
        get_string('performancesettingsdesc', 'theme_ufpel')
    ));

    // Enable lazy loading.
    $name = 'theme_ufpel/enablelazyloading';
    $title = get_string('enablelazyloading', 'theme_ufpel');
    $description = get_string('enablelazyloadingdesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Enable parallax effect.
    $name = 'theme_ufpel/enableparallax';
    $title = get_string('enableparallax', 'theme_ufpel');
    $description = get_string('enableparallaxdesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Dark mode support.
    $name = 'theme_ufpel/enabledarkmode';
    $title = get_string('enabledarkmode', 'theme_ufpel');
    $description = get_string('enabledarkmodedesc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
}