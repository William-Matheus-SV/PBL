# PBL – Sistema de Assistência Técnica

Aplicação web em PHP para uma empresa de assistência técnica de informática. Substitui planilhas e fichas de papel por um sistema que centraliza **clientes**, **equipamentos**, **técnicos** e **ordens de serviço**, com acesso restrito a usuários autenticados.

Atividade PBL (Problem Based Learning) da unidade curricular Desenvolvimento de Sistemas, curso Técnico em Informática.

---

## Tecnologias

- PHP (PDO com prepared statements)
- MySQL 8
- HTML, CSS e Bootstrap 5 (via CDN)
- Servidor local: Apache do XAMPP

Arquitetura **MVC**: os *controllers* recebem a requisição e aplicam as validações, os *models* conversam com o banco e as *views* mostram o resultado.

---

## Como executar

1. Copie a pasta do projeto para `C:\xampp\htdocs\PBL`.
2. Inicie o **Apache** (XAMPP) e o serviço do **MySQL**.
3. Importe o script `config/banco.sql` (phpMyAdmin ou MySQL Workbench). Ele cria o banco `PBL` e as tabelas.
4. Confira `config/database.php` com o host, o usuário e a senha do seu MySQL.
5. Crie o primeiro usuário (veja abaixo) e acesse `http://localhost/PBL/`.

### Primeiro usuário (administrador)

O sistema não tem tela de cadastro de usuários, então o primeiro acesso é criado direto no banco. Execute no MySQL:

```sql
INSERT INTO usuarios (nome, email, senha, telefone, perfil, status)
VALUES ('Administrador', 'admin@pbl.com',
        '$2y$10$yhdiuVfM5Nug/lfi9KNL8OiBmUOb8OqC76t9sA7jQ3XtjzDvFAXhK',
        '81999999999', 'administrador', 'Ativo');
```

Login: `admin@pbl.com` | Senha: `Admin@123` (a senha fica salva como hash, nunca em texto).

---

## Estrutura de pastas

```
PBL/
├── config/
│   ├── banco.sql                  Script de criação do banco
│   ├── database.php               Conexão PDO
│   └── listas.php                 Listas fixas (status e prioridades)
├── controllers/
│   ├── authcontrollers/
│   │   ├── LoginController.php            Valida o login e cria a sessão
│   │   ├── LogoutController.php           Encerra a sessão
│   │   └── CadastrarClienteController.php Cadastro público de cliente
│   ├── ClienteController.php
│   ├── EquipamentoController.php
│   ├── TecnicoController.php
│   ├── OrdemServicoController.php
│   └── DashboardController.php
├── middleware/
│   └── auth.php                   Bloqueia acesso sem login
├── models/
│   ├── Usuario.php
│   ├── Cliente.php
│   ├── Equipamento.php
│   ├── Tecnico.php
│   ├── OrdemServico.php
│   └── Dashboard.php
├── views/
│   ├── auth/                      login.php, cadastro.php
│   ├── layouts/                   header.php, sidebar.php, footer.php
│   ├── dashboard/                 index.php
│   ├── clientes/                  _form, criar, editar, listar, visualizar
│   ├── equipamentos/              _form, criar, editar, listar, visualizar
│   ├── tecnicos/                  _form, criar, editar, listar, visualizar
│   └── ordens_servico/            _form, criar, editar, listar, visualizar
├── public/
│   ├── css/style.css
│   └── js/script.js
├── imagens/
└── index.php                      Redireciona para o dashboard
```

---

## Fluxo do sistema

```
Login → validação no banco → criação da Session → dashboard → CRUDs → logout → sessão encerrada
```

- `index.php` encaminha para o `DashboardController`, que passa pelo `middleware/auth.php`. Sem sessão, o usuário volta para a tela de login.
- O `LoginController` consulta o usuário no banco e confere a senha com `password_verify`. Se estiver correta, regenera o ID da sessão e guarda `id`, `nome`, `e-mail` e `perfil`.
- O `LogoutController` limpa e destrói a sessão.

---

## Módulos

### Clientes
Cadastro, listagem, visualização, edição e exclusão. Campos: nome, CPF/CNPJ, e-mail, telefones, endereço completo (logradouro, número, bairro, cidade, estado, CEP), data de cadastro e status. O CPF/CNPJ não pode se repetir. Um cliente também pode se cadastrar sozinho pela tela pública de cadastro, ligada à tela de login.

### Equipamentos
CRUD completo. Todo equipamento pertence a **um cliente**. Campos: tipo, marca, modelo, número de série, patrimônio, descrição, sistema operacional, data de cadastro e status.

### Técnicos
CRUD completo. Campos: nome, CPF (único), e-mail, telefone, especialidade, nível, data de admissão, status e observações.

