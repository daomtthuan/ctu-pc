# Settings
set names utf8mb4 collate utf8mb4_unicode_ci;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

# Create schema
drop schema if exists CtuPcShop;
create schema CtuPcShop;

use CtuPcShop;

# Create table Account
create table Account
(
  id       int           not null auto_increment, # Id Account
  username varchar(100)  not null unique,         # Username Account
  password varchar(100)  not null,                # Password Account
  fullName nvarchar(100) not null,                # Full name Account
  birthday date          not null,                # Birthday Account
  gender   bit           not null,                # Gender Account (false: female, true: male)
  email    varchar(100)  not null,                # Email Account
  address  nvarchar(500) not null,                # Address Account
  phone    varchar(15)   not null,                # Phone number Account
  state    bit           not null default true,   # State Account (false: Disabled, true: Enabled)

  primary key (id)                                # Id Account is primary key
);

# Create table Role
create table Role
(
  id    int          not null auto_increment, # Id Role
  name  varchar(100) not null,                # Name Role
  state bit          not null default true,   # State Role (0: Disabled, 1: Enabled)

  primary key (id)                            # Id Role is primary key
);

# Create table Permission
create table Permission
(
  id        int not null auto_increment,           # Id Permission
  idAccount int not null,                          # Id Account Permission
  idRole    int not null,                          # Id Role Permission
  state     bit not null default true,             # State Permission (0: Disabled, 1: Enabled)

  primary key (id),                                # Id Role is primary key
  foreign key (idAccount) references Account (id), # Id Account references to table Account by Id
  foreign key (idRole) references Role (id)        # Id Role references to table Role by Id
);

# Create table Brand
create table Brand
(
  id    int           not null auto_increment, # Id Brand
  name  nvarchar(100) not null,                # Name Brand
  state bit           not null default true,   # State Brand (0: Disabled, 1: Enabled)

  primary key (id)                             # Id Brand is primary key
);

# Create table Category Group
create table CategoryGroup
(
  id    int           not null auto_increment, # Id Category Group
  name  nvarchar(100) not null,                # Name Category Group
  state bit           not null default true,   # State Category Group (0: Disabled, 1: Enabled)

  primary key (id)                             # Id Category Group is primary key
);

# Create table Category
create table Category
(
  id              int           not null auto_increment,      # Id Category
  name            nvarchar(100) not null,                     # Name Category
  idCategoryGroup int           not null,                     # Id Category Group
  state           bit           not null default true,        # State Category (0: Disabled, 1: Enabled)

  primary key (id),                                           # Id Category is primary key
  foreign key (idCategoryGroup) references CategoryGroup (id) # Id Category Group references to table Category Group by Id
);

# Create table Product
create table Product
(
  id         int           not null auto_increment,  # Id Product
  name       nvarchar(100) not null,                 # Name Product
  price      float         not null,                 # Price Product
  quantity   int           not null,                 # Quantity Product
  idCategory int           not null,                 # Id Category Product
  idBrand    int           not null,                 # Id Brand Product
  state      bit           not null default true,    # State Product (0: Disabled, 1: Enabled)

  primary key (id),                                  # Id Product is primary key
  foreign key (idCategory) references Category (id), # Id Category references to table Category by Id
  foreign key (idBrand) references Brand (id)        # Id Brand references to table Brand by Id
);

# Create table Review
create table Review
(
  id        int     not null auto_increment,       # Id Review
  star      tinyint not null,                      # Star Review
  idAccount int     not null,                      # Id Account Review
  idProduct int     not null,                      # Id Product Review
  state     bit     not null default true,         # State Review (0: Disabled, 1: Enabled)

  primary key (id),                                # Id Product is primary key
  foreign key (idAccount) references Account (id), # Id Account references to table Account by Id
  foreign key (idProduct) references Product (id)  # Id Product references to table Product by Id
);

# Create table Event
create table Event
(
  id        int           not null auto_increment, # Id Event
  title     nvarchar(100) not null,                # Title Event
  post      date          not null default now(),  # Posted date Event
  idAccount int           not null,                # Id account author Event
  state     bit           not null default true,   # State Event (0: Disabled, 1: Enabled)

  primary key (id),                                # Id Product is primary key
  foreign key (idAccount) references Account (id)  # Id Account references to table Account by Id
);
