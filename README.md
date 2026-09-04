# PRISMA

O PRISMA é uma plataforma web desenvolvida para auxiliar a Orientação Educacional e a equipe docente no acompanhamento, mediação socioemocional e identificação precoce de vulnerabilidades no ambiente escolar.

## 📁 Estrutura do Projeto

```text
Prisma/
├── api/
│   └── status.php            # Verificação de status e endpoints da API
├── assets/
│   ├── css/
│   │   └── styles.css        # Estilos globais e componentes da interface
│   ├── icons/
│   │   └── menu.svg          # Ícones da interface
│   ├── img/
│   │   └── logo.svg          # Identidade visual do PRISMA
│   └── js/
│       └── app.js            # Lógica dinâmica do front-end
├── database/
│   ├── data.json             # Estrutura inicial / dados para testes
│   └── prisma.sql            # Script SQL do banco de dados relacional
├── includes/
│   ├── data.php              # Conexão e manipulador de dados
│   ├── footer.php            # Rodapé institucional modular
│   ├── header.php            # Cabeçalho global
│   └── sidebar.php           # Menu lateral de navegação
├── pages/
│   ├── alunos.php            # Lista e consulta de alunos
│   ├── anotacoes.php         # Registros e mediações socioemocionais
│   ├── calendario.php        # Cronograma e agendamentos
│   ├── dashboard.php         # Painel principal com semaforização de riscos
│   ├── medicamentos.php      # Módulo de controle de medicação
│   └── perfil.php            # Configurações do usuário / Orientador
├── index.php                 # Ponto de entrada do sistema
├── login.php                 # Autenticação de usuários
├── logout.php                # Encerramento de sessão
└── README.md                 # Documentação do repositório

## Como usar

1. Coloque a pasta `PRISMA` em um servidor PHP local (XAMPP, WAMP, Laragon etc.).
2. Abra `login.php` no navegador.
3. Informe o email e senha de administrador para entrar:
   - Email: admin@prisma.local
   - Senha: Prisma123!
4. A navegação está disponível no menu lateral.
