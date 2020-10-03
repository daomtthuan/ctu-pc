use CtuPcShop;

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
