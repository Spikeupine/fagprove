<h1>Guestbook</h1>

A small guestbook application
## Getting started
Download and installation guide
### Requirements

- [Composer](https://getcomposer.org/download/)
- [Npm](https://www.npmjs.com/get-npm)
- [Mysql](https://dev.mysql.com/downloads/)

### Clone repository

Clone repository to an empty folder
```
git clone https://github.com/Spikeupine/fagprove.git
```
Copy ```.env.example``` to ```.env```

Generate key using
```
php artisan key:generate
```
### Dependencies
Run composer install to get all dependencies specified in composer.json
```
 composer install
 ```
Run npm install to install all dependencies specified in package.json
```
npm install
```
Build assets
```
npm run production
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
sudo a2ensite groupsapi
sudo service apache2 restart
```
Add guestbook.local to hosts file
```
127.0.0.1    guestbook.local
```

