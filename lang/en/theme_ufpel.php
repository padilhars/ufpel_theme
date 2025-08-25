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
 * Language strings for UFPel theme (English - Fallback).
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Plugin information.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'Official theme of the Federal University of Pelotas (UFPel) based on Boost for Moodle 5.0+. This theme provides a modern and responsive visual identity, optimized for UFPel\'s educational experience.';

// General settings.
$string['generalsettings'] = 'General Settings';
$string['generalsettingsdesc'] = 'Configure basic UFPel theme options, including logo and favicon.';

// Logo settings.
$string['logo'] = 'Institution Logo';
$string['logodesc'] = 'Upload the UFPel logo. The logo will be displayed in the navigation header. A 50x50 pixel image or similar is recommended.';

// Favicon settings.
$string['favicon'] = 'Favicon';
$string['favicondesc'] = 'Upload a custom favicon. The favicon will appear in the browser tab and bookmarks. A 32x32 pixel .ico file is recommended.';

// Color settings.
$string['colorsettings'] = 'Color Settings';
$string['colorsettingsdesc'] = 'Customize theme colors according to UFPel\'s visual identity.';

$string['primarycolor'] = 'Primary Color';
$string['primarycolordesc'] = 'UFPel\'s main color. Default: #00408F (UFPel blue).';

$string['secondarycolor'] = 'Secondary Color';
$string['secondarycolordesc'] = 'Complementary secondary color. Default: #0080FF (light blue).';

$string['accentcolor'] = 'Accent Color';
$string['accentcolordesc'] = 'Color used for highlights and action elements. Default: #F7A600 (orange).';

$string['backgroundcolor'] = 'Background Color';
$string['backgroundcolordesc'] = 'Main background color of the theme. Default: #EBF5FF (very light blue).';

$string['textcolor'] = 'Text Color';
$string['textcolordesc'] = 'Primary text color. Default: #212529 (dark gray).';

$string['texthighlightcolor'] = 'Highlighted Text Color';
$string['texthighlightcolordesc'] = 'Text color on dark backgrounds. Default: #FFFFFF (white).';

// Course settings.
$string['coursesettings'] = 'Course Settings';
$string['coursesettingsdesc'] = 'Configure course header display and related information.';

$string['courseheaderoverlay'] = 'Course Header Overlay';
$string['courseheaderoverlaydesc'] = 'Adds a dark overlay over the header background image to improve text readability.';

$string['showcourseimage'] = 'Show Course Image';
$string['showcourseimagedesc'] = 'Displays the course background image in the header. If disabled, a simple header will be used.';

$string['showcourseteachers'] = 'Show Course Teachers';
$string['showcourseteachersdesc'] = 'Displays course teachers in the header, including photo and name.';

$string['showcourseparticipants'] = 'Show Number of Participants';
$string['showcourseparticipantsdesc'] = 'Displays the total number of participants enrolled in the course.';

// Advanced settings.
$string['advancedsettings'] = 'Advanced Settings';
$string['advancedsettingsdesc'] = 'Advanced settings for experienced developers and administrators.';

$string['rawscsspre'] = 'Initial SCSS';
$string['rawscsspredesc'] = 'Use this field to define SCSS variables or include SCSS code that should be processed before the theme\'s main SCSS.';

$string['rawscss'] = 'Additional SCSS';
$string['rawscssdesc'] = 'Use this field to add custom SCSS code that will be applied to the theme.';

$string['preset'] = 'Theme Preset';
$string['presetdesc'] = 'Choose a preset to dramatically change the theme\'s appearance. You can create and upload your own presets.';

// Performance settings.
$string['performancesettings'] = 'Performance Settings';
$string['performancesettingsdesc'] = 'Configure options to optimize performance and user experience.';

$string['enablelazyloading'] = 'Enable Lazy Loading';
$string['enablelazyloadingdesc'] = 'Enables lazy loading for images, improving page loading speed.';

