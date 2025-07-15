## Laravel Project with Jetstream

```
#Installing Jetstream
composer create-project laravel/laravel example-app

cd example-app

composer require laravel/jetstream
```

```
#Install Jetstream With Livewire

if you want to add Teams and dark then used --teams --dark
php artisan jetstream:install livewire

```

#Or, Install Jetstream With Inertia

if you want to add Teams and dark then used --teams --dark
php artisan jetstream:install inertia

The Inertia stack may also be installed with SSR support:
php artisan jetstream:install inertia --ssr

```

#Finalizing the Installation
```

npm install
npm run build
php artisan migrate

```

#Run the Project
```

php artisan serve
npm run dev

```

#Note
```
if you want to enable MustVerifyEmail then call this class in User Model,
Go to the config/fortify file and uncomment
Features::emailVerification(),
in the 'features' => [] section
```

#You can click the below link to read the documentation carefully
```

https://jetstream.laravel.com/introduction.html

```

## Or Run This Project

```

# clone the repo

git clone https://github.com/shayanahmad1999/laravel-jetstream.git

# cd into the directory

cd laravel-jetstream

# install dependencies

composer install
npm install
npm run build
npm run dev

# copy the .env file

cp .env.example .env

# generate the application key

php artisan key:generate

# run the migrations and seeder

php artisan migrate

```

---

## If You Want to Install Breeze Then Follow

```

composer require create-project laravel/project_name

```

Select `none` (not use any starter kit)

```

# install breeze

composer require laravel/breeze --dev
php artisan breeze:install

php artisan migrate
npm install
npm run build
npm run dev

```

```
