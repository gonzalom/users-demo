Users-Demo
================


# About

[Symfony 3.2](http://symfony.com/doc/3.1/index.html) application with [users bundle 2.0](http://symfony.com/doc/2.0/bundles/FOSUserBundle/index.html) and customized fields and templates.

In this repository, the `users` table will have the following fields:
- `id_user` (as the primary key, instead of `id`)
- `name`
- `age`
- `job_title`
- `inserted_on`
- `last_updated`


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
git clone ...
```

Optionally, you can run the included homestead machine:

// TODO

Verify that the system is compatible

```bash
php bin/symfony_requirements
```

Security check

```bash
php bin/console security:check
```


## Configure the database

Before creating the database, if you want to start from fresh, you can remove it:

```bash
php bin/console doctrine:database:drop --force
```

To create the database:

```bash
php bin/console doctrine:database:create
```


# Server

We can start the default build in server from symfony:

```bash
php bin/console server:run
```

More info in [Installing & Setting up the Symfony Framework](http://symfony.com/doc/3.2/setup.html)

## Homestead server

You may also use homestead with the following configuration example:

```yaml
ip: "192.168.10.10"

folders:
    - map: ~/Code
      to: /home/vagrant/Code
      
sites:
    - map: users-demo.app
      to: /home/vagrant/Code/Users-Demo/web
      type: symfony
      
databases:
    - users-demo
```

And add this line to /etc/hosts (unix) or C:\Windows\System32\drivers\etc\hosts (Windows)

```text
192.168.10.10 symfony-demo.dev
```

## Nginx configuration

If you prefer to use any other server, you can use the following Nginx configuration:

```
server {
    listen 80;
    listen 443 ssl http2;
    server_name users-demo.app;
    root "/home/vagrant/Code/Users-Demo/web";

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

# Links

- [Symfony](http://symfony.com/)
- [Symfony versus Flat PHP](http://symfony.com/doc/current/introduction/from_flat_php_to_symfony2.html)
