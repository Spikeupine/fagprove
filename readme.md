<h1>Guestbook</h1>

A small guestbook application.
This project is my final exam of apprentenship in IT-development. 
## Getting started
Download and installation guide
### Requirements
- [Lamp](https://howtoubuntu.org/how-to-install-lamp-on-ubuntu)
- [Larvel 5.5 requirements](https://laravel.com/docs/5.5#server-requirements)
- [Composer](https://getcomposer.org/download/)
- [Npm](https://www.npmjs.com/get-npm)

### Install requirements

If you haven't already install a lamp server with ubuntu 16.04

[tutorial for ubuntu](https://howtoubuntu.org/how-to-install-lamp-on-ubuntu)

Install Composer
```
sudo apt install composer
```
Install nodejs and npm
```
sudo apt install nodejs
sudo apt install npm
```

### Clone repository

Clone repository to an empty folder
```
git clone https://github.com/Spikeupine/fagprove.git
```
Copy ```.env.example``` to ```.env```

### Dependencies
Run composer install to get all dependencies specified in composer.json
```
 composer install
 ```
Run npm install to install all dependencies specified in package.json
```
npm install
```
If you have trouble  running npm install make sure you have the [latest node version installed](https://stackoverflow.com/questions/10075990/upgrading-node-js-to-latest-version)

Build assets
```
npm run production
```

Generate key using
```
php artisan key:generate
```
    
### Database setup
Create an empty mysql database with user
```
CREATE DATABASE database;

CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON database . * TO 'user'@'localhost';
```
Specify database in the ```DB_*``` fields in the ```.env``` file

```
DB_DATABASE = database

DB_USERNAME = user

DB_PASSWORD = password
```

Run migrations to set up database
```
php artisan migrate
```

### Email

If you wish to setup email (for password reset) you need to insert that into the ```MAIL_*``` Fields in the ```.env``` file

If you just want to test locally you can set the maildriver to log

```
MAIL_DRIVER=log
```

This will output the email to storage/logs/laravel.log

### Deploying with apache2
Create a new configuration
```
sudo nano -LN /etc/apache2/sites-available/guestbook.conf
```
In guestbook.conf
```
<VirtualHost *:80>
  DocumentRoot  /your/directory/path/public
  ServerName guestbook.local
 
  ErrorLog ${APACHE_LOG_DIR}/guestbook.error.log
  LogLevel warn
  CustomLog ${APACHE_LOG_DIR}/guestbook.access.log combined
 
  <Directory /your/directory/path/>
    AllowOverride All
    Order allow,deny
    allow from all
  </Directory>
 
  AcceptPathInfo On
</VirtualHost>

```
Add new config and restart apache
```
sudo a2ensite guestbook.conf
sudo service apache2 restart
```
Add guestbook.local to hosts file
```
127.0.0.1    guestbook.local
```
## Permission denied error

If you run into permission denied error set owner to 'youruser':www-data on all the files in the project
```
sudo chown youruser:www-data -R .
```

Also make sure you have the correct permissions for the storage folder
```
sudo chmod {example: 775} -R storage/
```

