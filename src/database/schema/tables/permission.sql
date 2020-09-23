use ctu_cp_shop;

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