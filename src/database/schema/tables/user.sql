use ctu_cp_shop;

# Create table User
create table User
(
  id       bigint        not null auto_increment, # Id User
  username varchar(100)  not null,                # Username User
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