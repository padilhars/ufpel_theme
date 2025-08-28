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
 * Gruntfile para compilar módulos AMD do tema UFPel
 *
 * @package    theme_ufpel
 * @copyright  2025 Universidade Federal de Pelotas
 * @author     Seu Nome
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) {
    // Configuração do Grunt
    grunt.initConfig({
        // Compilação de módulos AMD
        amd: {
            files: {
                expand: true,
                cwd: 'amd/src',
                src: '**/*.js',
                dest: 'amd/build',
                rename: function(dest, src) {
                    // Adiciona .min ao nome do arquivo
                    return dest + '/' + src.replace('.js', '.min.js');
                }
            }
        },
        
        // Uglify para minificar JavaScript
        uglify: {
            amd: {
                files: [{
                    expand: true,
                    cwd: 'amd/build',
                    src: '**/*.js',
                    dest: 'amd/build',
                    ext: '.min.js'
                }]
            }
        },
        
        // Watch para desenvolvimento
        watch: {
            amd: {
                files: ['amd/src/**/*.js'],
                tasks: ['amd', 'uglify:amd']
            }
        }
    });

    // Carrega os plugins do Grunt
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    
    // Tarefa para compilar AMD manualmente
    grunt.registerTask('amd', function() {
        grunt.log.writeln('Compilando módulos AMD...');
        
        // Copia os arquivos de src para build
        // No ambiente de produção, use o grunt do Moodle
        const fs = require('fs');
        const path = require('path');
        
        // Cria diretório build se não existir
        if (!fs.existsSync('amd/build')) {
            fs.mkdirSync('amd/build', { recursive: true });
        }
        
        // Lista de arquivos para copiar
        const files = ['theme.js', 'darkmode.js', 'accessibility.js'];
        
        files.forEach(file => {
            const srcPath = path.join('amd/src', file);
            const buildPath = path.join('amd/build', file.replace('.js', '.min.js'));
            
            if (fs.existsSync(srcPath)) {
                // Em produção, isso seria compilado com Babel
                // Aqui apenas copiamos como exemplo
                let content = fs.readFileSync(srcPath, 'utf8');
                
                // Adiciona wrapper AMD se não existir
                if (!content.includes('define(')) {
                    content = `define(['jquery', 'core/log'], function($, Log) {\n${content}\n});`;
                }
                
                fs.writeFileSync(buildPath, content);
                grunt.log.ok(`Compilado: ${file}`);
            }
        });
    });
    
    // Tarefa padrão
    grunt.registerTask('default', ['amd']);
};