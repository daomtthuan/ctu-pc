# Settings
set names utf8mb4 collate utf8mb4_unicode_ci;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

use CtuPcShop;

# Insert User
insert into Account(username, password, fullName, birthday, gender, email, address, phone)
values ('admin', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Tô Chi Thảo', '1993-03-08', 0, 'daomtthuan.admin@gmail.com', N'9 Phố Giáp Thái Chung, Xã 8, Huyện Quang Tuyên Quang', '0292870758');
insert into Account(username, password, fullName, birthday, gender, email, address, phone)
values ('user1', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Nguyễn Trác Vy', '1976-11-21', 0, 'daomtthuan.user@gmail.com', N'597 Phố Chiêu, Thôn Trà Ngọc, Quận Kiên Thừa Thiên Huế', '01886697561'),
       ('user2', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Hà Nghiêm Nương', '1981-02-20', 0, 'daomtthuan.user@gmail.com', N'190 Phố Bồ Toại Trân, Xã Thể, Quận Điền Chiểu Thủy Cần Thơ', '03205219336'),
       ('user3', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Lâm Đường Thạch', '1984-07-07', 1, 'daomtthuan.user@gmail.com', N'901 Phố Cái Duệ Võ, Ấp Cát Vương, Quận Trình Thái Bình', '0586781301'),
       ('user4', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Văn Phước Nữ', '1997-05-26', 0, 'daomtthuan.user@gmail.com', N'0516 Phố Đồng Khôi Chung, Thôn Nghị Xuyến, Quận Tuệ Tường Hà Nội', '02183697771'),
       ('user5', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Bành Ẩn', '1994-05-26', 1, 'daomtthuan.user@gmail.com', N'4668 Phố Liễu, Phường Thiên Thiên, Quận Đôn Ngọc Miên Hồ Chí Minh', '02300532958');

update table Account set state = 0 where id = 4;

# Insert Permission
insert into Permission(idAccount, idRole)
values (1, 1);
insert into Permission(idAccount, idRole)
values (1, 2),
       (2, 2),
       (3, 2),
       (4, 2),
       (5, 2),
       (6, 2);

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
values (N'Bàn', 3),
       (N'Ghế', 3);
insert into Category(name, idCategoryGroup)
values (N'Máy chơi game', 4),
       (N'Đĩa game', 4),
       (N'Phụ kiện PS4', 4),
       (N'Gaming Accs', 4);
insert into Category(name, idCategoryGroup)
values (N'Máy tính đồng bộ', 5),
       (N'Máy tính xách tay', 5);
insert into Category(name, idCategoryGroup)
values (N'Balo', 6),
       (N'Mic thu thanh', 6),
       (N'Chiếu sáng LED', 6),
       (N'Thiết bị ghi hình', 6),
       (N'Hub-Cable-AIC', 6),
       (N'Đồ chơi stream', 6);
