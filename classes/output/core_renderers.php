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
 * Renderer principal do tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_ufpel\output;

defined('MOODLE_INTERNAL') || die();

use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use paging_bar;
use context_course;
use pix_icon;

/**
 * Renderizador principal estendendo o tema Boost
 */
class core_renderer extends \theme_boost\output\core_renderer {
    
    /**
     * Renderiza o logo/brand da navbar
     *
     * @return string HTML
     */
    public function render_navbar_brand() {
        global $CFG, $SITE;
        
        $template = new stdClass();
        
        // Nome e URL do site.
        $template->sitename = format_string($SITE->shortname);
        $template->siteurl = $CFG->wwwroot;
        
        // URLs dos logos.
        $logourl = theme_ufpel_get_logo_url('logo', $this->page->theme);
        $logocompacturl = theme_ufpel_get_logo_url('logocompact', $this->page->theme);
        
        if ($logourl) {
            $template->logourl = $logourl->out();
            $template->haslogo = true;
        }
        
        if ($logocompacturl) {
            $template->logocompacturl = $logocompacturl->out();
            $template->haslogocompact = true;
        }
        
        // Indicadores de ambiente.
        if (debugging('', DEBUG_DEVELOPER)) {
            $template->isdevelopment = true;
        }
        
        if (strpos($CFG->wwwroot, 'test') !== false || 
            strpos($CFG->wwwroot, 'homolog') !== false) {
            $template->istest = true;
        }
        
        return $this->render_from_template('theme_ufpel/navbar_brand', $template);
    }
    
    /**
     * Renderiza o footer customizado
     *
     * @return string HTML
     */
    public function render_footer() {
        global $CFG, $SITE, $USER, $DB;
        
        $template = new stdClass();
        
        // Informações básicas.
        $template->sitename = format_string($SITE->fullname);
        $template->year = date('Y');
        $template->homeurl = $CFG->wwwroot;
        $template->loginurl = new moodle_url('/login/index.php');
        
        // Logo do footer.
        $footerlogourl = theme_ufpel_get_logo_url('logocompact', $this->page->theme);
        if ($footerlogourl) {
            $template->footerlogourl = $footerlogourl->out();
            $template->hasfooterlogo = true;
        }
        
        // Informações de login.
        $template->showlogininfo = true;
        $template->isloggedin = isloggedin() && !isguestuser();
        
        if ($template->isloggedin) {
            $template->userfullname = fullname($USER);
            $template->logouturl = new moodle_url('/login/logout.php', 
                ['sesskey' => sesskey()]);
        }
        
        // Versão do Moodle.
        $template->release = $CFG->release;
        
        return $this->render_from_template('theme_ufpel/footer', $template);
    }
    
