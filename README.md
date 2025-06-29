# Cinefy

## About

A web application that allows you to reserve seats for different films at different times.

## Contributors (Student IDs)

- @jpajak 64814
- @mjachimowski 72975

## Config

The configuration is in the root folder in a file named `config.php`.
Database connection settings should be setted in 'database' key.

```
    $config['database'][...]
```

## Apache

If you use Apache webserver, you should use .htaccess settings listed below.

```
RewriteEngine On

RewriteCond %{REQUEST_FILENAME}  -f [OR]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^((?!assets)(?!vendor).*)$ index.php [L,QSA]
```
