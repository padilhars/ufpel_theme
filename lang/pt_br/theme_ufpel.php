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
 * Language strings for UFPel theme (Portuguese Brazil).
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas (UFPel)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Plugin information.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'Tema oficial da Universidade Federal de Pelotas (UFPel) baseado no Boost para Moodle 5.0+. Este tema oferece uma identidade visual moderna e responsiva, otimizada para a experiência educacional da UFPel.';

// General settings.
$string['generalsettings'] = 'Configurações Gerais';
$string['generalsettingsdesc'] = 'Configure as opções básicas do tema UFPel, incluindo logo e favicon.';

// Logo settings.
$string['logo'] = 'Logo da Instituição';
$string['logodesc'] = 'Faça upload do logo da UFPel. O logo será exibido no cabeçalho da navegação. Recomenda-se uma imagem de 50x50 pixels ou similar.';

// Favicon settings.
$string['favicon'] = 'Favicon';
$string['favicondesc'] = 'Faça upload do favicon personalizado. O favicon aparecerá na aba do navegador e nos favoritos. Recomenda-se um arquivo .ico de 32x32 pixels.';

// Color settings.
$string['colorsettings'] = 'Configurações de Cores';
$string['colorsettingsdesc'] = 'Personalize as cores do tema de acordo com a identidade visual da UFPel.';

$string['primarycolor'] = 'Cor Primária';
$string['primarycolordesc'] = 'A cor principal da UFPel. Padrão: #00408F (azul UFPel).';

$string['secondarycolor'] = 'Cor Secundária';
$string['secondarycolordesc'] = 'A cor secundária complementar. Padrão: #0080FF (azul claro).';

$string['accentcolor'] = 'Cor de Destaque';
$string['accentcolordesc'] = 'Cor utilizada para destaques e elementos de ação. Padrão: #F7A600 (laranja).';

$string['backgroundcolor'] = 'Cor de Fundo';
$string['backgroundcolordesc'] = 'Cor de fundo principal do tema. Padrão: #EBF5FF (azul muito claro).';

$string['textcolor'] = 'Cor do Texto';
$string['textcolordesc'] = 'Cor principal do texto. Padrão: #212529 (cinza escuro).';

$string['texthighlightcolor'] = 'Cor do Texto em Destaque';
$string['texthighlightcolordesc'] = 'Cor do texto sobre fundos escuros. Padrão: #FFFFFF (branco).';

// Course settings.
$string['coursesettings'] = 'Configurações do Curso';
$string['coursesettingsdesc'] = 'Configure a exibição do cabeçalho dos cursos e informações relacionadas.';

$string['courseheaderoverlay'] = 'Sobreposição do Cabeçalho do Curso';
$string['courseheaderoverlaydesc'] = 'Adiciona uma sobreposição escura sobre a imagem de fundo do cabeçalho para melhorar a legibilidade do texto.';

$string['showcourseimage'] = 'Mostrar Imagem do Curso';
$string['showcourseimagedesc'] = 'Exibe a imagem de fundo do curso no cabeçalho. Se desabilitado, será usado um cabeçalho simples.';

$string['showcourseteachers'] = 'Mostrar Professores do Curso';
$string['showcourseteachersdesc'] = 'Exibe os professores do curso no cabeçalho, incluindo foto e nome.';

$string['showcourseparticipants'] = 'Mostrar Número de Participantes';
$string['showcourseparticipantsdesc'] = 'Exibe o número total de participantes inscritos no curso.';

// Advanced settings.
$string['advancedsettings'] = 'Configurações Avançadas';
$string['advancedsettingsdesc'] = 'Configurações avançadas para desenvolvedores e administradores experientes.';

$string['rawscsspre'] = 'SCSS Inicial';
$string['rawscsspredesc'] = 'Use este campo para definir variáveis SCSS ou incluir código SCSS que deve ser processado antes do SCSS principal do tema.';

$string['rawscss'] = 'SCSS Adicional';
$string['rawscssdesc'] = 'Use este campo para adicionar código SCSS personalizado que será aplicado ao tema.';

$string['preset'] = 'Preset do Tema';
$string['presetdesc'] = 'Escolha um preset para alterar drasticamente a aparência do tema. Você pode criar e fazer upload de seus próprios presets.';

// Performance settings.
$string['performancesettings'] = 'Configurações de Performance';
$string['performancesettingsdesc'] = 'Configure opções para otimizar a performance e experiência do usuário.';

$string['enablelazyloading'] = 'Habilitar Carregamento Lazy';
$string['enablelazyloadingdesc'] = 'Ativa o carregamento lazy para imagens, melhorando a velocidade de carregamento da página.';

