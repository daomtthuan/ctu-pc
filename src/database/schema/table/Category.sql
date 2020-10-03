use CtuPcShop;

# Create table Category
create table Category
(
    id              bigint        not null auto_increment,      # Id Category
    name            nvarchar(100) not null,                     # Name Category
    state           bit default 1,                              # State Category (0: Disabled, 1: Enabled)
    idCategoryGroup bigint        not null,                     # Id Category Group

    primary key (id),                                           # Id Category is primary key
    foreign key (idCategoryGroup) references CategoryGroup (id) # Id Category Group references to table Category Group by Id
);