### Ordens de serviço
CRUD completo. Cada OS é vinculada a um **cliente**, a um **equipamento** e a um **técnico responsável**. Ao abrir, recebe um número automático (ex.: `OS-2026-00001`), status inicial **Aberta** e prioridade (padrão **Normal**). Pode registrar problema relatado, diagnóstico, serviço realizado, previsão, conclusão, valor estimado, valor final e forma de pagamento.

### Dashboard
- Cartões com o total de clientes, de equipamentos, de técnicos ativos e de OS em aberto.
- Quantidade de ordens de serviço por status.
- Últimas ordens de serviço abertas.
- **Filtro de ordens por status e prioridade**, visível apenas para o perfil **administrador**.

---

## Banco de dados

Tabelas: `usuarios`, `clientes`, `equipamentos`, `tecnicos` e `ordens_servico`.

```
clientes ──1:N── equipamentos
clientes ──1:N── ordens_servico
equipamentos ──1:N── ordens_servico
tecnicos ──1:N── ordens_servico
usuarios  (controle de acesso ao sistema)
```

Todas as chaves estrangeiras usam `ON DELETE RESTRICT`: não é possível excluir um cliente, equipamento ou técnico que ainda tenha registros ligados a ele.

---

## Regras de negócio atendidas

| # | Regra | Onde está |
|---|---|---|
| 1 | Somente usuários ativos acessam a área administrativa | Campo `status` em `usuarios`, verificado no login |
| 2 | Credenciais inválidas não criam sessão | `LoginController.php` |
| 3 | Usuário identificado pela Session após o login | `$_SESSION` com id, nome, e-mail e perfil |
| 4 | Páginas internas bloqueiam usuários sem login | `middleware/auth.php` |
| 5 | Equipamento associado a um cliente | `equipamentos.id_cliente` (`NOT NULL`, chave estrangeira) |
| 6 | OS com cliente, equipamento, técnico, situação e prioridade | `ordens_servico` (chaves `NOT NULL`, `status` e `prioridade` com valor padrão) |
| 7 | OS concluída registra a data de conclusão | Campo `data_conclusao`, tratado em `OrdemServico::atualizar` |
| 8 | Exclusão exige confirmação | Confirmação antes de excluir nos módulos |
| 9 | Campos obrigatórios validados | Controllers e atributos `required` nos formulários |
| 10 | Senhas armazenadas de forma segura | `password_hash` / `password_verify` |

---

## Segurança

- Senhas com hash (`password_hash`), conferidas com `password_verify`, e nunca exibidas.
- Consultas com **prepared statements** (PDO).
- Sessão regenerada no login (`session_regenerate_id`) e destruída no logout.
- Verificação de sessão nas páginas internas.
- Dados recebidos validados nos controllers, e saída escapada com `htmlspecialchars`.
- No filtro do dashboard, valores fora das listas permitidas são ignorados.

---

## Cenários de teste

| Teste | Ação | Resultado esperado |
|---|---|---|
| 01 – Login válido | Informar credenciais corretas | Acesso permitido e sessão criada |
| 02 – Login inválido | Informar senha incorreta | Acesso negado |
| 03 – Acesso sem login | Abrir uma página interna diretamente (ex.: `/PBL/controllers/ClienteController.php`) | Redirecionamento para o login |
| 04 – Cadastrar cliente | Inserir cliente com dados válidos | Registro armazenado e exibido na consulta |
| 05 – Editar cliente | Alterar dados de um cliente | Dados atualizados |
| 06 – Excluir cliente | Solicitar exclusão e confirmar | Registro excluído conforme as regras |
| 07 – Equipamento | Cadastrar equipamento e vinculá-lo a um cliente | Equipamento aparece associado ao cliente |
| 08 – Abrir OS | Criar ordem para um equipamento | OS criada com situação inicial |
| 09 – Atualizar OS | Alterar situação, diagnóstico e serviço | Informações atualizadas |
| 10 – Concluir OS | Registrar conclusão e valor final | OS passa para Concluída |
| 11 – Logout | Encerrar a sessão e tentar voltar à página interna | Sessão encerrada e acesso bloqueado |

---

## Desafios extras implementados

- Dashboard com indicadores básicos.
- Filtro de ordens de serviço por status e prioridade.
- Perfil de acesso com permissão diferente (o filtro do dashboard é exclusivo do administrador).
- Tema claro/escuro, que fica salvo entre as visitas.

---

## Possíveis melhorias

- Tela de cadastro e gestão de usuários.
- Registro de qual usuário realizou cada operação.
- Histórico de alterações das ordens de serviço.
- Pesquisa de clientes por nome, CPF/CNPJ ou e-mail.
- Paginação nas listagens.
