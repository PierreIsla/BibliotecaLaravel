# 📚 Sistema de Gestão de Biblioteca

Sistema completo de gestão de biblioteca desenvolvido em Laravel 11 com autenticação, autorização baseada em roles, e CRUD completo para livros, autores, categorias e empréstimos.

## 🚀 Funcionalidades

### Zona Pública
- ✅ Listagem de livros com filtros e pesquisa
- ✅ Visualização detalhada de livros
- ✅ Exploração por categorias
- ✅ Sistema de pesquisa avançada

### Zona Administrativa
- ✅ Dashboard com estatísticas
- ✅ Gestão completa de livros (CRUD)
- ✅ Gestão de autores com upload de fotos
- ✅ Gestão de categorias
- ✅ Gestão de empréstimos
- ✅ Sistema de alertas para livros atrasados
- ✅ Upload de capas de livros e PDFs

### Utilizadores
- ✅ Autenticação com Laravel Breeze
- ✅ Sistema de roles (Admin/User)
- ✅ Visualização de empréstimos pessoais
- ✅ Alertas de atrasos

## 🛠️ Tecnologias

- **Framework:** Laravel 11
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** MySQL
- **Autenticação:** Laravel Breeze
- **File Storage:** Laravel Storage
- **API:** Laravel Sanctum

## 📋 Requisitos

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18
- NPM

## 🔧 Instalação

1. **Clonar o repositório**
```bash
git clone https://github.com/SEU_USERNAME/biblioteca-laravel.git
cd biblioteca-laravel
```

2. **Instalar dependências PHP**
```bash
composer install
```

3. **Instalar dependências Node**
```bash
npm install
```

4. **Configurar ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar base de dados**

Editar `.env`:
```env
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=sua_password
```

6. **Criar base de dados**
```bash
mysql -u root -p
CREATE DATABASE biblioteca;
exit;
```

7. **Executar migrations e seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Criar link simbólico do storage**
```bash
php artisan storage:link
```

9. **Compilar assets**
```bash
npm run build
```

10. **Iniciar servidor**
```bash
php artisan serve
```

Aceder em: http://127.0.0.1:8000

## 👤 Credenciais de Teste

### Administrador
- **Email:** admin@biblioteca.com
- **Password:** password

### Utilizadores Normais
- **Email:** user1@biblioteca.com
- **Password:** password

## 📊 Estrutura da Base de Dados

- **users** - Utilizadores do sistema
- **categories** - Categorias de livros
- **authors** - Autores
- **books** - Livros
- **author_book** - Relação N:N entre autores e livros
- **loans** - Empréstimos

## 🌟 Características Técnicas

- Soft Deletes em todos os modelos principais
- Validação server-side com Form Requests
- Relacionamentos 1:N e N:N
- Upload e gestão de ficheiros (imagens e PDFs)
- Seeders com dados de exemplo
- Middleware personalizado para roles
- RESTful API com autenticação Sanctum

## 📝 Licença

Este projeto foi desenvolvido para fins educacionais.

## 👨‍💻 Autor

Desenvolvido por [Pedro Fonseca , Dinis Oliveira]