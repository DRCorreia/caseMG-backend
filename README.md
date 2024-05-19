<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão de Estoque</title>
</head>
<body>
    <h1>Sistema de Gestão de Estoque</h1>
    <p>Este é um sistema simples de gestão de estoque desenvolvido em Laravel.</p>
    
    <h2>Requisitos</h2>
    <ul>
        <li>PHP 8.1 ou superior</li>
        <li>Composer</li>
        <li>MySQL</li>
    </ul>

    <h2>Instalação</h2>
    <p>Siga os passos abaixo para configurar e rodar o projeto.</p>

    <h3>1. Clone o repositório</h3>
    <pre><code>git clone https://github.com/DRCorreia/caseMG-backend.git
cd caseMG-backend
</code></pre>

    <h3>2. Instale as dependências do Composer</h3>
    <pre><code>composer install
</code></pre>

    <h3>3. Configuração do Banco de Dados</h3>
    <p>Renomeie o arquivo <code>.env.example</code> para <code>.env</code> e configure as variáveis de ambiente para o seu banco de dados.</p>

    <h3>4. Dados</h3>
    <p>Você pode usar o dump que eu deixei anexado na raiz do projeto ou executar o comando <code>php artisan migrate</code>, também na raiz do projeto, para gerar as tabelas. Caso você tenha algum problema ao migrar, verifique se a extensão <code>pdo_mysql</code> está descomentada no seu arquivo <code>php.ini</code>.</p>
</body>
</html>
