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
 * English language strings for UFPel theme (fallback)
 *
 * @package    theme_ufpel
 * @copyright  2025 Federal University of Pelotas
 * @author     Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// General strings.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'UFPel Theme - A modern and responsive theme for the Federal University of Pelotas, based on Moodle 5.x Boost theme.';
$string['configtitle'] = 'UFPel theme settings';
$string['region-side-pre'] = 'Left';

// General settings.
$string['generalsettings'] = 'General Settings';
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';
$string['preset_default'] = 'UFPel Default';
$string['preset_dark'] = 'Dark Mode';
$string['preset_highcontrast'] = 'High Contrast';

$string['containerwidth'] = 'Container width';
$string['containerwidth_desc'] = 'Set the maximum width of the main content area.';

$string['darkmodetoggle'] = 'Enable dark mode toggle';
$string['darkmodetoggle_desc'] = 'Allow users to switch between light and dark modes.';

$string['highcontrasttoggle'] = 'Enable high contrast mode';
$string['highcontrasttoggle_desc'] = 'Allow users to enable high contrast mode for better accessibility.';

// Color settings.
$string['colorsettings'] = 'Colors & Typography';
$string['brandcolor'] = 'Primary color';
$string['brandcolor_desc'] = 'The primary UFPel brand color. Default: #0080FF';

$string['brandsecondary'] = 'Secondary color';
$string['brandsecondary_desc'] = 'The secondary UFPel brand color. Default: #00408F';

$string['brandbackground'] = 'Background color';
$string['brandbackground_desc'] = 'Main background color. Default: #EBF5FF';

$string['brandaccent'] = 'Accent color';
$string['brandaccent_desc'] = 'Color used for accent elements. Default: #F7A600';

$string['textprimary'] = 'Primary text color';
$string['textprimary_desc'] = 'Primary text color. Default: #000000';

$string['textsecondary'] = 'Secondary text color';
$string['textsecondary_desc'] = 'Secondary text color. Default: #6C6B6B';

// Image settings.
$string['imagesettings'] = 'Logos & Images';
$string['logo'] = 'Main logo';
$string['logo_desc'] = 'Upload the main UFPel logo. Recommended: SVG or PNG with transparent background.';

$string['logocompact'] = 'Compact logo';
$string['logocompact_desc'] = 'Compact logo for reduced spaces. Used when navigation is collapsed.';

$string['favicon'] = 'Favicon';
$string['favicon_desc'] = 'Icon displayed in browser tab. Accepted formats: .ico, .png or .svg';

$string['loginbackgroundimage'] = 'Login background image';
$string['loginbackgroundimage_desc'] = 'Background image for the login page. Recommended: high quality image (1920x1080 or higher).';

// Layout settings.
$string['layoutsettings'] = 'Layout & Navigation';
$string['courseprogressbar'] = 'Show course progress bar';
$string['courseprogressbar_desc'] = 'Display a progress bar in course headers showing completion percentage.';

$string['showteacherinfo'] = 'Show teacher information';
$string['showteacherinfo_desc'] = 'Display teacher name and photo in course header.';

$string['showparticipantscount'] = 'Show participants count';
$string['showparticipantscount_desc'] = 'Display the number of enrolled participants in the course.';

$string['sidebarposition'] = 'Sidebar position';
$string['sidebarposition_desc'] = 'Set the position of the navigation and blocks sidebar.';
$string['sidebar_left'] = 'Left';
$string['sidebar_right'] = 'Right';

// Advanced settings.
$string['advancedsettings'] = 'Custom CSS';
$string['customscss'] = 'Custom CSS/SCSS';
$string['customscss_desc'] = 'Add custom CSS or SCSS code. This code will be applied after all other theme styles.';

// Interface messages.
$string['toggledarkmode'] = 'Toggle dark mode';
$string['togglehighcontrast'] = 'Toggle high contrast';
$string['courseprogress'] = 'Course progress';
$string['participants'] = 'Participants';
$string['teacher'] = 'Teacher';
$string['teachers'] = 'Teachers';

// Footer.
$string['footertext'] = 'Federal University of Pelotas';
$string['copyright'] = '© {$a} UFPel - All rights reserved';

// Accessibility.
$string['accessibility'] = 'Accessibility';
$string['skiptomaincontent'] = 'Skip to main content';
$string['vlibras'] = 'Libras Translator';

// Error messages.
$string['error:failedtoloadpreset'] = 'Failed to load selected preset. Using default preset.';
$string['error:invalidcolor'] = 'Invalid color provided. Using default color.';

// Strings for templates
$string['home'] = 'Home';
$string['courses'] = 'Courses';
$string['myhome'] = 'My Dashboard';
$string['calendar'] = 'Calendar';
$string['quicklinks'] = 'Quick Links';
$string['support'] = 'Support';
$string['help'] = 'Help';
$string['contactus'] = 'Contact';
$string['followus'] = 'Follow us';
$string['privacypolicy'] = 'Privacy Policy';
$string['termsofuse'] = 'Terms of Use';
$string['cookiepolicy'] = 'Cookie Policy';
$string['loggedinas'] = 'You are logged in as';
$string['notloggedin'] = 'You are not logged in';
$string['login'] = 'Log in';
$string['logout'] = 'Log out';
$string['fontsize'] = 'Font size';
$string['decreasefont'] = 'Decrease font';
$string['resetfont'] = 'Reset font';
$string['increasefont'] = 'Increase font';
$string['coursecategory'] = 'Course category';
$string['breadcrumb'] = 'Breadcrumb navigation';
$string['grades'] = 'Grades';
$string['enrolledon'] = 'Enrolled in';
$string['lastaccess'] = 'Last access';
$string['coursecompleted'] = 'Course completed';
$string['progressnotavailable'] = 'Progress not available';
$string['others'] = 'others';
$string['nocourses'] = 'No courses available';
$string['favorite'] = 'Favorite';
$string['completed'] = 'Completed';
$string['hidden'] = 'Hidden';
$string['startdate'] = 'Start date';
$string['enddate'] = 'End date';
$string['progress'] = 'Progress';
$string['entercourse'] = 'Enter course';
$string['moreinfo'] = 'More information';
