/* Team Members:
Digumarthy Siva Rama Krishna - 8990106
Prakash kalidoss - 8989436
Varshith Reddy Remidi - 8992928 */
<?php
include 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['table'];
 
    if ($table == 'customers') {
        if (isset($_POST['CustomerID'])) {
            $sql = "SELECT * FROM Customers WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_POST['CustomerID']);
            $stmt->execute();
            $result = $stmt->get_result();
 
            if ($result->num_rows > 0) {
                $sql = "UPDATE Customers SET Name = ?, PhoneNumber = ?, Email = ? WHERE CustomerID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $_POST['Name'], $_POST['PhoneNumber'], $_POST['Email'], $_POST['CustomerID']);
                $stmt->execute();
                echo "Customer updated successfully!";
            } else {
                $sql = "INSERT INTO Customers (CustomerID, Name, PhoneNumber, Email) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $_POST['CustomerID'], $_POST['Name'], $_POST['PhoneNumber'], $_POST['Email']);
                $stmt->execute();
                echo "New customer added successfully!";
            }
        }
    }

    elseif ($table == 'orders') {
        if (isset($_POST['OrderID'])) {
            $sql = "SELECT * FROM Orders WHERE OrderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_POST['OrderID']);
            $stmt->execute();
            $result = $stmt->get_result();
 
            if ($result->num_rows > 0) {
                $sql = "UPDATE Orders SET CustomerID = ?, OrderDate = ?, TotalAmount = ? WHERE OrderID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $_POST['CustomerID'], $_POST['OrderDate'], $_POST['TotalAmount'], $_POST['OrderID']);
                $stmt->execute();
                echo "Order updated successfully!";
            } else {
                $sql = "INSERT INTO Orders (OrderID, CustomerID, OrderDate, TotalAmount) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $_POST['OrderID'], $_POST['CustomerID'], $_POST['OrderDate'], $_POST['TotalAmount']);
                $stmt->execute();
                echo "New order added successfully!";
            }
        }
    }

    elseif ($table == 'orderdetails') {
        if (isset($_POST['DetailID'])) {
            $sql = "SELECT * FROM OrderDetails WHERE DetailID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_POST['DetailID']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $sql = "UPDATE OrderDetails SET OrderID = ?, ItemName = ?, Quantity = ?, UnitPrice = ?, TotalPrice = ? WHERE DetailID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $_POST['OrderID'], $_POST['ItemName'], $_POST['Quantity'], $_POST['UnitPrice'], $_POST['TotalPrice'], $_POST['DetailID']);
                $stmt->execute();
                echo "Order details updated successfully!";
            } else {
                $sql = "INSERT INTO OrderDetails (DetailID, OrderID, ItemName, Quantity, UnitPrice, TotalPrice) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $_POST['DetailID'], $_POST['OrderID'], $_POST['ItemName'], $_POST['Quantity'], $_POST['UnitPrice'], $_POST['TotalPrice']);
                $stmt->execute();
                echo "New order details added successfully!";
            }
        }
    }
}
$conn->close();
?>