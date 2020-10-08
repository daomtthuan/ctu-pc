# Settings
set names utf8mb4;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

use CtuPcShop;

# Insert data Category Group
insert into CategoryGroup(name)
values (N'Linh kiện'),
       (N'Thiết bị'),
       (N'Bàn ghế'),
       (N'Máy chơi Game'),
       (N'Máy tính'),
       (N'Phụ kiện');

# Insert data Category
insert into Category(name, idCategoryGroup)
values (N'Vi xử lý', 1),
       (N'Bo mạch chủ', 1),
       (N'Card đồ hoạ', 1),
       (N'Bộ nhớ', 1),
       (N'Tản nhiệt', 1),
       (N'Lưu trữ', 1),
       (N'Vỏ máy tính', 1),
       (N'Nguồn', 1),
       (N'Card âm thanh', 1),
       (N'Bộ lưu điện', 1),
       (N'ITX', 1);
insert into Category(name, idCategoryGroup)
values (N'Màn hình', 2),
       (N'Bàn phím', 2),
       (N'Chuột', 2),
       (N'Tai nghe', 2),
       (N'Thiết bị mạng', 2);
insert into Category(name, idCategoryGroup)
values (N'Bàn'3),
       (N'Ghế'3);
insert into Category(name, idCategoryGroup)
values (N'Máy chơi game'4),
       (N'Đĩa game'4),
       (N'Phụ kiện PS4'4),
       (N'Gaming Accs'4);
insert into Category(name, idCategoryGroup)
values (N'Máy tính đồng bộ'5),
       (N'Máy tính xách tay'5);
insert into Category(name, idCategoryGroup)
values (N'Balo'6),
       (N'Mic thu thanh'6),
       (N'Chiếu sáng LED'6),
       (N'Thiết bị ghi hình'6),
       (N'Đồ chơi stream'6);
