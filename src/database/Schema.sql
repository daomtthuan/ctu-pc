-- Settings
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
SET CHARACTER SET utf8mb4;
SET SESSION collation_connection = utf8mb4_unicode_ci;
SET time_zone = '+7:00';

-- Create schema
DROP DATABASE IF EXISTS CtuPcShop;
CREATE DATABASE CtuPcShop;

USE CtuPcShop;

-- Create table Account
CREATE TABLE Account (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    fullName NVARCHAR(100) NOT NULL,
    birthday DATE NOT NULL,
    gender BIT NOT NULL, -- TRUE: Male, FALSE: Female
    email VARCHAR(100) NOT NULL,
    address NVARCHAR(500) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Role
CREATE TABLE Role (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Permission
CREATE TABLE Permission (
    id INT NOT NULL AUTO_INCREMENT,
    idAccount INT NOT NULL,
    idRole INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idRole)
        REFERENCES Role (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table Brand
CREATE TABLE Brand (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Category Group
CREATE TABLE CategoryGroup (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Category
CREATE TABLE Category (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    idCategoryGroup INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idCategoryGroup)
        REFERENCES CategoryGroup (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table Product
CREATE TABLE Product (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    price FLOAT NOT NULL,
    quantity INT NOT NULL,
    idCategory INT NOT NULL,
    idBrand INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idCategory)
        REFERENCES Category (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idBrand)
        REFERENCES Brand (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table Review
CREATE TABLE Review (
    id INT NOT NULL AUTO_INCREMENT,
    star TINYINT NOT NULL,
    content NVARCHAR(500),
    idAccount INT NOT NULL,
    idProduct INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idProduct)
        REFERENCES Product (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table Event
CREATE TABLE Event (
    id INT NOT NULL AUTO_INCREMENT,
    title NVARCHAR(100) NOT NULL,
    post DATE NOT NULL DEFAULT NOW(),
    idAccount INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table Bill
CREATE TABLE Bill (
    id INT NOT NULL AUTO_INCREMENT,
    idAccount INT NOT NULL,
    createDate DATE NOT NULL DEFAULT NOW(),
    payDate DATE,
    status INT NOT NULL DEFAULT 0, -- 0: Pending, 1: Shipping, 2: Paid, 3: Cancel
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;

-- Create table ProductCart
CREATE TABLE ProductCart (
		id INT NOT NULL AUTO_INCREMENT,
    idBill INT NOT NULL,
    idProduct INT NOT NULL,
    quantity INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE, -- TRUE: Enabled, FALSE: Disabled
    PRIMARY KEY (id),
    FOREIGN KEY (idBill)
        REFERENCES Bill (id)
        ON DELETE CASCADE,
		FOREIGN KEY (idProduct)
        REFERENCES Product (id)
        ON DELETE CASCADE
)  ENGINE=INNODB;