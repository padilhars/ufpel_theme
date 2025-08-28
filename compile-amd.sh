#!/bin/bash
# Script para compilar módulos AMD do tema UFPel
# Execute este script no diretório raiz do tema

echo "========================================="
echo "Compilação de Módulos AMD - Tema UFPel"
echo "========================================="

# Verifica se está no diretório correto
if [ ! -f "version.php" ] || [ ! -d "amd" ]; then
    echo "❌ Erro: Execute este script no diretório raiz do tema UFPel"
    exit 1
fi

# Cria diretório build se não existir
if [ ! -d "amd/build" ]; then
    echo "📁 Criando diretório amd/build..."
    mkdir -p amd/build
fi

# Verifica se o Node.js está instalado
if ! command -v node &> /dev/null; then
    echo "⚠️  Node.js não encontrado. Os arquivos já compilados serão usados."
    echo "✅ Os arquivos em amd/build/ já estão prontos para uso."
    exit 0
fi

# Verifica se o Grunt está instalado
if ! command -v grunt &> /dev/null; then
    echo "⚠️  Grunt não encontrado."
    echo "Instalando Grunt localmente..."
    npm install -g grunt-cli
fi

# Navega para o diretório do Moodle
MOODLE_ROOT=$(dirname $(dirname $(pwd)))

# Verifica se estamos em um diretório do Moodle
if [ ! -f "$MOODLE_ROOT/version.php" ]; then
    echo "⚠️  Não foi possível detectar o diretório raiz do Moodle"
    echo "Por favor, compile manualmente usando:"
    echo "  cd /caminho/para/moodle"
    echo "  grunt amd --root=theme/ufpel"
    exit 1
fi

# Compila usando o Grunt do Moodle
echo "🔄 Compilando módulos AMD..."
cd "$MOODLE_ROOT"

if [ -f "Gruntfile.js" ]; then
    # Usa o Grunt do Moodle
    grunt amd --root=theme/ufpel
    
    if [ $? -eq 0 ]; then
        echo "✅ Módulos AMD compilados com sucesso!"
    else
        echo "❌ Erro na compilação. Verifique os logs acima."
        exit 1
    fi
else
    echo "⚠️  Gruntfile.js do Moodle não encontrado"
    echo "Os arquivos pré-compilados em amd/build/ serão usados."
fi

# Limpa cache do Moodle
echo "🧹 Limpando cache do Moodle..."
php admin/cli/purge_caches.php 2>/dev/null || echo "⚠️  Limpe o cache manualmente via interface web"

echo ""
echo "========================================="
echo "✅ Processo concluído!"
echo "========================================="
echo ""
echo "Próximos passos:"
echo "1. Limpe o cache do Moodle (se não foi limpo automaticamente)"
echo "2. Teste o tema no navegador"
echo "3. Verifique o console do navegador (F12) para erros"
echo ""