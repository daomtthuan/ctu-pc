# Settings
set names utf8mb4;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

# Create schema
drop schema if exists CtuPcShop;
create schema CtuPcShop;

use CtuPcShop;

# Create table User
create table User
(
    id       bigint        not null auto_increment, # Id User
    username varchar(100)  not null unique,         # Username User
    password varchar(100)  not null,                # Password User
    fullName nvarchar(100) not null,                # Full name User
    birthday date          not null,                # Birthday User
    gender   bit           not null,                # Gender User (0: female, 1: male)
    email    varchar(100)  not null,                # Email User
    address  text          not null,                # Address User
    phone    varchar(15)   not null,                # Phone number User
    state    bit default 1,                         # State User (0: Disabled, 1: Enabled)

    primary key (id)                                # Id User is primary key
);

# Create table Role
create table Role
(
    id    bigint       not null auto_increment, # Id Role
    name  varchar(100) not null,                # Name Role
    state bit default 1,                        # State Role (0: Disabled, 1: Enabled)

    primary key (id)                            # Id Role is primary key
);

# Create table Permission
create table Permission
(
    id     bigint not null auto_increment,     # Id Permission
    idUser bigint not null,                    # Id User Permission
    idRole bigint not null,                    # Id Role Permission
    state  bit default 1,                      # State Permission (0: Disabled, 1: Enabled)

    primary key (id),                          # Id Role is primary key
    foreign key (idUser) references User (id), # Id User references to table User by Id
    foreign key (idRole) references Role (id)  # Id Role references to table Role by Id
);

# Create table Brand
create table Brand
(
    id    bigint        not null auto_increment, # Id Brand
    name  nvarchar(100) not null,                # Name Brand
    state bit default 1,                         # State Brand (0: Disabled, 1: Enabled)

    primary key (id)                             # Id Brand is primary key
);

# Create table Category Group
create table CategoryGroup
(
    id    bigint        not null auto_increment, # Id Category Group
    name  nvarchar(100) not null,                # Name Category Group
    state bit default 1,                         # State Category Group (0: Disabled, 1: Enabled)

    primary key (id)                             # Id Category Group is primary key
);

# Create table Category
create table Category
(
    id              bigint        not null auto_increment,      # Id Category
    name            nvarchar(100) not null,                     # Name Category
    idCategoryGroup bigint        not null,                     # Id Category Group
    state           bit default 1,                              # State Category (0: Disabled, 1: Enabled)

    primary key (id),                                           # Id Category is primary key
    foreign key (idCategoryGroup) references CategoryGroup (id) # Id Category Group references to table Category Group by Id
);

# Create table Product
create table Product
(
    id         bigint        not null auto_increment,  # Id Product
    name       nvarchar(100) not null,                 # Name Product
    price      float         not null,                 # Price Product
    quantity   int           not null,                 # Quantity Product
    idCategory bigint        not null,                 # Id Category Product
    idBrand    bigint        not null,                 # Id Brand Product
    state      bit default 1,                          # State Product (0: Disabled, 1: Enabled)

    primary key (id),                                  # Id Product is primary key
    foreign key (idCategory) references Category (id), # Id Category references to table Category by Id
    foreign key (idBrand) references Brand (id)        # Id Brand references to table Brand by Id
);

# Create table Review
create table Review
(
    id        bigint  not null auto_increment,      # Id Review
    star      tinyint not null,                     # Star Review
    idUser    bigint  not null,                     # Id User Review
    idProduct bigint  not null,                     # Id Product Review
    state     bit default 1,                        # State Review (0: Disabled, 1: Enabled)

    primary key (id),                               # Id Product is primary key
    foreign key (idUser) references User (id),      # Id User references to table User by Id
    foreign key (idProduct) references Product (id) # Id Product references to table Product by Id
);
