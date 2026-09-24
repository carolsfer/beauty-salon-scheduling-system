# Cabeleleila Leila

Sistema web de agendamento para salão de beleza, desenvolvido como parte do teste técnico da DSIN.

A aplicação permite que clientes agendem um ou mais serviços, consultem seus agendamentos e façam alterações dentro do prazo permitido. Também possui uma área administrativa para acompanhar os agendamentos, atualizar status e consultar um resumo semanal.

## Funcionalidades

### Cliente

- Agendamento de um ou mais serviços
- Identificação pelo telefone cadastrado
- Área do Cliente com histórico de agendamentos
- Consulta de agendamentos por período
- Visualização dos detalhes e status
- Alteração de serviços, data e horário respeitando o prazo de 2 dias
- Sugestão para aproveitar um agendamento existente quando há outro na mesma semana

Ao aceitar a sugestão de mesma semana, os novos serviços são adicionados ao agendamento já existente, sem duplicar serviços que já estejam selecionados.

### Área da Leila

- Acesso administrativo com usuário e senha
- Listagem dos agendamentos recebidos
- Consulta e alteração dos dados de um agendamento
- Atualização dos status Pendente, Confirmado e Concluído
- Alteração de vários status pela própria listagem
- Resumo semanal dos agendamentos
- Quantidade de serviços concluídos por tipo
- Navegação entre semanas

## Tecnologias

- PHP 8
- MySQL 8
- PDO
- HTML5
- CSS3
- Sessões PHP
- Git

O projeto foi desenvolvido sem o uso de um framework PHP, utilizando uma estrutura MVC simplificada.

## Estrutura do projeto

```text
beauty-salon-scheduling-system/
├── config/
├── controllers/
├── database/
│   ├── schema.sql
│   └── seed.sql
├── models/
├── public/
│   ├── css/
│   └── index.php
├── screenshots/
├── tests/
├── views/
├── .env.example
└── README.md
```

Os arquivos estão separados entre controllers, models e views. Os scripts para criação e preenchimento inicial do banco ficam em `database/`, enquanto os testes das principais regras estão em `tests/`.

## Como executar

### Pré-requisitos

- PHP 8 ou superior
- MySQL 8
- extensão `pdo_mysql` habilitada

### 1. Clone o repositório

```bash
git clone https://github.com/carolsfer/beauty-salon-scheduling-system.git
cd beauty-salon-scheduling-system
```

### 2. Configure o banco de dados

Execute primeiro:

```text
database/schema.sql
```

e depois:

```text
database/seed.sql
```

O seed adiciona os serviços utilizados pelo sistema:

- Cabelos
- Unhas (Manicure)
- Hidratação
- Unhas (Pedicure)

### 3. Configure o ambiente

Crie um arquivo `.env` a partir do `.env.example` e informe os dados do seu banco:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=salao_leila
DB_USER=salao_app
DB_PASSWORD=your_password

ADMIN_USERNAME=leila
ADMIN_PASSWORD_HASH=your_password_hash
```

Para gerar o hash da senha da área administrativa:

```bash
php -r "echo password_hash('your_password', PASSWORD_DEFAULT);"
```

Copie o resultado para `ADMIN_PASSWORD_HASH`.

O arquivo `.env` não deve ser enviado para o repositório.

### 4. Inicie o servidor

Na raiz do projeto, execute:

```bash
php -S localhost:8000 -t public
```

Depois, acesse:

```text
http://localhost:8000
```

## Testes

Os testes podem ser executados diretamente pelo PHP:

```bash
php tests/AppointmentTest.php
php tests/ServiceTest.php
```

Eles cobrem as principais regras do sistema, como:

- prazo de 2 dias para alteração;
- validação de datas e horários;
- status permitidos;
- identificação de outro agendamento na mesma semana;
- validação dos serviços selecionados.

Os testes que utilizam o banco trabalham com transações e rollback para não manter os dados criados durante a execução.

## Decisões do projeto

Durante o desenvolvimento, alguns pontos do enunciado precisaram ser interpretados para definir o comportamento da aplicação.

### Prazo para alteração

Interpretei a regra de 2 dias como **dois dias de calendário**. Assim, um agendamento para o dia 10 ainda pode ser alterado pela cliente no dia 8.

Essa restrição se aplica às alterações feitas pela cliente. Na Área da Leila, o agendamento pode ser alterado quando necessário.

### Agendamentos na mesma semana

Considerei a semana de **segunda-feira a domingo**.

Quando a cliente já possui outro agendamento futuro na mesma semana, o sistema sugere adicionar os novos serviços a esse agendamento. A cliente também pode manter a nova data e criar um agendamento separado.

### Identificação da cliente

Para este projeto, optei por identificar a cliente pelo telefone cadastrado e manter essa identificação durante a sessão.

Isso permite acessar a Área do Cliente e realizar novos agendamentos sem solicitar novamente os mesmos dados durante a navegação.

### Confirmação do agendamento

A confirmação foi representada pelo status do agendamento. Os status disponíveis são `PENDING`, `CONFIRMED` e `COMPLETED`.

## Screenshots

As capturas das principais telas do sistema estão disponíveis na pasta [`screenshots`](screenshots/).

## Demonstração

O vídeo entregue junto ao projeto apresenta o fluxo de agendamento da cliente e as principais funcionalidades da Área da Leila.