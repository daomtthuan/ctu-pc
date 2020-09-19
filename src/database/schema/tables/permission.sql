use ctu_cp_shop;

# Create table Permission
create table table_permission
(
  id      bigint not null auto_increment,           # Id Permission
  id_user bigint not null,                          # Id User Permission
  id_role bigint not null,                          # Id Role Permission
  state   bit,                                      # State Permission (0: Disabled, 1: Enabled)

  primary key (id),                                 # Id Role is primary key
  foreign key (id_user) references table_user (id), # Id User references to table User by Id
  foreign key (id_role) references table_role (id)  # Id Role references to table Role by Id
);