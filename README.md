# CTU PC Shop

CTU PC Shop - Can Tho University PC Shop Online

## Instructor

Ths. Võ Huỳnh Trâm - vhtram@cit.ctu.edu.vn

## Members of Team

- Đào Minh Trung Thuận - B1704855 - thuanb1704855@student.ctu.edu.vn
- Nguyễn Quốc Hưng - B1704735 - hungb1704735@student.ctu.edu.vn

## Project details

Developing Web Application for PC Shop Online.\
Build a web service to receive requests and send responses through RESTful API.

### Technology

#### Server side

- PHP for language for server side.
- MySQL MariaDB for Database management.
- Composer for PHP Package vendors management, etc...

#### Client side

- NuxtJS / VueJS framework for developing web app
- VueJS modules:
  - BootstrapVue (Bootstrap) for designing UI
  - Axios for XMLHttpRequests
  - PWA for building Progressive Web Application
  - Nuxt Property Decorator for creating class component
  - etc...
- NPM / Yarn for JavaScript Package vendors management

## Plan and History

History work of team:
[view details](https://docs.google.com/spreadsheets/d/1vGH962jmla6gglzKe0kDl633JhzgvOkVznbaEGTFGhk/edit#gid=0)

Project plan and Progress work:
[view details](https://docs.google.com/spreadsheets/d/1CTPFJPvcTw07hX6urQ7mwc35Di9SfK8CXGeoCbU1tjY/edit#gid=0)

## Setup project

### Install for developing

**_Require environment:_**

- NodeJS 12.18.4+
- NPM 6.14.8+ or Yarn 1.22.4+
- Composer 1.10.13+
- PHP 7.4.9+
- MySQL MariaDB 10.4.14+

_Should use Xampp 3.2.4+ (include PHP and MySQL) for developing._

#### Clone repository

```bash
# Clone repository
git clone https://github.com/daomtthuan/ctu-pc-shop.git

# Go to repository dir
cd ctu-pc-shop
```

#### Install Packages for Client

```bash
# From ctu-pc-shop dir go to client dir
cd ./src/client

# Install packages
npm install
# or
yarn install
```

#### Install Packages for Server

```bash
# From ctu-pc-shop dir go to client dir
cd ./src/server
# or from client dir
cd ../server

# Install packages
composer install
```

#### Setup virtual host

_If using Xampp for server,_\
Go to Apache config dir `xampp-dir/apache/conf/`\
Add in file `httpd.conf` at under line `Listen 80`:

```bash
Listen 8000
```

Go to Apache extra config dir `xampp-dir/apache/conf/extra`\
Open file `httpd-vhosts.conf` and add at end of file:

```xml
<VirtualHost *:8000>
  ServerAdmin webmaster@ctu-pc-shop.server.local
  DocumentRoot "repository-dir/src/server"
  ServerName ctu-pc-shop.server.local
  ErrorLog "logs/ctu-pc-shop-error.log"
  CustomLog "logs/ctu-pc-shop-access.log" common

  <Directory "repository-dir/src/server">
    Options FollowSymLinks
    AllowOverride All
    DirectoryIndex index.php
    Require all granted
  </Directory>
</VirtualHost>
```

### Start developing

Run Apache and MySQL and in terminal (cmd) type:

```bash
npm run dev
# or
yarn dev
```

Client will run at [http://localhost:3000/](http://localhost:3000/)\
Server will run at [http://localhost:8000/](http://localhost:8000/)

## Project structure

```bash
ctu-pc-shop ( directories: 21 )
 ├─ design
 ├─ docs
 │ └─ teacher
 └─ src
   ├─ client
   │ ├─ assets
   │ │ └─ styles
   │ ├─ layouts
   │ ├─ pages
   │ └─ static
   ├─ database
   │ ├─ data
   │ ├─ schema
   │ │ └─ tables
   │ └─ script
   └─ server
     ├─ apis
     ├─ assets
     ├─ models
     ├─ providers
     └─ utilities
```
