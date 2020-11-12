# Settings
set names utf8mb4 collate utf8mb4_unicode_ci;
set character set utf8mb4;
set session collation_connection = utf8mb4_unicode_ci;
set time_zone = '+7:00';

use CtuPcShop;

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













        





        
