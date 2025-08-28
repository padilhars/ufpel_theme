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
 * Definição de hooks do tema UFPel para Moodle 5.x
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Array de callbacks de hooks para o tema UFPel
$callbacks = [
    // Hook para adicionar conteúdo ao head HTML
    [
        'hook' => \core\hook\output\before_standard_head_html_generation::class,
        'callback' => [\theme_ufpel\hooks::class, 'before_standard_head_html_generation'],
        'priority' => 100, // Prioridade padrão
    ],
    
    // Hook para adicionar conteúdo ao footer HTML
    [
        'hook' => \core\hook\output\before_standard_footer_html_generation::class,
        'callback' => [\theme_ufpel\hooks::class, 'before_standard_footer_html_generation'],
        'priority' => 100,
    ],
    
    // Hook para inicializar antes dos headers HTTP
    [
        'hook' => \core\hook\output\before_http_headers::class,
        'callback' => [\theme_ufpel\hooks::class, 'before_http_headers'],
        'priority' => 100,
    ],
];