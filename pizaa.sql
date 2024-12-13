-- Create Database
CREATE DATABASE PizzaStore;

-- Use the Database
USE PizzaStore;

-- Create Customers Table
CREATE TABLE Customers (
    CustomerID VARCHAR(10) PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    Email VARCHAR(100)
);

-- Create Orders Table
CREATE TABLE Orders (
    OrderID VARCHAR(10) PRIMARY KEY,
    CustomerID VARCHAR(10),
    OrderDate DATE NOT NULL,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

-- Create OrderDetails Table
CREATE TABLE OrderDetails (
    DetailID VARCHAR(10) PRIMARY KEY,
    OrderID VARCHAR(10),
    ItemName VARCHAR(100) NOT NULL,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(10, 2) NOT NULL,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
);


-- Insert Data into Customers Table
INSERT INTO Customers (CustomerID, Name, PhoneNumber, Email)
VALUES 
('C001', 'Virat', '3456178764', 'vk@gmail.com'),
('C002', 'Dhoni', '4321234121', 'dhoni@gmail.com'),
('C003', 'Gilchrist', '4532123441', 'christ@gmail.com'),
('C004', 'Travis', '8753244222', 'travis@gmail.com'),
('C005', 'Ab de villers', '4312384567', 'abde@gmail.com');

-- Insert Data into Orders Table
INSERT INTO Orders (OrderID, CustomerID, OrderDate, TotalAmount)
VALUES 
('O001', 'C001', '2024-11-30', 50.00),
('O002', 'C002', '2024-11-29', 75.50),
('O003', 'C003', '2024-11-28', 60.00),
('O004', 'C004', '2024-11-27', 90.25),
('O005', 'C005', '2024-11-26', 45.00);

-- Insert Data into OrderDetails Table
INSERT INTO OrderDetails (DetailID, OrderID, ItemName, Quantity, UnitPrice, TotalPrice)
VALUES 
('D001', 'O001', 'Pepperoni Pizza', 1, 15.00, 15.00),
('D002', 'O001', 'Garlic Bread', 2, 5.00, 10.00),
('D003', 'O002', 'Margherita Pizza', 1, 12.50, 12.50),
('D004', 'O002', 'Cheese Sticks', 1, 8.00, 8.00),
('D005', 'O002', 'Soft Drink', 3, 5.00, 15.00),
('D006', 'O003', 'Veggie Pizza', 1, 18.00, 18.00),
('D007', 'O004', 'BBQ Chicken Pizza', 2, 20.00, 40.00),
('D008', 'O005', 'Hawaiian Pizza', 1, 25.00, 25.00);
