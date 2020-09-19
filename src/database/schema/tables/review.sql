use ctu_cp_shop;

# Create table Review
create table table_review
(
  id         bigint  not null auto_increment,            # Id Review
  star       tinyint not null,                           # Star Review
  id_user    bigint  not null,                           # Id User Review
  id_product bigint  not null,                           # Id Product Review
  state      bit,                                        # State Review (0: Disabled, 1: Enabled)

  primary key (id),                                      # Id Product is primary key
  foreign key (id_user) references table_user (id),      # Id User references to table User by Id
  foreign key (id_product) references table_product (id) # Id Product references to table Product by Id
);