    /**
     * Renderiza o header customizado do curso
     *
     * @param int $courseid ID do curso
     * @return string HTML
     */
    public function render_course_header($courseid = null) {
        global $CFG, $COURSE, $USER, $DB;
        
        if (!$courseid) {
            $courseid = $COURSE->id;
        }
        
        if ($courseid == SITEID) {
            return ''; // Não renderiza header na página inicial.
        }
        
        $course = get_course($courseid);
        $context = context_course::instance($courseid);
        
        $template = new stdClass();
        
        // Informações básicas do curso.
        $template->courseid = $course->id;
        $template->coursename = format_string($course->fullname);
        $template->courseshortname = format_string($course->shortname);
        $template->courseurl = new moodle_url('/course/view.php', ['id' => $courseid]);
        
        // Categoria.
        $category = $DB->get_record('course_categories', ['id' => $course->category]);
        if ($category) {
            $template->coursecategory = format_string($category->name);
            $template->categoryurl = new moodle_url('/course/index.php', 
                ['categoryid' => $category->id]);
        }
        
        // Resumo do curso.
        if (!empty($course->summary)) {
            $template->coursesummary = format_text($course->summary, 
                $course->summaryformat, ['para' => false]);
            // Limita a 150 caracteres.
            if (strlen($template->coursesummary) > 150) {
                $template->coursesummary = substr($template->coursesummary, 0, 150) . '...';
            }
        }
        
        // Imagem do curso.
        $courseimage = \core_course\external\course_summary_exporter::get_course_image($course);
        if ($courseimage) {
            $template->courseimage = $courseimage;
            $template->hascourseimage = true;
        }
        
        // Professores do curso.
        $teachers = [];
        $roleteacher = $DB->get_record('role', ['shortname' => 'editingteacher']);
        
        if ($roleteacher) {
            $teacherslist = get_role_users($roleteacher->id, $context, false, 
                'u.id, u.firstname, u.lastname, u.picture, u.imagealt, u.email');
            
            foreach ($teacherslist as $teacher) {
                $teacherdata = new stdClass();
                $teacherdata->id = $teacher->id;
                $teacherdata->fullname = fullname($teacher);
                $teacherdata->profileurl = new moodle_url('/user/profile.php', 
                    ['id' => $teacher->id]);
                $teacherdata->pictureurl = new moodle_url('/user/pix.php/' . 
                    $teacher->id . '/f2.jpg');
                
                $teachers[] = $teacherdata;
            }
        }
        
        if (!empty($teachers)) {
            $template->teachers = array_slice($teachers, 0, 3); // Máximo 3 professores.
            $template->hasteachers = true;
            
            if (count($teachers) > 1) {
                $template->multipleTeachers = true;
                $template->additionalTeachersCount = count($teachers) - 1;
            }
        }
        
        // Número de participantes.
        if (get_config('theme_ufpel', 'showparticipantscount')) {
            $participants = count_enrolled_users($context);
            $template->participantscount = $participants;
            $template->showparticipants = true;
        }
        
        // Progresso do curso (se módulo de completion estiver ativo).
        if (get_config('theme_ufpel', 'courseprogressbar')) {
            $completioninfo = new \completion_info($course);
            
            if ($completioninfo->is_enabled() && $completioninfo->is_tracked_user($USER->id)) {
                $progressdata = $completioninfo->get_progress_all();
                $progress = \core_completion\progress::get_course_progress_percentage($course, $USER->id);
                
                if ($progress !== null) {
                    $template->progress = round($progress);
                    $template->showprogress = true;
                    
                    if ($template->progress == 100) {
                        $template->iscomplete = true;
                    }
                }
            }
        }
        
        // Datas de inscrição e último acesso.
        $enrolment = $DB->get_record_sql(
            "SELECT ue.timestart, ue.timeend 
             FROM {user_enrolments} ue 
             JOIN {enrol} e ON e.id = ue.enrolid 
             WHERE e.courseid = ? AND ue.userid = ? 
             ORDER BY ue.timestart ASC 
             LIMIT 1",
            [$courseid, $USER->id]
        );
        
        if ($enrolment && $enrolment->timestart) {
            $template->enrollmentdate = userdate($enrolment->timestart, 
                get_string('strftimedatefullshort'));
        }
        
        $lastaccess = $DB->get_field('user_lastaccess', 'timeaccess', 
            ['courseid' => $courseid, 'userid' => $USER->id]);
        
        if ($lastaccess) {
            $template->lastaccess = userdate($lastaccess, 
                get_string('strftimedatefullshort'));
        }
        
        return $this->render_from_template('theme_ufpel/course_header', $template);
    }
    
