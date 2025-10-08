# 🎯 Equilíbrio - Sistema de Gestão de Hábitos

## Instalação e Configuração

### 1️⃣ Configurar Banco de Dados

Abra o arquivo `.env` e configure o banco de dados MySQL:

```env
APP_NAME=Equilíbrio
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=equilibrio
DB_USERNAME=root
DB_PASSWORD=sua_senha_aqui
```

### 2️⃣ Criar o Banco de Dados

No MySQL, crie o banco de dados:

```sql
CREATE DATABASE equilibrio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Ou via terminal:

```bash
mysql -u root -p -e "CREATE DATABASE equilibrio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3️⃣ Rodar as Migrations

Execute as migrations para criar todas as tabelas:

```bash
php artisan migrate
```

### 4️⃣ Popular com Dados de Exemplo

Execute os seeders para criar usuário demo e hábitos de exemplo:

```bash
php artisan db:seed
```

### 5️⃣ Criar Link Simbólico para Storage

Para que as fotos de perfil funcionem:

```bash
php artisan storage:link
```

### 6️⃣ Iniciar Servidor

Em um terminal, inicie o servidor Laravel:

```bash
php artisan serve
```

Em outro terminal, inicie o Vite (para compilar assets):

```bash
npm run dev
```

### 7️⃣ Acessar o Sistema

Abra o navegador em: **http://localhost:8000**

**Credenciais de Acesso:**
- **Email:** demo@equilibrio.app
- **Senha:** password

---

## 🚀 Estrutura do Projeto

### Models
- `User` - Usuários do sistema
- `Habito` - Hábitos cadastrados
- `RegistroDiario` - Registros diários dos hábitos
- `UsuarioXp` - Sistema de XP e níveis
- `Emblema` - Emblemas/conquistas disponíveis
- `ConquistaUsuario` - Emblemas desbloqueados pelos usuários

### Controllers
- `DashboardController` - Dashboard principal
- `HabitoController` - CRUD de hábitos
- `RegistroController` - Registro diário de hábitos
- `InsightsController` - Estatísticas e insights
- `PerfilController` - Perfil do usuário

### Livewire Components
- `CardHabito` - Card interativo de hábito com +/-
- `BarraXp` - Barra de XP e nível
- `SeletorEmoji` - Seletor de emoji para hábitos

---

## 🎨 Funcionalidades Implementadas

✅ Sistema de autenticação (login/registro)
✅ CRUD completo de hábitos
✅ Registro diário com incremento/decremento
✅ Sistema de XP e níveis (4 níveis)
✅ Sequências de dias (streaks)
✅ Emblemas e conquistas
✅ Dashboard visual e moderno
✅ Responsivo (mobile-first)
✅ Emojis como ícones dos hábitos
✅ Cores automáticas (verde/vermelho)
✅ Múltiplas unidades de medida
✅ Frequência personalizável

---

## 📝 Próximos Passos (Opcional)

- Criar views de Hábitos (index, create, edit)
- Criar view de Registro Diário
- Criar view de Insights com gráficos (Chart.js)
- Criar view de Perfil
- Implementar notificações
- Adicionar animações de confete ao completar metas
- Exportação de relatórios PDF
- Modo escuro (Dark Mode)

---

## 🛠️ Tecnologias Utilizadas

- **Laravel 9** - Framework PHP
- **Livewire** - Componentes reativos
- **Alpine.js** - JavaScript minimalista
- **Tailwind CSS** - Framework CSS
- **MySQL** - Banco de dados
- **Vite** - Build tool

---

## 📞 Suporte

Se tiver algum problema, verifique:

1. ✅ MySQL está rodando
2. ✅ Banco de dados `equilibrio` foi criado
3. ✅ Arquivo `.env` está configurado corretamente
4. ✅ Migrations foram executadas (`php artisan migrate`)
5. ✅ Seeders foram executados (`php artisan db:seed`)
6. ✅ `npm run dev` está rodando
7. ✅ `php artisan serve` está rodando

---

**Desenvolvido com ❤️ para ajudar você a encontrar o equilíbrio!** 🎯

