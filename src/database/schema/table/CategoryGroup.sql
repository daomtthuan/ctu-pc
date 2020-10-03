use CtuPcShop;

# Create table Category Group
create table CategoryGroup
(
  id    bigint        not null auto_increment, # Id Category Group
  name  nvarchar(100) not null,                # Name Category Group
  state bit default 1,                         # State Category Group (0: Disabled, 1: Enabled)

  primary key (id)                             # Id Category Group is primary key
);
