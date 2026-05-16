#Build an AI Smart Budget App with Laravel & Livewire | Full-Stack (TALL stack) Tutorial
## ROTEIRO
[Iniciando o projeto](https://youtu.be/89dz_wTS1lc?list=PL6XtPqSZnOwSpS8NpJe6PoJArZNJt8RuV)

### INICIANDO O PROJETO
```sh
laravel new expense-tracking-app
[X] Livewire
[X] Laravel´s built-in authentication
[ ] Single livewire compoent?
[X] Pest
[X] Laravel Boost
[ ] Run npm?

cd expense-tracking-app
code .
ctrl+'
compos  er require laravel/sail --dev
```
#### Configurações iniciais do .env
```text
APP_NAME="JCCS FINANÇAS"
APP_URL=http://localhost
APP_TIMEZONE=America/Sao_Paulo

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=jccs_financas
DB_USERNAME=sail
DB_PASSWORD=password
```
#### Instalação do sail
```sh
php artisan sail:install
[x] pgsql
```
#### Subindo a aplicação para desenvolvimento
```sh
sail up -d
```
#### Executando as migrações pela primeira vez
```sh
sail artisan migrate
```
#### Instalanso as dependências do node
```sh
sail npm install
```
#### Realizando o build dos assets pela primeira vez
```sh
sail npm run build
```
### INSTALAÇÃO DE PACOTES
#### Pacote de tradução para pt-BR
```sh
sail artisan lang:publish
sail composer require lucascudo/laravel-pt-br-localization --dev
sail artisan vendor:publish --tag=laravel-pt-br-localization
# .env
APP_LOCALE=pt_BR'

sail artisan optimize
```
### MÓDULOS
#### Categorias
##### Branch
```sh
git checkout -b fetaure/categories
```
##### Modelo e migrações
```sh
sail artisan make:model Category -m
```
#### Orçamentos
##### Branch
```sh
git checkuot -b feature/budgets
```
##### Modelo e migrações
```sh
sail artisan make:model Budget -m
```
#### Despesas
##### Branch
```sh
git checkuot -b feature/expenses
```
##### Modelo e migrações
```sh
sail artisan make:model Expense -m
```