$string['enableparallax'] = 'Habilitar Efeito Parallax';
$string['enableparallaxdesc'] = 'Ativa o efeito parallax no cabeçalho dos cursos. Pode ser desabilitado em dispositivos móveis para melhor performance.';

$string['enabledarkmode'] = 'Suporte ao Modo Escuro';
$string['enabledarkmodedesc'] = 'Habilita o suporte automático ao modo escuro baseado na preferência do sistema do usuário.';

// Navigation and branding strings.
$string['home'] = 'Início';
$string['gotohome'] = 'Ir para a página inicial';
$string['ufpellogo'] = 'Logo da UFPel';
$string['ufpelfullname'] = 'Universidade Federal de Pelotas';
$string['ufpelshort'] = 'UFPel';
$string['navbarbrandinfo'] = 'Marca da navegação para';

// Course header strings.
$string['teachers'] = 'Professores';
$string['participants'] = 'Participantes';
$string['progress'] = 'Progresso';

// Footer strings.
$string['footerlinks'] = 'Links do Rodapé';
$string['aboutufpel'] = 'Sobre a UFPel';
$string['contact'] = 'Contato';
$string['help'] = 'Ajuda';
$string['support'] = 'Suporte';
$string['privacy'] = 'Privacidade';
$string['accessibility'] = 'Acessibilidade';

// Error messages.
$string['confignotfound'] = 'Configuração não encontrada para: {$a}';
$string['logonotfound'] = 'Logo não encontrado. Verifique se o arquivo foi enviado corretamente.';
$string['faviconnotfound'] = 'Favicon não encontrado. Verifique se o arquivo foi enviado corretamente.';

// Accessibility strings.
$string['skiptomaincontent'] = 'Pular para o conteúdo principal';
$string['skiptonavigation'] = 'Pular para a navegação';
$string['skiptocoursecontent'] = 'Pular para o conteúdo do curso';

// Theme customization strings.
$string['customcss'] = 'CSS Personalizado';
$string['customcssdesc'] = 'Adicione seu próprio CSS personalizado para ajustar o tema conforme necessário.';

$string['customjs'] = 'JavaScript Personalizado';
$string['customjsdesc'] = 'Adicione código JavaScript personalizado. Use com cuidado e teste bem antes de aplicar em produção.';

// Course format enhancements.
$string['coursecategory'] = 'Categoria do Curso';
$string['coursecode'] = 'Código do Curso';
$string['courseduration'] = 'Duração do Curso';
$string['courselanguage'] = 'Idioma do Curso';

// Card component strings.
$string['viewcourse'] = 'Ver Curso';
$string['enrollincourse'] = 'Inscrever-se no Curso';
$string['courseinfo'] = 'Informações do Curso';

// Mobile specific strings.
$string['mobilemenu'] = 'Menu Mobile';
$string['closemenu'] = 'Fechar Menu';
$string['openmenu'] = 'Abrir Menu';

// Social media and external links.
$string['ufpelwebsite'] = 'Site da UFPel';
$string['ufpelfacebook'] = 'UFPel no Facebook';
$string['ufpelinstagram'] = 'UFPel no Instagram';
$string['ufpelyoutube'] = 'UFPel no YouTube';

// Status messages.
$string['themeupdated'] = 'Tema UFPel atualizado com sucesso.';
$string['settingssaved'] = 'Configurações salvas com sucesso.';
$string['cacherefreshed'] = 'Cache do tema atualizado.';

// Developer and debug strings.
$string['debugmode'] = 'Modo de Debug';
$string['debugmodedesc'] = 'Ativa informações de debug para desenvolvedores. Não use em produção.';

$string['themeversioninfo'] = 'Versão do Tema UFPel: {$a}';
$string['moodleversionrequired'] = 'Este tema requer Moodle 5.0 ou superior.';

// Privacy and GDPR compliance.
$string['privacy:metadata'] = 'O tema UFPel não armazena nenhum dado pessoal dos usuários.';
$string['privacy:metadata:preference:darkmode'] = 'A preferência do usuário por modo escuro/claro.';

// Region names for block placement.
$string['region-side-pre'] = 'Lateral Esquerda';
$string['region-side-post'] = 'Lateral Direita';
$string['region-content'] = 'Conteúdo';
$string['region-footer'] = 'Rodapé';

// Loading and status indicators.
$string['loading'] = 'Carregando...';
$string['loadingcourse'] = 'Carregando curso...';
$string['noimage'] = 'Nenhuma imagem disponível';
$string['defaultimage'] = 'Imagem padrão';