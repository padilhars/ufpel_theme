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
 * Strings de idioma em português brasileiro para o tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Strings gerais.
$string['pluginname'] = 'UFPel';
$string['choosereadme'] = 'Tema UFPel - Um tema moderno e responsivo para a Universidade Federal de Pelotas, baseado no Boost do Moodle 5.x.';
$string['configtitle'] = 'Configurações do tema UFPel';
$string['region-side-pre'] = 'Esquerda';

// Configurações gerais.
$string['generalsettings'] = 'Configurações Gerais';
$string['preset'] = 'Preset do tema';
$string['preset_desc'] = 'Escolha um preset para alterar amplamente o visual do tema.';
$string['preset_default'] = 'Padrão UFPel';
$string['preset_dark'] = 'Modo Escuro';
$string['preset_highcontrast'] = 'Alto Contraste';

$string['containerwidth'] = 'Largura do container';
$string['containerwidth_desc'] = 'Define a largura máxima do conteúdo principal do site.';

$string['darkmodetoggle'] = 'Habilitar alternância de modo escuro';
$string['darkmodetoggle_desc'] = 'Permite que os usuários alternem entre modo claro e escuro.';

$string['highcontrasttoggle'] = 'Habilitar modo de alto contraste';
$string['highcontrasttoggle_desc'] = 'Permite que os usuários ativem o modo de alto contraste para melhor acessibilidade.';

// Configurações de cores.
$string['colorsettings'] = 'Cores e Tipografia';
$string['brandcolor'] = 'Cor primária';
$string['brandcolor_desc'] = 'A cor primária da marca UFPel. Padrão: #0080FF';

$string['brandsecondary'] = 'Cor secundária';
$string['brandsecondary_desc'] = 'A cor secundária da marca UFPel. Padrão: #00408F';

$string['brandbackground'] = 'Cor de fundo';
$string['brandbackground_desc'] = 'Cor de fundo principal. Padrão: #EBF5FF';

$string['brandaccent'] = 'Cor de destaque';
$string['brandaccent_desc'] = 'Cor usada para elementos de destaque. Padrão: #F7A600';

$string['textprimary'] = 'Cor do texto principal';
$string['textprimary_desc'] = 'Cor do texto principal. Padrão: #000000';

$string['textsecondary'] = 'Cor do texto secundário';
$string['textsecondary_desc'] = 'Cor do texto secundário. Padrão: #6C6B6B';

// Configurações de imagens.
$string['imagesettings'] = 'Logos e Imagens';
$string['logo'] = 'Logo principal';
$string['logo_desc'] = 'Upload do logo principal da UFPel. Recomendado: SVG ou PNG com fundo transparente.';

$string['logocompact'] = 'Logo compacto';
$string['logocompact_desc'] = 'Logo compacto para espaços reduzidos. Usado quando a navegação está colapsada.';

$string['favicon'] = 'Favicon';
$string['favicon_desc'] = 'Ícone exibido na aba do navegador. Formatos aceitos: .ico, .png ou .svg';

$string['loginbackgroundimage'] = 'Imagem de fundo do login';
$string['loginbackgroundimage_desc'] = 'Imagem de fundo para a página de login. Recomendado: imagem de alta qualidade (1920x1080 ou superior).';

// Configurações de layout.
$string['layoutsettings'] = 'Layout e Navegação';
$string['courseprogressbar'] = 'Mostrar barra de progresso do curso';
$string['courseprogressbar_desc'] = 'Exibe uma barra de progresso no cabeçalho dos cursos mostrando a porcentagem de conclusão.';

$string['showteacherinfo'] = 'Mostrar informações do professor';
$string['showteacherinfo_desc'] = 'Exibe o nome e foto do professor no cabeçalho do curso.';

$string['showparticipantscount'] = 'Mostrar número de participantes';
$string['showparticipantscount_desc'] = 'Exibe o número de participantes inscritos no curso.';

$string['sidebarposition'] = 'Posição da barra lateral';
$string['sidebarposition_desc'] = 'Define a posição da barra lateral de navegação e blocos.';
$string['sidebar_left'] = 'Esquerda';
$string['sidebar_right'] = 'Direita';

// Configurações avançadas.
$string['advancedsettings'] = 'CSS Customizado';
$string['customscss'] = 'CSS/SCSS customizado';
$string['customscss_desc'] = 'Adicione código CSS ou SCSS customizado. Este código será aplicado após todos os outros estilos do tema.';

// Mensagens de interface.
$string['toggledarkmode'] = 'Alternar modo escuro';
$string['togglehighcontrast'] = 'Alternar alto contraste';
$string['courseprogress'] = 'Progresso do curso';
$string['participants'] = 'Participantes';
$string['teacher'] = 'Professor';
$string['teachers'] = 'Professores';

// Footer.
$string['footertext'] = 'Universidade Federal de Pelotas';
$string['copyright'] = '© {$a} UFPel - Todos os direitos reservados';

// Acessibilidade.
$string['accessibility'] = 'Acessibilidade';
$string['skiptomaincontent'] = 'Pular para o conteúdo principal';
$string['vlibras'] = 'Tradutor de Libras';

// Mensagens de erro.
$string['error:failedtoloadpreset'] = 'Falha ao carregar o preset selecionado. Usando preset padrão.';
$string['error:invalidcolor'] = 'Cor inválida fornecida. Usando cor padrão.';

// Strings para templates
$string['home'] = 'Início';
$string['courses'] = 'Cursos';
$string['myhome'] = 'Meu Painel';
$string['calendar'] = 'Calendário';
$string['quicklinks'] = 'Links Rápidos';
$string['support'] = 'Suporte';
$string['help'] = 'Ajuda';
$string['contactus'] = 'Contato';
$string['followus'] = 'Siga-nos';
$string['privacypolicy'] = 'Política de Privacidade';
$string['termsofuse'] = 'Termos de Uso';
$string['cookiepolicy'] = 'Política de Cookies';
$string['loggedinas'] = 'Você está logado como';
$string['notloggedin'] = 'Você não está logado';
$string['login'] = 'Entrar';
$string['logout'] = 'Sair';
$string['fontsize'] = 'Tamanho da fonte';
$string['decreasefont'] = 'Diminuir fonte';
$string['resetfont'] = 'Redefinir fonte';
$string['increasefont'] = 'Aumentar fonte';
$string['coursecategory'] = 'Categoria do curso';
$string['breadcrumb'] = 'Navegação estrutural';
$string['grades'] = 'Notas';
$string['enrolledon'] = 'Inscrito em';
$string['lastaccess'] = 'Último acesso';
$string['coursecompleted'] = 'Curso concluído';
$string['progressnotavailable'] = 'Progresso não disponível';
$string['others'] = 'outros';
$string['nocourses'] = 'Nenhum curso disponível';
$string['favourite'] = 'Favorito';
$string['completed'] = 'Concluído';
$string['hidden'] = 'Oculto';
$string['startdate'] = 'Data de início';
$string['enddate'] = 'Data de término';
$string['progress'] = 'Progresso';
$string['entercourse'] = 'Entrar no curso';
$string['moreinfo'] = 'Mais informações';
