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
 * Funções e hooks do tema UFPel (VERSÃO ATUALIZADA - FASE 5)
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Retorna o conteúdo SCSS principal para compilação.
 *
 * @param theme_config $theme O objeto de configuração do tema.
 * @return string O conteúdo SCSS completo.
 */
function theme_ufpel_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    
    // Primeiro, importa o SCSS do tema pai (Boost).
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    
    // Obtém o preset selecionado ou usa o padrão.
    $preset = get_config('theme_ufpel', 'preset');
    if (empty($preset)) {
        $preset = 'default.scss';
    }
    
    // Carrega o arquivo de preset do tema UFPel.
    $presetfile = $CFG->dirroot . '/theme/ufpel/scss/preset/' . $preset;
    if (file_exists($presetfile)) {
        $scss .= file_get_contents($presetfile);
    }
    
    // Adiciona SCSS customizado do post.scss.
    $postscss = file_get_contents($CFG->dirroot . '/theme/ufpel/scss/post.scss');
    if ($postscss) {
        $scss .= $postscss;
    }
    
    return $scss;
}

/**
 * Retorna as variáveis SCSS para pré-processamento.
 *
 * @param theme_config $theme O objeto de configuração do tema.
 * @return string Variáveis SCSS.
 */
function theme_ufpel_get_pre_scss($theme) {
    $scss = '';
    $configurable = [
        // Cores configuráveis.
        'brandcolor' => '#0080FF',
        'brandsecondary' => '#00408F',
        'brandbackground' => '#EBF5FF',
        'brandaccent' => '#F7A600',
        'textprimary' => '#000000',
        'textsecondary' => '#6C6B6B',
        'texthighlight' => '#FFFFFF'
    ];
    
    // Processa cada variável configurável.
    foreach ($configurable as $configkey => $defaultvalue) {
        $value = get_config('theme_ufpel', $configkey);
        if (empty($value)) {
            $value = $defaultvalue;
        }
        $scss .= "\$theme-ufpel-{$configkey}: {$value};\n";
    }
    
    // Adiciona importação das fontes do Google.
    $scss .= '@import url("https://fonts.googleapis.com/css2?family=Antonio:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap");';
    $scss .= "\n";
    
    // Define as famílias de fontes.
    $scss .= '$font-family-content: "DM Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;';
    $scss .= "\n";
    $scss .= '$font-family-headings: "Antonio", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;';
    $scss .= "\n";
    
    // Adiciona configurações de largura do container se definidas.
    $containerwidth = get_config('theme_ufpel', 'containerwidth');
    if (!empty($containerwidth)) {
        $scss .= "\$container-max-width: {$containerwidth};\n";
    }
    
    return $scss;
}

/**
 * Retorna SCSS extra para ser adicionado após o SCSS principal.
 *
 * @param theme_config $theme O objeto de configuração do tema.
 * @return string SCSS adicional.
 */
function theme_ufpel_get_extra_scss($theme) {
    $scss = '';
    
    // Adiciona SCSS customizado inserido pelo administrador.
    $customscss = get_config('theme_ufpel', 'customscss');
    if (!empty($customscss)) {
        $scss .= $customscss;
    }
    
    return $scss;
}

/**
 * Serve arquivos do tema UFPel.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_ufpel_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        return false;
    }
    
    // Áreas de arquivo permitidas.
    $allowedareas = [
        'logo',
        'logocompact',
        'favicon',
        'backgroundimage',
        'loginbackgroundimage'
    ];
    
    if (!in_array($filearea, $allowedareas)) {
        return false;
    }
    
    $fs = get_file_storage();
    $filename = array_pop($args);
    $filepath = '/';
    
    $file = $fs->get_file($context->id, 'theme_ufpel', $filearea, 0, $filepath, $filename);
    if (!$file) {
        return false;
    }
    
    send_stored_file($file, 86400, 0, $forcedownload, $options);
    return true;
}

/**
 * Obtém o URL do ícone do tema.
 *
 * @param string $type Tipo de imagem (logo, logocompact, favicon).
 * @param theme_config $theme
 * @return moodle_url|null
 */
