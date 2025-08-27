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
 * Classe de hooks do tema UFPel para Moodle 5.x
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_ufpel;

defined('MOODLE_INTERNAL') || die();

/**
 * Classe de callbacks de hooks para o tema UFPel
 */
class hooks {
    
    /**
     * Callback para o hook before_standard_head_html_generation
     * Adiciona meta tags e links necessários ao head do HTML
     *
     * @param \core\hook\output\before_standard_head_html_generation $hook
     * @return void
     */
    public static function before_standard_head_html_generation(\core\hook\output\before_standard_head_html_generation $hook): void {
        $output = '';
        
        // Adiciona meta tags para tema responsivo
        $output .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
        $output .= '<meta name="theme-color" content="#0080FF">' . "\n";
        
        // Adiciona tags Open Graph para melhor compartilhamento
        $output .= '<meta property="og:site_name" content="UFPel - Moodle">' . "\n";
        $output .= '<meta property="og:type" content="website">' . "\n";
        
        // Adiciona preconnect para otimizar carregamento de fontes
        $output .= '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        $output .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        
        // Adiciona preload para fontes críticas
        $output .= '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Antonio:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap">' . "\n";
        
        // Adiciona o HTML ao hook
        $hook->add_html($output);
    }
    
    /**
     * Callback para o hook before_standard_footer_html_generation
     * Adiciona scripts e elementos ao final do body
     *
     * @param \core\hook\output\before_standard_footer_html_generation $hook
     * @return void
     */
    public static function before_standard_footer_html_generation(\core\hook\output\before_standard_footer_html_generation $hook): void {
        global $USER;
        
        $output = '';
        
        // Adiciona widget VLibras se configurado e usuário habilitou
        $vlibrasEnabled = get_config('theme_ufpel', 'vlibras') || 
                         get_user_preferences('theme_ufpel_vlibras', false);
        
        if ($vlibrasEnabled) {
            $output .= '<div vw class="enabled">' . "\n";
            $output .= '  <div vw-access-button class="active"></div>' . "\n";
            $output .= '  <div vw-plugin-wrapper>' . "\n";
            $output .= '    <div class="vw-plugin-top-wrapper"></div>' . "\n";
            $output .= '  </div>' . "\n";
            $output .= '</div>' . "\n";
            $output .= '<script src="https://vlibras.gov.br/app/vlibras-plugin.js" defer></script>' . "\n";
            $output .= '<script>window.addEventListener("load", function() { new window.VLibras.Widget("https://vlibras.gov.br/app"); });</script>' . "\n";
        }
        
        // Adiciona script para detecção de preferências do sistema
        $output .= '<script>' . "\n";
        $output .= 'if (window.matchMedia) {' . "\n";
        $output .= '  const darkMode = window.matchMedia("(prefers-color-scheme: dark)");' . "\n";
        $output .= '  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");' . "\n";
        $output .= '  const highContrast = window.matchMedia("(prefers-contrast: high)");' . "\n";
        $output .= '  ' . "\n";
        $output .= '  if (!localStorage.getItem("theme_ufpel_darkmode") && darkMode.matches) {' . "\n";
        $output .= '    document.body.classList.add("theme-dark-mode");' . "\n";
        $output .= '  }' . "\n";
        $output .= '  ' . "\n";
        $output .= '  if (reducedMotion.matches) {' . "\n";
        $output .= '    document.body.classList.add("reduced-motion");' . "\n";
        $output .= '  }' . "\n";
        $output .= '  ' . "\n";
        $output .= '  if (highContrast.matches) {' . "\n";
        $output .= '    document.body.classList.add("prefers-high-contrast");' . "\n";
        $output .= '  }' . "\n";
        $output .= '}' . "\n";
        $output .= '</script>' . "\n";
        
        // Adiciona noscript para usuários sem JavaScript
        $output .= '<noscript>' . "\n";
        $output .= '<style>' . "\n";
        $output .= '.requires-js { display: none !important; }' . "\n";
        $output .= '.no-js-fallback { display: block !important; }' . "\n";
        $output .= '</style>' . "\n";
        $output .= '</noscript>' . "\n";
        
        // Adiciona o HTML ao hook
        $hook->add_html($output);
    }
    