    /**
     * Renderiza cards de curso customizados
     *
     * @param array $courses Array de cursos
     * @return string HTML
     */
    public function render_course_cards($courses = []) {
        global $CFG, $USER, $DB;
        
        $template = new stdClass();
        
        if (empty($courses)) {
            $template->nocourses = true;
        } else {
            $coursesdata = [];
            
            foreach ($courses as $course) {
                $coursedata = new stdClass();
                $context = context_course::instance($course->id);
                
                // Informações básicas.
                $coursedata->id = $course->id;
                $coursedata->fullname = format_string($course->fullname);
                $coursedata->shortname = format_string($course->shortname);
                $coursedata->viewurl = new moodle_url('/course/view.php', 
                    ['id' => $course->id]);
                
                // Categoria.
                $category = $DB->get_record('course_categories', 
                    ['id' => $course->category]);
                if ($category) {
                    $coursedata->category = format_string($category->name);
                    $coursedata->categoryid = $category->id;
                    $coursedata->categoryurl = new moodle_url('/course/index.php', 
                        ['categoryid' => $category->id]);
                }
                
                // Visibilidade.
                $coursedata->visible = $course->visible;
                if (!$course->visible) {
                    $coursedata->hidden = true;
                }
                
                // Imagem do curso.
                $courseimage = \core_course\external\course_summary_exporter::get_course_image($course);
                if ($courseimage) {
                    $coursedata->imageurl = $courseimage;
                    $coursedata->hasimage = true;
                }
                
                // Resumo (limitado).
                if (!empty($course->summary)) {
                    $summary = format_text($course->summary, $course->summaryformat, 
                        ['para' => false]);
                    $summary = strip_tags($summary);
                    if (strlen($summary) > 100) {
                        $summary = substr($summary, 0, 100) . '...';
                    }
                    $coursedata->summary = $summary;
                }
                
                // Verifica se está inscrito.
                $coursedata->enrolled = is_enrolled($context, $USER->id, '', true);
                
                // Progresso (se inscrito).
                if ($coursedata->enrolled) {
                    $completioninfo = new \completion_info($course);
                    
                    if ($completioninfo->is_enabled() && 
                        $completioninfo->is_tracked_user($USER->id)) {
                        $progress = \core_completion\progress::get_course_progress_percentage(
                            $course, $USER->id);
                        
                        if ($progress !== null) {
                            $coursedata->progress = round($progress);
                            $coursedata->hasprogress = true;
                            
                            if ($coursedata->progress == 100) {
                                $coursedata->completed = true;
                            }
                        }
                    }
                }
                
                // Professores.
                $roleteacher = $DB->get_record('role', ['shortname' => 'editingteacher']);
                if ($roleteacher) {
                    $teachers = get_role_users($roleteacher->id, $context, false, 
                        'u.firstname, u.lastname', 'u.lastname ASC');
                    
                    $teachernames = [];
                    foreach (array_slice($teachers, 0, 2) as $teacher) {
                        $teachernames[] = fullname($teacher);
                    }
                    
                    if (!empty($teachernames)) {
                        $coursedata->teachers = $teachernames;
                    }
                }
                
                // Datas.
                if ($course->startdate) {
                    $coursedata->startdate = userdate($course->startdate, 
                        get_string('strftimedateshort'));
                }
                
                if ($course->enddate) {
                    $coursedata->enddate = userdate($course->enddate, 
                        get_string('strftimedateshort'));
                }
                
                // Favorito (se plugin disponível).
                if (class_exists('\core_favourites\local\entity\favourite')) {
                    $ufservice = \core_favourites\service_factory::get_service_for_user_context(
                        \context_user::instance($USER->id));
                    $coursedata->favourite = $ufservice->favourite_exists('core_course', 
                        'courses', $course->id, $context);
                }
                
                $coursesdata[] = $coursedata;
            }
            
            $template->courses = $coursesdata;
        }
        
        return $this->render_from_template('theme_ufpel/course_cards', $template);
    }
    
    /**
     * Override do método standard_end_of_body_html para incluir scripts customizados
     *
     * @return string HTML
     */
    public function standard_end_of_body_html() {
        $output = parent::standard_end_of_body_html();
        
        // Adiciona widget VLibras se configurado.
        if (get_config('theme_ufpel', 'vlibras')) {
            $output .= html_writer::script('', 
                'https://vlibras.gov.br/app/vlibras-plugin.js');
            $output .= html_writer::script('new window.VLibras.Widget();');
        }
        
        return $output;
    }
}