function theme_ufpel_get_logo_url($type = 'logo', $theme = null) {
    global $CFG;
    
    if ($theme === null) {
        $theme = theme_config::load('ufpel');
    }
    
    $setting = get_config('theme_ufpel', $type);
    if (!empty($setting)) {
        $url = moodle_url::make_pluginfile_url(
            context_system::instance()->id,
            'theme_ufpel',
            $type,
            0,
            '/',
            $setting
        );
        return $url;
    }
    
    // Retorna imagem padrão se existir.
    $defaultfile = $CFG->dirroot . '/theme/ufpel/pix/' . $type . '-default.svg';
    if (file_exists($defaultfile)) {
        return new moodle_url('/theme/ufpel/pix/' . $type . '-default.svg');
    }
    
    return null;
}

/**
 * Callback executado após upgrade do tema.
 *
 * @return void
 */
function theme_ufpel_after_upgrade_callback() {
    // Limpa o cache do tema após atualização.
    theme_reset_all_caches();
}

/**
 * Inicializa a página com JavaScript AMD e configurações de acessibilidade.
 *
 * @param moodle_page $page
 * @return void
 */
function theme_ufpel_page_init(moodle_page $page) {
    global $USER;
    
    // Carrega o módulo principal do tema.
    $page->requires->js_call_amd('theme_ufpel/theme', 'init', [
        [
            'darkModeEnabled' => get_config('theme_ufpel', 'darkmodetoggle'),
            'highContrastEnabled' => get_config('theme_ufpel', 'highcontrasttoggle'),
            'vLibrasEnabled' => get_config('theme_ufpel', 'vlibras'),
            'animations' => true
        ]
    ]);
    
    // Verifica se o modo escuro está habilitado.
    if (get_config('theme_ufpel', 'darkmodetoggle')) {
        $page->requires->js_call_amd('theme_ufpel/darkmode', 'init');
        
        // Adiciona classe ao body se usuário tem preferência salva.
        $darkmode = get_user_preferences('theme_ufpel_darkmode', false);
        if ($darkmode) {
            $page->add_body_class('theme-dark-mode');
        }
    }
    
    // Inicializa ferramentas de acessibilidade.
    if (get_config('theme_ufpel', 'highcontrasttoggle')) {
        $page->requires->js_call_amd('theme_ufpel/accessibility', 'init');
        
        // Verifica preferência de alto contraste.
        $highcontrast = get_user_preferences('theme_ufpel_highcontrast', false);
        if ($highcontrast) {
            $page->add_body_class('high-contrast');
        }
    }
    
    // Adiciona dados ao body para JS.
    $page->add_body_class('darkmode-' . (get_config('theme_ufpel', 'darkmodetoggle') ? 'enabled' : 'disabled'));
    
    // Adiciona meta tags para acessibilidade.
    $page->requires->data_for_js('theme_ufpel_config', [
        'darkModeEnabled' => get_config('theme_ufpel', 'darkmodetoggle'),
        'highContrastEnabled' => get_config('theme_ufpel', 'highcontrasttoggle'),
        'courseProgressBar' => get_config('theme_ufpel', 'courseprogressbar'),
        'showTeacherInfo' => get_config('theme_ufpel', 'showteacherinfo'),
        'showParticipantsCount' => get_config('theme_ufpel', 'showparticipantscount')
    ]);
}

/**
 * Adiciona classes CSS ao body baseadas no contexto e preferências.
 *
 * @param array $additionalclasses Array de classes existentes.
 * @return array Array de classes atualizado.
 */
