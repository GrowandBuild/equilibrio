#!/bin/bash

# Script de instalação automática - Hostinger
# Execute: bash setup-hostinger.sh

echo "🚀 Instalando Laravel no Hostinger..."

# Conectar e executar comandos
ssh -p 65002 u834385447@147.93.39.173 << 'ENDSSH'

# Ir para home
cd /home/u834385447

# Clonar repositório
echo "📥 Clonando repositório..."
git clone https://github.com/GrowandBuild/equilibrio.git laravel
cd laravel

# Instalar dependências PHP
echo "📚 Instalando dependências PHP..."
composer install --no-dev --optimize-autoloader

# Instalar dependências Node
echo "📦 Instalando dependências Node..."
npm install

# Compilar assets
echo "🔨 Compilando assets..."
npm run build

# Copiar .env
echo "⚙️ Configurando .env..."
cp .env.example .env

# Gerar chave
echo "🔑 Gerando chave..."
php artisan key:generate

# Criar link simbólico
echo "🔗 Criando link simbólico..."
cd /home/u834385447
rm -rf public_html
ln -s laravel/public public_html

# Voltar para laravel
cd laravel

# Permissões
echo "🔐 Configurando permissões..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Otimizar
echo "⚡ Otimizando..."
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Instalação concluída!"
echo "🔧 Configure o .env e execute: php artisan migrate --force"

ENDSSH

echo "🎉 Pronto! Acesse: https://sienna-wolf-528169.hostingersite.com"