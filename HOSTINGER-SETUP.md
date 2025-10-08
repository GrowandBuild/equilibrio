# 🚀 Configuração Laravel no Hostinger

## 📁 **Estrutura de Pastas**

```
/home/u834385447/
├── laravel/              ← Seu projeto Laravel aqui
│   ├── app/
│   ├── public/
│   ├── resources/
│   └── ...
└── public_html/          ← Link simbólico aponta para laravel/public
```

## 📋 **Instalação Rápida**

### 1️⃣ **Conectar no Servidor**
```bash
ssh -p 65002 u834385447@147.93.39.173
```

### 2️⃣ **Ir para a Home**
```bash
cd /home/u834385447
```

### 3️⃣ **Clonar Repositório**
```bash
git clone https://github.com/GrowandBuild/equilibrio.git laravel
cd laravel
```

### 4️⃣ **Instalar Dependências PHP**
```bash
composer install --no-dev --optimize-autoloader
```

### 5️⃣ **Instalar Dependências Node e Compilar Assets**

**OPÇÃO A - Compilar no Servidor (se tiver Node.js instalado):**
```bash
npm install
npm run build
```

**OPÇÃO B - Compilar Localmente e Enviar (RECOMENDADO):**
```bash
# No seu PC:
npm install
npm run build

# Isso cria a pasta public/build/
# Depois faça upload apenas da pasta public/build/ via FTP/SCP

# No servidor, NÃO precisa rodar npm install nem npm run build
```

> 💡 **Dica:** O Hostinger compartilhado pode não ter Node.js. Compile localmente e envie apenas o `public/build/`!

### 6️⃣ **Configurar .env**
```bash
cp .env.example .env
nano .env
```

Configurações:
```env
APP_NAME="Equilíbrio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sienna-wolf-528169.hostingersite.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u834385447_equilibrio
DB_USERNAME=u834385447_equilibrio
DB_PASSWORD=SUA_SENHA_AQUI

SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### 7️⃣ **Gerar Chave**
```bash
php artisan key:generate
```

### 8️⃣ **Criar Link Simbólico**
```bash
cd /home/u834385447
rm -rf public_html
ln -s laravel/public public_html
```

### 9️⃣ **Executar Migrations**
```bash
cd laravel
php artisan migrate --force
php artisan db:seed --class=EmblemasSeeder
```

### 🔟 **Permissões**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;
```

### 1️⃣1️⃣ **Otimizar**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

## 🔧 **Configurar Banco de Dados**

No painel Hostinger:
1. MySQL Databases → Create New
2. Database: `u834385447_equilibrio`
3. Username: `u834385447_equilibrio`
4. Password: (salve a senha)
5. Assign user to database

## 🌐 **Acessar Site**

https://sienna-wolf-528169.hostingersite.com

## 🔄 **Atualizar Site (Deploy)**

```bash
ssh -p 65002 u834385447@147.93.39.173
cd /home/u834385447/laravel
git pull origin main
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📱 **PWA Configurado**

✅ Service Worker ativo
✅ Manifest.json configurado
✅ Ícones PWA prontos
✅ Instalação offline habilitada
✅ Cache automático
✅ Banner de instalação (aparece após 10s)

## ✅ **Checklist**

- [ ] SSH conectado
- [ ] Repositório clonado em `/laravel`
- [ ] Dependências instaladas
- [ ] `.env` configurado
- [ ] Chave gerada
- [ ] Banco criado
- [ ] Link simbólico criado (`public_html → laravel/public`)
- [ ] Migrations executadas
- [ ] Seeders executados
- [ ] Permissões definidas
- [ ] Cache otimizado
- [ ] Site funcionando
- [ ] PWA instalável

## 🎉 **Pronto!**

Seu Laravel com PWA está rodando no Hostinger!