Users-Demo
================


# About

[Symfony 3.2](http://symfony.com/doc/3.1/index.html) application with [users bundle 2.0](http://symfony.com/doc/2.0/bundles/FOSUserBundle/index.html) and customized fields and templates using [Bootstrap 3.3.7](http://getbootstrap.com/).

In this repository, the `users` table will have the following fields:
- `id_user` (as the primary key, instead of `id`)
- `name`
- `age`
- `job_title`
- `inserted_on`
- `last_updated`

If you want to read more about why you may find interesting using a framework instead of flat PHP, you may find interesting the article [Symfony versus Flat PHP](http://symfony.com/doc/3.2/introduction/from_flat_php_to_symfony2.html).

# Requirements

- PHP >= 5.5.9
- [JSON extension](https://php.net/manual/book.json.php)
- [ctype extension](https://php.net/manual/book.ctype.php)
- Your `php.ini` needs to have the `date.timezone` setting
- PDO installed
- PDO driver installed for the database server you want to use.

More info in [Requirements for Running Symfony](http://symfony.com/doc/3.2/reference/requirements.html)


# Installation

Clone the repository:

```bash
git clone git@github.com:gonzalom/users-demo.git
```

Verify that the system is compatible

```bash
php bin/symfony_requirements
```

Security check

```bash
php bin/console security:check
```

# Configuration

The environment configuration settings are allocated in `app/config/parameters.yml`.

## Database configuration

Example database settings for symfony server:

```yaml
# app/config/parameters.yml
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: users-demo
    database_user: root
    database_password: ~
```

Example database settings for homestead server:

```yaml
# app/config/parameters.yml
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: users-demo
    database_user: homestead
    database_password: secret
```

You can find more documentation about databases configuration in [Databases and the Doctrine ORM](http://symfony.com/doc/3.2/doctrine.html).

## Email configuration

Example email settings for [mailtrap](https://mailtrap.io/):

```yaml
# app/config/parameters.yml
parameters:
    mailer_transport: smtp
    mailer_host: smtp.mailtrap.io
    mailer_user: # your mailtrap user
    mailer_password: # your mailtrap password
```

If you use any other mail testing method, you may want to update the file `app/config/config_dev.yml`

You can find more documentation about email configurations in [How to send an Email](http://symfony.com/doc/3.2/email.html).


## Database Schema

Before creating the database, if you want to start from fresh, you can remove it:

```bash
php bin/console doctrine:database:drop --force
```

To create the database:

```bash
php bin/console doctrine:database:create
```

Now we can update the schema of our database.

To see what queries are going to be run:

```bash
php bin/console doctrine:schema:update --dump-sql
```

Then we can run them with:

```bash
php bin/console doctrine:schema:update --force
```


# Server

Here are some examples of servers configurations...

# Build-in Server

We can start the default build in server from symfony:

```bash
php bin/console server:start
```

More info in [Installing & Setting up the Symfony Framework](http://symfony.com/doc/3.2/setup.html).

Or if you want to learn more about the built-in web server: [How to Use PHP's built-in Web Server](http://symfony.com/doc/current/setup/built_in_web_server.html).

## Homestead server

You may also use homestead with the following `homestead.yml` configuration example:

```yaml
# homestead.yml
sites:
    - map: users-demo.app
      to: /home/vagrant/Code/users-demo/web
      type: symfony
```

You don't need to create the database, as it will be created by the doctrine command that we will see later, but if you want to, you can do so as...

```yaml
# homestead.yml
databases:
    - users-demo
```

And add this line to /etc/hosts (unix) or C:\Windows\System32\drivers\etc\hosts (Windows)

```text
192.168.10.10 users-demo.app
```

Note: This are the default global homestead configurations settings. Make sure you use the correct directory mappings and ip if you customized them.

## Build-in & Homestead merge

If you want to use both, the symfony build-in server and homestead, sharing services as the database, you can do so using homestead as the host:

```yaml
# app/config/parameters.yml
parameters:
    database_host: homestead
    database_port: null
    database_name: users-demo
    database_user: homestead
    database_password: secret
```

And adding it to your hosts file as:

```text
192.168.10.10 homestead
```

## Nginx configuration

If you prefer to use any other server, you can use the following Nginx configuration:

```
server {
    listen 80;
    listen 443 ssl http2;
    server_name users-demo.app;
    root "/home/vagrant/Code/users-demo/web";

    index index.html index.htm index.php app_dev.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /app_dev.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/users-demo.app-ssl-error.log error;

    sendfile off;

    client_max_body_size 100m;

    # DEV
    location ~ ^/(app_dev|app_test|config)\.php(/|$) {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
    }

    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        internal;
    }

    location ~ /\.ht {
        deny all;
    }

    ssl_certificate     /etc/nginx/ssl/users-demo.app.crt;
    ssl_certificate_key /etc/nginx/ssl/users-demo.app.key;
}

```

# What next...

Now you can register in `/register` route:
- For localhost:  [http://127.0.0.1:8000/register/](http://127.0.0.1:8000/register/)
- For virtual machine: [http://users-demo.app/register/](http://users-demo.app/register/)
