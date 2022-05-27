# Instalação

Clone este repositório
```
git clone https://github.com/robott11/teste-estagio-Simpleshotel.git
```

Instale as dependências do composer
```
composer install
```

Então copie o arquivo ***.env.example*** e o renomeie para ***.env*** e configure o seu banco de dados nele
```
cp .env.example .env
```

Gere a chave do Laravel e rode as migrations
```
php artisan key:generate

php artisan migrate
```

Por fim, abra o server e popule o banco com dados
```
php artisan db:seed

php artisan serve
```

O login de admin é gerado aleatóriamente e pode ser encontrado no shell interativo do Laravel ``php artisan tinker``
e executando o método ``Admin::all()`` e ``Waiter::all()``

A senha sempre será ``admin`` para admin e ``password`` para garçom.

# Rotas
```/dashboard``` e ```/admin/dashboard```