    /**
     * Callback para o hook after_config
     * Inicializa configurações do tema após o Moodle carregar
     *
     * @param \core\hook\after_config $hook
     * @return void
     */
    public static function after_config(\core\hook\after_config $hook): void {
        global $PAGE;
        
        // Esta função será chamada muito cedo no processo de inicialização
        // Use com cuidado - nem todos os subsistemas estarão disponíveis
        
        // Por exemplo, podemos definir configurações padrão aqui
        // mas não podemos acessar $PAGE ainda
    }
    
    /**
     * Callback para page_init
     * Inicializa recursos da página
     *
     * @param \core\hook\output\before_http_headers $hook
     * @return void
     */
    public static function before_http_headers(\core\hook\output\before_http_headers $hook): void {
        global $PAGE, $USER;
        
        // Apenas executa se estivermos usando o tema UFPel
        if ($PAGE->theme->name !== 'ufpel') {
            return;
        }
        
        // Carrega o módulo principal do tema
        $PAGE->requires->js_call_amd('theme_ufpel/theme', 'init', [
            [
                'darkModeEnabled' => get_config('theme_ufpel', 'darkmodetoggle'),
                'highContrastEnabled' => get_config('theme_ufpel', 'highcontrasttoggle'),
                'vLibrasEnabled' => get_config('theme_ufpel', 'vlibras'),
                'animations' => true
            ]
        ]);
        
        // Verifica se o modo escuro está habilitado
        if (get_config('theme_ufpel', 'darkmodetoggle')) {
            $PAGE->requires->js_call_amd('theme_ufpel/darkmode', 'init');
            
            // Adiciona classe ao body se usuário tem preferência salva
            $darkmode = get_user_preferences('theme_ufpel_darkmode', false);
            if ($darkmode) {
                $PAGE->add_body_class('theme-dark-mode');
            }
        }
        
        // Inicializa ferramentas de acessibilidade
        if (get_config('theme_ufpel', 'highcontrasttoggle')) {
            $PAGE->requires->js_call_amd('theme_ufpel/accessibility', 'init');
            
            // Verifica preferência de alto contraste
            $highcontrast = get_user_preferences('theme_ufpel_highcontrast', false);
            if ($highcontrast) {
                $PAGE->add_body_class('high-contrast');
            }
        }
        
        // Adiciona classes contextuais ao body
        self::add_body_classes($PAGE);
    }
    
    /**
     * Adiciona classes contextuais ao body
     *
     * @param \moodle_page $page
     * @return void
     */
    private static function add_body_classes(\moodle_page $page): void {
        global $USER;
        
        // Adiciona classe baseada no tamanho de fonte preferido
        $fontsize = get_user_preferences('theme_ufpel_fontsize', '100');
        if ($fontsize != '100') {
            $page->add_body_class('font-size-' . $fontsize);
        }
        
        // Adiciona classe se VLibras estiver ativo
        if (get_user_preferences('theme_ufpel_vlibras', false)) {
            $page->add_body_class('vlibras-enabled');
        }
        
        // Adiciona classe de contexto do curso
        if ($page->course && $page->course->id != SITEID) {
            $page->add_body_class('in-course');
            $page->add_body_class('course-' . $page->course->id);
        }
        
        // Adiciona classe para dispositivos móveis
        if (\core\output\devices::is_mobile()) {
            $page->add_body_class('is-mobile');
        }
        
        // Adiciona classe para tablet
        if (\core_useragent::is_tablet()) {
            $page->add_body_class('is-tablet');
        }
        
        // Adiciona classe para o modo de configuração do tema
        $page->add_body_class('darkmode-' . (get_config('theme_ufpel', 'darkmodetoggle') ? 'enabled' : 'disabled'));
    }
}
