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

## Documentations

Development Plan:
[view details](./docs/export/DevelopmentPlan_KeHoachPhatTrien.pdf)

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
Add in file `httpd.conf` under line `Listen 80`:

```bash
Listen 8000
```

Go to Apache extra config dir `xampp-dir/apache/conf/extra`\
Open file `httpd-vhosts.conf` and add at end of file:

```xml
<VirtualHost *:8000>
  DocumentRoot "repository-dir\\src\\server"
  <Directory "repository-dir\\src\\server">
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

```pre
ctu-pc-shop ( directories: 34 )
 ├─ design
 │ ├─ documentation
 │ └─ user-interface
 ├─ docs
 │ ├─ export
 │ ├─ teacher
 │ └─ work
 └─ src
   ├─ client
   │ ├─ @types
   │ ├─ asset
   │ │ └─ styles
   │ ├─ component
   │ │ ├─ form
   │ │ └─ guide-policy
   │ ├─ layout
   │ ├─ page
   │ │ ├─ admin
   │ │ └─ guide-policy
   │ ├─ plugin
   │ ├─ static
   │ └─ store
   ├─ database
   └─ server
     ├─ api
     │ ├─ authentication
     │ └─ user
     ├─ core
     ├─ entity
     ├─ log
     │ └─ service
     ├─ provider
     ├─ static
     └─ temp
```
