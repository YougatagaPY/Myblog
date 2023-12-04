# Le blog de Younes ! La documentation

Bonjour à toi ! je vais te montrer étape par étape comment mettre en production mon blog !


# Apache2
Dans une VM debian installe d'apache2.
Tu peut suivre ce tuto ou chercher par toi même
Les étapes:
```
> sudo apt update
>sudo apt install apache2
>sudo systemctl status apache2 //Pour verifier que le serveur est bien lancé
>sudo apt install curl 
```

**Tape l'ip de la machine pour vérifier que tout a bien marché !**

## PHP 
```
> apt install -y lsb-release ca-certificates apt-transport-https software-properties-common gnupg2
>echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
>wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
>sudo apt install curl 
>apt update && apt upgrade -y
>apt install php
>apt-get install libapache2-mod-php8.10
>apt-get install php8.1-common php8.1-curl php8.1-bcmath php8.1-intl php8.1-mbstring php8.1-xmlrpc php8.1-mcrypt php8.1-mysql php8.1-gd php8.1-xml php8.1-cli php8.1-zip

```



## Composer
```
> apt install wget php-cli php-xml php-zip php-mbstring unzip -y
>wget -O composer-setup.php https://getcomposer.org/installer
>php composer-setup.php --install-dir=/usr/local/bin --filename=composer
>sudo apt install curl 
```

**Pour tester : composer --version**
## Symfony
```
>curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
>apt install symfony-cli
```
**Pour tester :  symfony -V**

## Git

Cela va servir à **cloner** mon code qui est sur github.
```
> apt install git
>apt install symfony-cli
```

## Cloner mon projet 

Il faut aller dans le répertoire /var/www/html/ et cloner mon projet

```
> cd /var/www/html/
>git clone https://github.com/YougatagaPY/fluxoscript blog
```

# BDD mariadb

Pour que le tout soit bien sécuriser on va héberger notre base de données dans une autre vm
Donc crée une autre vm debian et installe mariadb:
```
>  apt install mariadb-server mariadb-client -y
>mysql
>CREATE USER 'younes'@'%' IDENTIFIED BY 'younes';
>GRANT ALL PRIVILEGES ON * . * TO 'younes'@'%';
>FLUSH PRIVILEGES
>CREATE DATABSE blog;
>exit
```
Dans le fichier blog que tu as cloné  /var/www/html/blog
```
> composer require
> php bin/console make:migration
> php bin/console doctrine:fixtures:load
```
change également la blind adress dans /etc/mysql/mariadb.conf.d/50-server.cnf
```
> cd  /etc/mysql/mariadb.conf.d/
> nano 50-server.cnf
> bind-address = 0.0.0.0
```
## Changer le .env
Il faut aller encore dans /var/www/html/blog et changer le .env pour accéder a notre bdd 
```
> cd /var/www/html/blog
>sudo nano .env
```
Il faut changer cette ligne :
```
>DATABASE_URL="mysql://younes:younes@"ip de la vm":3306/blog?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```


## A installer
Pour que symfony marche directement 
```
> apt install php5-fpm
>sudo nano .env
>apt-get install libapache2-mod-fcgid php-fpm htop
>apt-get install php8.2-xml
> apt-get install php8.2-mysql
```
Ensuite , dans le fichier /etc/apache2/sites-enabled/000-default.conf il faut modifier des éléments pour que le site soit en directement mis quand on tape l'ip du serveur.
```
> nano /etc/apache2/sites-enabled/000-default.conf
```

Voila quoi doit ressembler le fichier:
```
<VirtualHost *:80>
        # The ServerName directive sets the request scheme, hostname and port that
        # the server uses to identify itself. This is used when creating
        # redirection URLs. In the context of virtual hosts, the ServerName
        # specifies what hostname must appear in the request's Host: header to
        # match this virtual host. For the default virtual host (this file) this
        # value is not decisive as it is used as a last resort host regardless.
        # However, you must set it for any further virtual host explicitly.
        #ServerName www.example.com

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/blog

        # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
        # error, crit, alert, emerg.
        # It is also possible to configure the loglevel for particular
        # modules, e.g.
        #LogLevel info ssl:warn
           DocumentRoot /var/www/html/blog/public
    <Directory /var/www/html/blog/public>
        AllowOverride None
        Require all granted
        FallbackResource /index.php
    </Directory>
```

Restart apache 2
```
 systemctl restart apache2
```


## Fini

Tape l'ip dans un navigateur et c'est bon !
Vérifie que ta vm où il ya la bdd d'héberger est bien allumé !






