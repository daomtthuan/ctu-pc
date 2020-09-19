use ctu_cp_shop;

# Create table Product
create table table_product
(
  id          bigint        not null auto_increment,        # Id Product
  name        nvarchar(100) not null,                       # Name Product
  price       float         not null,                       # Price Product
  quantity    int           not null,                       # Quantity Product
  id_category bigint        not null,                       # Id Category Product
  id_brand    bigint        not null,                       # Id Brand Product
  state       bit,                                          # State Product (0: Disabled, 1: Enabled)

  primary key (id),                                         # Id Product is primary key
  foreign key (id_category) references table_category (id), # Id Category references to table Category by Id
  foreign key (id_brand) references table_brand (id)        # Id Brand references to table Brand by Id
);