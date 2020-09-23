use ctu_cp_shop;

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