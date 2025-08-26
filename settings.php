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
 * Configurações administrativas do tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Categoria principal de configurações.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingufpel', get_string('configtitle', 'theme_ufpel'));
    
    // ============================
    // TAB 1: Configurações Gerais
    // ============================
    $page = new admin_settingpage('theme_ufpel_general', get_string('generalsettings', 'theme_ufpel'));
    
    // Seletor de preset.
    $name = 'theme_ufpel/preset';
    $title = get_string('preset', 'theme_ufpel');
    $description = get_string('preset_desc', 'theme_ufpel');
    $default = 'default.scss';
    $choices = [
        'default.scss' => get_string('preset_default', 'theme_ufpel'),
        'dark.scss' => get_string('preset_dark', 'theme_ufpel'),
        'highcontrast.scss' => get_string('preset_highcontrast', 'theme_ufpel')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);
    
    // Largura do container.
    $name = 'theme_ufpel/containerwidth';
    $title = get_string('containerwidth', 'theme_ufpel');
    $description = get_string('containerwidth_desc', 'theme_ufpel');
    $default = '1200px';
    $choices = [
        '1140px' => '1140px (Padrão Bootstrap)',
        '1200px' => '1200px (Recomendado)',
        '1320px' => '1320px (Largo)',
        '1400px' => '1400px (Extra largo)',
        '100%' => '100% (Largura total)'
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);
    
    // Toggle de modo escuro.
    $name = 'theme_ufpel/darkmodetoggle';
    $title = get_string('darkmodetoggle', 'theme_ufpel');
    $description = get_string('darkmodetoggle_desc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);
    
    // Toggle de alto contraste.
    $name = 'theme_ufpel/highcontrasttoggle';
    $title = get_string('highcontrasttoggle', 'theme_ufpel');
    $description = get_string('highcontrasttoggle_desc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);
    
    $settings->add($page);
    
    // ============================
    // TAB 2: Cores e Tipografia
    // ============================
    $page = new admin_settingpage('theme_ufpel_colors', get_string('colorsettings', 'theme_ufpel'));
    
    // Cor primária.
    $name = 'theme_ufpel/brandcolor';
    $title = get_string('brandcolor', 'theme_ufpel');
    $description = get_string('brandcolor_desc', 'theme_ufpel');
    $default = '#0080FF';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    // Cor secundária.
    $name = 'theme_ufpel/brandsecondary';
    $title = get_string('brandsecondary', 'theme_ufpel');
    $description = get_string('brandsecondary_desc', 'theme_ufpel');
    $default = '#00408F';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    // Cor de fundo.
    $name = 'theme_ufpel/brandbackground';
    $title = get_string('brandbackground', 'theme_ufpel');
    $description = get_string('brandbackground_desc', 'theme_ufpel');
    $default = '#EBF5FF';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    // Cor de destaque.
    $name = 'theme_ufpel/brandaccent';
    $title = get_string('brandaccent', 'theme_ufpel');
    $description = get_string('brandaccent_desc', 'theme_ufpel');
    $default = '#F7A600';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    // Cor de texto primário.
    $name = 'theme_ufpel/textprimary';
    $title = get_string('textprimary', 'theme_ufpel');
    $description = get_string('textprimary_desc', 'theme_ufpel');
    $default = '#000000';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    // Cor de texto secundário.
    $name = 'theme_ufpel/textsecondary';
    $title = get_string('textsecondary', 'theme_ufpel');
    $description = get_string('textsecondary_desc', 'theme_ufpel');
    $default = '#6C6B6B';
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default);
    $page->add($setting);
    
    $settings->add($page);
    
    // ============================
    // TAB 3: Logos e Imagens
    // ============================
    $page = new admin_settingpage('theme_ufpel_images', get_string('imagesettings', 'theme_ufpel'));
    
    // Logo principal.
    $name = 'theme_ufpel/logo';
    $title = get_string('logo', 'theme_ufpel');
    $description = get_string('logo_desc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, 
        ['maxfiles' => 1, 'accepted_types' => ['.svg', '.png', '.jpg', '.jpeg']]);
    $page->add($setting);
    
    // Logo compacto.
    $name = 'theme_ufpel/logocompact';
    $title = get_string('logocompact', 'theme_ufpel');
    $description = get_string('logocompact_desc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logocompact', 0,
        ['maxfiles' => 1, 'accepted_types' => ['.svg', '.png', '.jpg', '.jpeg']]);
    $page->add($setting);
    
    // Favicon.
    $name = 'theme_ufpel/favicon';
    $title = get_string('favicon', 'theme_ufpel');
    $description = get_string('favicon_desc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0,
        ['maxfiles' => 1, 'accepted_types' => ['.ico', '.png', '.svg']]);
    $page->add($setting);
    
    // Imagem de fundo do login.
    $name = 'theme_ufpel/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_ufpel');
    $description = get_string('loginbackgroundimage_desc', 'theme_ufpel');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage', 0,
        ['maxfiles' => 1, 'accepted_types' => ['.jpg', '.jpeg', '.png', '.webp']]);
    $page->add($setting);
    
    $settings->add($page);
    
    // ============================
    // TAB 4: Layout e Navegação
    // ============================
    $page = new admin_settingpage('theme_ufpel_layout', get_string('layoutsettings', 'theme_ufpel'));
    
    // Exibir barra de progresso nos cursos.
    $name = 'theme_ufpel/courseprogressbar';
    $title = get_string('courseprogressbar', 'theme_ufpel');
    $description = get_string('courseprogressbar_desc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);
    
    // Exibir informações do professor no header do curso.
    $name = 'theme_ufpel/showteacherinfo';
    $title = get_string('showteacherinfo', 'theme_ufpel');
    $description = get_string('showteacherinfo_desc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);
    
    // Exibir número de participantes.
    $name = 'theme_ufpel/showparticipantscount';
    $title = get_string('showparticipantscount', 'theme_ufpel');
    $description = get_string('showparticipantscount_desc', 'theme_ufpel');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $page->add($setting);
    
    // Posição da sidebar.
    $name = 'theme_ufpel/sidebarposition';
    $title = get_string('sidebarposition', 'theme_ufpel');
    $description = get_string('sidebarposition_desc', 'theme_ufpel');
    $default = 'left';
    $choices = [
        'left' => get_string('sidebar_left', 'theme_ufpel'),
        'right' => get_string('sidebar_right', 'theme_ufpel')
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);
    
    $settings->add($page);
    
    // ============================
    // TAB 5: CSS Customizado
    // ============================
    $page = new admin_settingpage('theme_ufpel_advanced', get_string('advancedsettings', 'theme_ufpel'));
    
    // CSS/SCSS customizado.
    $name = 'theme_ufpel/customscss';
    $title = get_string('customscss', 'theme_ufpel');
    $description = get_string('customscss_desc', 'theme_ufpel');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    
    $settings->add($page);
}