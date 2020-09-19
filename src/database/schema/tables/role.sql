use ctu_cp_shop;

# Create table Role
create table table_role
(
  id    bigint       not null auto_increment, # Id Role
  name  varchar(100) not null,                # Name Role
  state bit,                                  # State Role (0: Disabled, 1: Enabled)

  primary key (id)                            # Id Role is primary key
);