function theme_ufpel_body_classes($additionalclasses) {
    global $PAGE, $USER;
    
    // Adiciona classe para modo escuro se ativado.
    if (get_user_preferences('theme_ufpel_darkmode', false)) {
        $additionalclasses[] = 'theme-dark-mode';
    }
    
    // Adiciona classe para alto contraste se ativado.
    if (get_user_preferences('theme_ufpel_highcontrast', false)) {
        $additionalclasses[] = 'high-contrast';
    }
    
    // Adiciona classe baseada no tamanho de fonte preferido.
    $fontsize = get_user_preferences('theme_ufpel_fontsize', '100');
    if ($fontsize != '100') {
        $additionalclasses[] = 'font-size-' . $fontsize;
    }
    
    // Adiciona classe se VLibras estiver ativo.
    if (get_user_preferences('theme_ufpel_vlibras', false)) {
        $additionalclasses[] = 'vlibras-enabled';
    }
    
    // Adiciona classe de contexto do curso.
    if ($PAGE->course && $PAGE->course->id != SITEID) {
        $additionalclasses[] = 'in-course';
        $additionalclasses[] = 'course-' . $PAGE->course->id;
    }
    
    // Adiciona classe para dispositivos móveis.
    if (core_useragent::is_mobile()) {
        $additionalclasses[] = 'is-mobile';
    }
    
    // Adiciona classe para tablet.
    if (core_useragent::is_tablet()) {
        $additionalclasses[] = 'is-tablet';
    }
    
    return $additionalclasses;
}

/**
 * Retorna HTML para ser adicionado ao final do body.
 *
 * @param renderer_base $renderer
 * @return string HTML a ser adicionado.
 */
function theme_ufpel_before_standard_html_head() {
    $output = '';
    
    // Adiciona meta tags para tema responsivo.
    $output .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $output .= '<meta name="theme-color" content="#0080FF">';
    
    // Adiciona tags Open Graph para melhor compartilhamento.
    $output .= '<meta property="og:site_name" content="UFPel - Moodle">';
    $output .= '<meta property="og:type" content="website">';
    
    // Adiciona preconnect para otimizar carregamento de fontes.
    $output .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
    $output .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // Adiciona preload para fontes críticas.
    $output .= '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Antonio:wght@400;700&family=DM+Sans:wght@400;500;700&display=swap">';
    
    return $output;
}

/**
 * Adiciona scripts e elementos ao final do body.
 *
 * @return string HTML a ser adicionado.
 */
function theme_ufpel_get_extra_footer_html() {
    $output = '';
    
    // Adiciona widget VLibras se configurado e usuário habilitou.
    if (get_config('theme_ufpel', 'vlibras') || get_user_preferences('theme_ufpel_vlibras', false)) {
        $output .= '<div vw class="enabled">';
        $output .= '<div vw-access-button class="active"></div>';
        $output .= '<div vw-plugin-wrapper>';
        $output .= '<div class="vw-plugin-top-wrapper"></div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<script src="https://vlibras.gov.br/app/vlibras-plugin.js" defer></script>';
        $output .= '<script>window.addEventListener("load", function() { new window.VLibras.Widget("https://vlibras.gov.br/app"); });</script>';
    }
    
    // Adiciona script para detecção de preferências do sistema.
    $output .= '<script>';
    $output .= 'if (window.matchMedia) {';
    $output .= '  const darkMode = window.matchMedia("(prefers-color-scheme: dark)");';
    $output .= '  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");';
    $output .= '  const highContrast = window.matchMedia("(prefers-contrast: high)");';
    $output .= '  ';
    $output .= '  if (!localStorage.getItem("theme_ufpel_darkmode") && darkMode.matches) {';
    $output .= '    document.body.classList.add("theme-dark-mode");';
    $output .= '  }';
    $output .= '  ';
    $output .= '  if (reducedMotion.matches) {';
    $output .= '    document.body.classList.add("reduced-motion");';
    $output .= '  }';
    $output .= '  ';
    $output .= '  if (highContrast.matches) {';
    $output .= '    document.body.classList.add("prefers-high-contrast");';
    $output .= '  }';
    $output .= '}';
    $output .= '</script>';
    
    // Adiciona noscript para usuários sem JavaScript.
    $output .= '<noscript>';
    $output .= '<style>';
    $output .= '.requires-js { display: none !important; }';
    $output .= '.no-js-fallback { display: block !important; }';
    $output .= '</style>';
    $output .= '</noscript>';
    
    return $output;
}
