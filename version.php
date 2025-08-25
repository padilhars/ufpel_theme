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
 * Theme UFPel version file.
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2025082500; // YYYYMMDDXX format.
$plugin->requires  = 2025041400; // Moodle 5.0.0 (Build: 20250414).
$plugin->supported = [500, 500]; // Moodle 5.0.x branch only.
$plugin->component = 'theme_ufpel';
$plugin->release   = '1.0.0';
$plugin->maturity  = MATURITY_STABLE;

// Dependencies.
$plugin->dependencies = [
    'theme_boost' => 2025041400, // Requires Boost theme from Moodle 5.0.
];