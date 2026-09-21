# Projeto-PHP-MYSQL

## Sobre o projeto

Este projeto foi desenvolvido para atender a avaliação proposta pela *******, avaliando conhecimentos em PHP Orientado a Objetos, MVC, PDO com MySQL, JavaScript/jQuery e organização de código.

## Requisitos atendidos

- PHP OOP
- MVC simples sem framework backend ou frontend
- PDO com MySQL
- Login com autenticação por sessão
- Dashboard com dados do usuário logado
- Listagem de serviços
- Filtros por descrição, status, usuário e período
- Cadastro, alteração e exclusão de serviços
- Finalização de serviço com data de conclusão e cálculo de comissão
- Envio de e-mail ao finalizar serviço via PHP mail()

## Regras de negócio implementadas

- Login com email e senha inválidos exibe a mensagem: `Ops, Email ou Senha inválido`
- Login com dados corretos redireciona para o dashboard
- O dashboard mostra:
  - dados do usuário logado
  - data atual
  - valor total dos serviços
  - últimos serviços pendentes
  - tabela com serviços, status, valor e nome do usuário
- Ações por serviço:
  - Alterar
  - Excluir
  - Finalizar
- Comissão aplicada ao finalizar serviço:
  - até R$ 250,00 => 5%
  - acima de R$ 250,00 e até R$ 1.000,00 => 7%
  - acima de R$ 1.000,00 e até R$ 10.000,00 => 10%
  - acima de R$ 10.000,00 => 20%

## Banco de dados

O arquivo `schema.sql` cria as tabelas `users` e `services`.

## Como executar

### 1) Subir o ambiente com Docker

```bash
docker compose up -d --build
```

### 2) Importar o schema

```bash
docker exec titan_mysql sh -c "mysql -uroot -proot < /tmp/schema.sql"
```

Se o arquivo ainda não estiver no container, copie antes:

```bash
docker cp schema.sql titan_mysql:/tmp/schema.sql
```

### 3) Criar usuário de teste

Use o script de seed:

```bash
php scripts/create_seed_user.php "Admin Teste" "admin@titan.local" "senha123"
```

### 4) Acessar a aplicação

Acesse:

```text
http://127.0.0.1:8080/login
```

Login de teste:

```text
Email: admin@titan.local
Senha: senha123
```

## Observações

- Não foi utilizado Composer para gerenciar dependências.
- O envio de e-mail usa `mail()` do PHP e depende da configuração do ambiente.
- O projeto foi desenvolvido com foco em funcionalidade e estrutura MVC simples, conforme a proposta da avaliação.

