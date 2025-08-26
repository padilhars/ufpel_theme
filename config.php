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
 * Configuração do tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Nome do tema.
$THEME->name = 'ufpel';

// Herda todas as configurações do tema Boost.
$THEME->parents = ['boost'];

// Habilita o dock (painel lateral de blocos).
$THEME->enable_dock = false;

// Usa renderizadores customizados.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Folhas de estilo SCSS para compilar.
$THEME->scss = function($theme) {
    return theme_ufpel_get_main_scss_content($theme);
};

// Função para pré-compilar SCSS adicional.
$THEME->prescsscallback = 'theme_ufpel_get_pre_scss';

// Função para SCSS extra após a compilação principal.
$THEME->extrascsscallback = 'theme_ufpel_get_extra_scss';

// Presets disponíveis para o tema.
$THEME->presetfiles = [
    'default' => 'default.scss',
    'dark' => 'dark.scss',
    'highcontrast' => 'highcontrast.scss',
];

// Usar cache de strings de idioma.
$THEME->langsheets = false;

// Editor de texto específico do tema (herda do Boost).
$THEME->editor_css_url = '';

// Áreas onde arquivos podem ser enviados.
$THEME->editor_sheets = [];

// Habilita o modo de designer (desenvolvimento).
$THEME->hidefromselector = false;

// Adiciona classes CSS ao body baseadas em contexto.
$THEME->bodyclasses = function($classes) {
    global $PAGE, $USER;
    
    // Adiciona classe para modo escuro se ativado.
    if (get_user_preferences('theme_ufpel_darkmode', false)) {
        $classes[] = 'theme-dark-mode';
    }
    
    // Adiciona classe para alto contraste se ativado.
    if (get_user_preferences('theme_ufpel_highcontrast', false)) {
        $classes[] = 'theme-high-contrast';
    }
    
    return $classes;
};

// Configurações de layout herdadas do Boost.
$THEME->layouts = [];

// Regiões de blocos herdadas do Boost.
$THEME->blockregions = [];

// Posições padrão dos blocos herdadas do Boost.
$THEME->defaultblockregions = [];

// Ícones do sistema (usa os do Boost).
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

// Habilita as configurações do tema no painel administrativo.
$THEME->usescourseindex = true;

// Adiciona classes adicionais ao HTML.
$THEME->htmlattributes = [];

// Requer JavaScript para funcionar corretamente.
$THEME->requiredblocks = '';

// Habilita o carregamento de fontes externas.
$THEME->usefallback = true;