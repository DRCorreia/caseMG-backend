# Backend

## Requisitos
PHP 8.1 ou superior, Composer e MySQL

## Instalação
Siga os passos abaixo para configurar e rodar o projeto:

1. Clone o repositório
`git clone https://github.com/seu-usuario/sistema-estoque.git](https://github.com/DRCorreia/caseMG-backend.git`

2. Instale as dependências do Composer
`composer install`

3. Configuração do Banco de Dados
Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente para o seu banco de dados.

4. Dados
Você pode usar o dump que eu deixei anexado na raíz no projeto ou executar o comando `php artisan migrate`, também na raíz do projeto, para gerar as tabelas. Caso você tenha algum problema ao migrar, verifique se a extensão pdo_mysql está descomentada no seu arquivo php.ini.
