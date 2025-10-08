# 🚀 Deploy Simples no Hostinger (SEM Node.js)

## ✅ **Boa Notícia!**

Você **JÁ TEM** a pasta `public/build/` compilada!

Isso significa que **NÃO precisa** de Node.js no servidor! 🎉

## 📋 **Passos Simplificados**

### 1️⃣ **Conectar no Servidor**
```bash
ssh -p 65002 u834385447@147.93.39.173
```

### 2️⃣ **Clonar Projeto**
```bash
cd /home/u834385447
git clone https://github.com/GrowandBuild/equilibrio.git laravel
cd laravel
```

### 3️⃣ **Instalar Composer**
```bash
composer install --no-dev --optimize-autoloader
```

### 4️⃣ **Configurar .env**
```bash
cp .env.example .env
nano .env
```

Configure:
```env
APP_URL=https://sienna-wolf-528169.hostingersite.com
DB_HOST=localhost
DB_DATABASE=u834385447_equilibrio
DB_USERNAME=u834385447_equilibrio
DB_PASSWORD=SUA_SENHA
```

Salvar: `Ctrl+O`, `Enter`, `Ctrl+X`

### 5️⃣ **Gerar Chave**
```bash
php artisan key:generate
```

### 6️⃣ **Link Simbólico**
```bash
cd /home/u834385447
rm -rf public_html
ln -s laravel/public public_html
```

### 7️⃣ **Migrations**
```bash
cd laravel
php artisan migrate --force
php artisan db:seed --class=EmblemasSeeder
```

### 8️⃣ **Permissões**
```bash
chmod -R 755 storage bootstrap/cache
```

### 9️⃣ **Otimizar**
```bash
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ✅ **Pronto!**

Acesse: https://sienna-wolf-528169.hostingersite.com

## 🔄 **Para Atualizar Depois**

### **Se NÃO mudou CSS/JS:**
```bash
ssh -p 65002 u834385447@147.93.39.173
cd /home/u834385447/laravel
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
```

### **Se MUDOU CSS/JS:**

**No seu PC primeiro:**
```bash
npm run build
git add public/build
git commit -m "Update build"
git push
```

**Depois no servidor:**
```bash
ssh -p 65002 u834385447@147.93.39.173
cd /home/u834385447/laravel
git pull origin main
php artisan config:cache
```

## 📱 **PWA Funcionando**

✅ Todos os arquivos PWA já estão commitados
✅ Service Worker pronto
✅ Manifest configurado
✅ Só falta gerar os ícones (opcional)

---

**Simples assim! Sem Node.js no servidor! 🎉**
