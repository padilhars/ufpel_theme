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
 * Informações de versão do tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2025120402;    // Versão do tema (YYYYMMDDXX).
$plugin->requires  = 2024100700;    // Requer Moodle 5.0.1+ (Build: 20250613).
$plugin->component = 'theme_ufpel'; // Nome completo do componente.
$plugin->maturity  = MATURITY_STABLE; // Maturidade do código.
$plugin->release   = '1.0.0';       // Versão legível para humanos.

// Dependências do tema.
$plugin->dependencies = [
    'theme_boost' => 2024100700,    // Depende do tema Boost do Moodle 5.x.
];

// Informações adicionais.
$plugin->supported = [50, 51];      // Suporta Moodle 5.0 até 5.1.