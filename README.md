## FilaEX

## Requisitos
* PHP 8.2 ou superior
* Composer

## Como rodar o projeto
Duplicar o arquivo ".env.example" e renomerpara ".env" </br>

Instalar as dependências do PHP
```
composer install
```

Gerar a chave
```
php artisan key:generate
```

Executar migration
```
php artisan migrate
```

Iniciar o projeto Laravel
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

## Passo-a-passo
Criar o projeto Laravel
```
composer create-project laravel/laravel
```

Iniciar o projeto Laravel
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

Executar migration
```
php artisan migrate
```