$string['enableparallax'] = 'Enable Parallax Effect';
$string['enableparallaxdesc'] = 'Enables parallax effect in course headers. Can be disabled on mobile devices for better performance.';

$string['enabledarkmode'] = 'Dark Mode Support';
$string['enabledarkmodedesc'] = 'Enables automatic dark mode support based on user\'s system preference.';

// Navigation and branding strings.
$string['home'] = 'Home';
$string['gotohome'] = 'Go to homepage';
$string['ufpellogo'] = 'UFPel Logo';
$string['ufpelfullname'] = 'Federal University of Pelotas';
$string['ufpelshort'] = 'UFPel';
$string['navbarbrandinfo'] = 'Navigation brand for';

// Course header strings.
$string['teachers'] = 'Teachers';
$string['participants'] = 'Participants';
$string['progress'] = 'Progress';

// Footer strings.
$string['footerlinks'] = 'Footer Links';
$string['aboutufpel'] = 'About UFPel';
$string['contact'] = 'Contact';
$string['help'] = 'Help';
$string['support'] = 'Support';
$string['privacy'] = 'Privacy';
$string['accessibility'] = 'Accessibility';

// Error messages.
$string['confignotfound'] = 'Configuration not found for: {$a}';
$string['logonotfound'] = 'Logo not found. Check if the file was uploaded correctly.';
$string['faviconnotfound'] = 'Favicon not found. Check if the file was uploaded correctly.';

// Accessibility strings.
$string['skiptomaincontent'] = 'Skip to main content';
$string['skiptonavigation'] = 'Skip to navigation';
$string['skiptocoursecontent'] = 'Skip to course content';

// Theme customization strings.
$string['customcss'] = 'Custom CSS';
$string['customcssdesc'] = 'Add your own custom CSS to adjust the theme as needed.';

$string['customjs'] = 'Custom JavaScript';
$string['customjsdesc'] = 'Add custom JavaScript code. Use carefully and test well before applying in production.';

// Course format enhancements.
$string['coursecategory'] = 'Course Category';
$string['coursecode'] = 'Course Code';
$string['courseduration'] = 'Course Duration';
$string['courselanguage'] = 'Course Language';

// Card component strings.
$string['viewcourse'] = 'View Course';
$string['enrollincourse'] = 'Enroll in Course';
$string['courseinfo'] = 'Course Information';

// Mobile specific strings.
$string['mobilemenu'] = 'Mobile Menu';
$string['closemenu'] = 'Close Menu';
$string['openmenu'] = 'Open Menu';

// Social media and external links.
$string['ufpelwebsite'] = 'UFPel Website';
$string['ufpelfacebook'] = 'UFPel on Facebook';
$string['ufpelinstagram'] = 'UFPel on Instagram';
$string['ufpelyoutube'] = 'UFPel on YouTube';

// Status messages.
$string['themeupdated'] = 'UFPel theme updated successfully.';
$string['settingssaved'] = 'Settings saved successfully.';
$string['cacherefreshed'] = 'Theme cache updated.';

// Developer and debug strings.
$string['debugmode'] = 'Debug Mode';
$string['debugmodedesc'] = 'Enables debug information for developers. Do not use in production.';

$string['themeversioninfo'] = 'UFPel Theme Version: {$a}';
$string['moodleversionrequired'] = 'This theme requires Moodle 5.0 or higher.';

// Privacy and GDPR compliance.
$string['privacy:metadata'] = 'The UFPel theme does not store any personal user data.';
$string['privacy:metadata:preference:darkmode'] = 'The user\'s preference for dark/light mode.';

// Region names for block placement.
$string['region-side-pre'] = 'Left Side';
$string['region-side-post'] = 'Right Side';
$string['region-content'] = 'Content';
$string['region-footer'] = 'Footer';

// Loading and status indicators.
$string['loading'] = 'Loading...';
$string['loadingcourse'] = 'Loading course...';
$string['noimage'] = 'No image available';
$string['defaultimage'] = 'Default image';