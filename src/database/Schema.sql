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
    gender BIT NOT NULL,
    email VARCHAR(100) NOT NULL,
    address NVARCHAR(500) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Role
CREATE TABLE Role (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)  ENGINE=INNODB;

-- Create table Permission
CREATE TABLE Permission (
    id INT NOT NULL AUTO_INCREMENT,
    idAccount INT NOT NULL,
    idRole INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idRole)
        REFERENCES Role (id)
        ON DELETE CASCADE
);

-- Create table Brand
CREATE TABLE Brand (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
);

-- Create table Category Group
CREATE TABLE CategoryGroup (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
);

-- Create table Category
CREATE TABLE Category (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    idCategoryGroup INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (idCategoryGroup)
        REFERENCES CategoryGroup (id)
        ON DELETE CASCADE
);

-- Create table Product
CREATE TABLE Product (
    id INT NOT NULL AUTO_INCREMENT,
    name NVARCHAR(100) NOT NULL,
    price FLOAT NOT NULL,
    quantity INT NOT NULL,
    idCategory INT NOT NULL,
    idBrand INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (idCategory)
        REFERENCES Category (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idBrand)
        REFERENCES Brand (id)
        ON DELETE CASCADE
);

-- Create table Review
CREATE TABLE Review (
    id INT NOT NULL AUTO_INCREMENT,
    star TINYINT NOT NULL,
    content NVARCHAR(500),
    idAccount INT NOT NULL,
    idProduct INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE,
    FOREIGN KEY (idProduct)
        REFERENCES Product (id)
        ON DELETE CASCADE
);

-- Create table Event
CREATE TABLE Event (
    id INT NOT NULL AUTO_INCREMENT,
    title NVARCHAR(100) NOT NULL,
    post DATE NOT NULL DEFAULT NOW(),
    idAccount INT NOT NULL,
    state BIT NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (idAccount)
        REFERENCES Account (id)
        ON DELETE CASCADE
);
