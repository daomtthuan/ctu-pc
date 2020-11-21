# Settings
set names utf8mb4 collate utf8mb4_unicode_ci;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

use CtuPcShop;

# Insert Role
insert into Role(name)
values ('Admin'),
       ('User');

# Insert User
insert into Account(username, password, fullName, birthday, gender, email, address, phone)
values ('admin', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Tô Chi Thảo', '1993-03-08', 0, 'daomtthuan.admin@gmail.com', N'9 Phố Giáp Thái Chung, Xã 8, Huyện Quang Tuyên Quang', '0292870758');
insert into Account(username, password, fullName, birthday, gender, email, address, phone)
values ('user1', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Nguyễn Trác Vy', '1976-11-21', 0, 'daomtthuan.user@gmail.com', N'597 Phố Chiêu, Thôn Trà Ngọc, Quận Kiên Thừa Thiên Huế', '01886697561'),
       ('user2', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Hà Nghiêm Nương', '1981-02-20', 0, 'daomtthuan.user@gmail.com', N'190 Phố Bồ Toại Trân, Xã Thể, Quận Điền Chiểu Thủy Cần Thơ', '03205219336'),
       ('user3', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Lâm Đường Thạch', '1984-07-07', 1, 'daomtthuan.user@gmail.com', N'901 Phố Cái Duệ Võ, Ấp Cát Vương, Quận Trình Thái Bình', '0586781301'),
       ('user4', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Văn Phước Nữ', '1997-05-26', 0, 'daomtthuan.user@gmail.com', N'0516 Phố Đồng Khôi Chung, Thôn Nghị Xuyến, Quận Tuệ Tường Hà Nội', '02183697771'),
       ('user5', '$2y$10$7HNWqbfvE6LbNVVE8329fONjrBhGlZbZP/OHwZbeSeSNu3z77gTlO', N'Bành Ẩn', '1994-05-26', 1, 'daomtthuan.user@gmail.com', N'4668 Phố Liễu, Phường Thiên Thiên, Quận Đôn Ngọc Miên Hồ Chí Minh', '02300532958');

update Account set state = false where id = 4;

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

# Insert Brand
insert into Brand(name)
values ('Intel'),
		('ARES'),
        ('ASUS'),
        ('Microsoft'),
        ('Logitech'),
        ('Dell'),
        ('Blaster'),
        ('MSI'),
        ('APC'),
        ('Marvel'),
        ('Slim'),
        ('CORSAIR');

#Insert Product
insert into Product(name, price, quantity, idCategory, idBrand)
values 	(N'Intel 10th Gen Core i9-10850K Processor – Unlocked',12990,100,1,1),
		(N'ASUS ROG MAXIMUS XII EXTREME Mainboard – Z490 Chipset',17900,100,2,3),
		(N'ASUS TUF Gaming Geforce RTX 3090 24G Graphics Card',42800,100,3,3),
        (N'CORSAIR VENGEANCE RGB PRO Memory Kit – Black, 32GB',4900,100,4,12),
        (N'MSI Core Frozr S Air Cooler',1120,100,5,8),
        (N'Intel Optane Memory M10 Series 16GB SSD – 16GB, M.2 80mm PCIe 3.0, 20nm, 3D XPoint',990,100,6,1),
        (N'ASUS ROG Strix Helios Case – White',6690,100,7,3),
        (N'ASUS ROG Thor 850P PSU – 850W, 80Plus Platium, Full Modular, Sleeve Cable, AURA Sync',5790,100,8,3),
        (N'Creative Sound BlasterX AE-5 RGB Sound Card',3190,100,9,7),
        (N'ARES AR630 UPS – 3000VA, 2400W',8290,100,10,2),
        (N'ASUS ROG Strix Z490-I Gaming Mainboard',6890,100,11,3),
        (N'ASUS ROG Strix XG49VQ SUPER Ultra-Wide Gaming Monitor – 49″, DFHD, 144Hz, 1ms, HDR400, FreeSync 2',26990,100,12,3),
        (N'ASUS ROG Strix Scope Gaming Keyboard – Red Switch',3190,100,13,3),
        (N'ASUS ROG Chakram RGB Gaming Mouse',3890,100,14,3),
        (N'ASUS ROG Theta 7.1 Surround Gaming Headset',6890,100,15,3),
        (N'ASUS ROG Rapture GT-AC2900 Gaming Router – 750+2167Mbps, AiMesh, AURA RGB',5490,100,16,3),
        (N'Speed R1 Gaming Desk',2190,100,17,9),
        (N'ASUS ROG Chariot SL300C RGB Gaming Chair',15490,100,18,3),
        (N'Microsoft Xbox One S Controller – Phantom Black',2090,100,19,4),
        (N'Marvel’s Spider-Man Game Disc',550,100,20,10),
        (N'Đế Tản Nhiệt Kèm Khay Đựng Đĩa Game Cho Máy PS4 Pro & PS4 Slim',350,100,21,11),
        (N'Logitech G29 Driving Force Racing Wheel',6979,100,22,5),
        (N'Dell Vostro 3470ST (HXKWJ1) Desktop PC',7250,100,23,6),
        (N'Laptop Dell G3 Inspiron 3579 70167040 (Black) Geforce GTX1050Ti 4GB Intel Core i7 8750H 128GB 8GB',23490,100,24,6),
        (N'ASUS ROG Ranger BP3703 Gaming Backpack – Balo Gaming',6490,100,25,3);

#Insert Event
insert into Event(title, post, idAccount)
values 	(N'Mua Card đồ họa ASUS NVIDIA Geforce nhận ngay Combo quà', '2020-11-19', 1),
		(N'TIỀN NHIỀU ĐỂ LÀM GÌ?', '2020-11-18', 1),
        (N'ASUS Combo ROG Hủy Diệt Tháng 11', '2020-11-16', 1),
        (N'Đồng Hành Cùng Combo AORUS PC', '2020-11-15', 1),
        (N'Rinh PC ITX nhận Combo Wireless', '2020-11-14', 1);
