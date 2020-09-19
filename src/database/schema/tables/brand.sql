use ctu_cp_shop;

# Create table Brand
create table table_brand
(
  id    bigint        not null auto_increment, # Id Brand
  name  nvarchar(100) not null,                # Name Brand
  state bit,                                   # State Brand (0: Disabled, 1: Enabled)

  primary key (id)                             # Id Brand is primary key
);