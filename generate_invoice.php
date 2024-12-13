
<?php
include 'db.php';
require('fpdf/fpdf.php');
 
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 40);
        $this->Cell(0, 15, 'INVOICE', 0, 1, 'L');
        $this->Image('logo/logo.png', 180, 10, 20, 20);
        $this->Ln(10);
    }
 
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'NewYorkPizza makes it easier to get paid faster.', 0, 0, 'C');
    }
}
 
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $queryOrder = "
        SELECT
            o.OrderID,
            c.Name AS CustomerName,
            c.PhoneNumber,
            o.OrderDate,
            o.TotalAmount
        FROM Orders o
        JOIN Customers c ON o.CustomerID = c.CustomerID
        WHERE o.OrderID = ?";
    $stmtOrder = $conn->prepare($queryOrder);
    $stmtOrder->bind_param("s", $order_id);
    $stmtOrder->execute();
    $orderResult = $stmtOrder->get_result()->fetch_assoc();
 
    $queryDetails = "
        SELECT
            ItemName,
            Quantity,
            UnitPrice,
            TotalPrice
        FROM OrderDetails
        WHERE OrderID = ?";
    $stmtDetails = $conn->prepare($queryDetails);
    $stmtDetails->bind_param("s", $order_id);
    $stmtDetails->execute();
    $detailsResult = $stmtDetails->get_result();
 
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0);
    $pdf->Cell(50, 8, 'Invoice number', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 8, $orderResult['OrderID'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 8, 'Date of issue', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, date('Y-m-d'), 0, 1, 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(95, 6, 'Billed to', 0, 0, 'L');
    $pdf->Cell(95, 6, 'NewYorkPizza', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 6, $orderResult['CustomerName'], 0, 0, 'L');
    $pdf->Cell(95, 6, '299 Doon Valley Dr, Kitchener, ON N2G 4M4', 0, 1, 'L');
    $pdf->Cell(95, 6, 'Phone: ' . $orderResult['PhoneNumber'], 0, 0, 'L');
    $pdf->Cell(95, 6, '564-555-1234', 0, 1, 'L');
    $pdf->Ln(10);
    $pdf->SetFillColor(230, 240, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 8, 'Description', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Unit Cost', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Quantity', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Amount', 1, 1, 'C', true);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(248, 255, 248);
    $fill = false;
    while ($row = $detailsResult->fetch_assoc()) {
        $pdf->Cell(80, 8, $row['ItemName'], 1, 0, 'L', $fill);
        $pdf->Cell(30, 8, '$' . number_format($row['UnitPrice'], 2), 1, 0, 'C', $fill);
        $pdf->Cell(30, 8, $row['Quantity'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 8, '$' . number_format($row['TotalPrice'], 2), 1, 1, 'C', $fill);
        $fill = !$fill;
    }
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(140, 8, 'Subtotal', 0, 0, 'R');
    $pdf->Cell(40, 8, '$' . number_format($orderResult['TotalAmount'], 2), 1, 1, 'C');
    $pdf->Cell(140, 8, 'Discount', 0, 0, 'R');
    $pdf->Cell(40, 8, '$0.00', 1, 1, 'C');
    $pdf->Cell(140, 8, 'Tax (0%)', 0, 0, 'R');
    $pdf->Cell(40, 8, '$0.00', 1, 1, 'C');
    $pdf->SetFillColor(200, 250, 200); 
    $pdf->Cell(140, 8, 'Invoice Total', 0, 0, 'R');
    $pdf->Cell(40, 8, '$' . number_format($orderResult['TotalAmount'], 2), 1, 1, 'C', true);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(0, 5, 'Terms: Please pay invoice by ' . date('Y-m-d', strtotime('+7 days')), 0, 1, 'L');
 
    $pdf->Output('I', 'Invoice_' . $orderResult['CustomerName'] . '.pdf');
} else {
    echo "Order ID not provided!";
}
?>