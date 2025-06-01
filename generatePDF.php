<?php
// Include the FPDF library
require('./fpdf186/fpdf.php');

// Create instance of the FPDF class
$pdf = new FPDF();

// Add a page
$pdf->AddPage();

// Set Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Order Confirmation', 0, 1, 'C'); // Centered title
$pdf->Ln(10);

// Fetch order details (replace with actual data)
$orderDetails = [
    'name' => 'John Doe',
    'number' => '123-456-7890',
    'email' => 'johndoe@example.com',
    'payment_method' => 'Credit Card',
    'address' => '1234 Elm Street',
    'city' => 'Los Angeles',
    'state' => 'CA',
    'country' => 'USA',
    'zip_code' => '90001',
    'items' => [
        ['item' => 'Smartphone', 'qty' => 2, 'price' => 300],
        ['item' => 'Headphones', 'qty' => 1, 'price' => 100],
    ],
    'total_price' => 700
];

// Set font for the details section
$pdf->SetFont('Arial', '', 12);

// Print Customer Information
$pdf->Cell(40, 10, 'Name: ' . $orderDetails['name']);
$pdf->Ln(7);
$pdf->Cell(40, 10, 'Phone Number: ' . $orderDetails['number']);
$pdf->Ln(7);
$pdf->Cell(40, 10, 'Email: ' . $orderDetails['email']);
$pdf->Ln(7);
$pdf->Cell(40, 10, 'Payment Method: ' . $orderDetails['payment_method']);
$pdf->Ln(7);

// Print Address Information
$pdf->Ln(5); // Line break for section separation
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Shipping Address:');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(7);
$pdf->Cell(40, 10, $orderDetails['address']);
$pdf->Ln(7);
$pdf->Cell(40, 10, $orderDetails['city'] . ', ' . $orderDetails['state'] . ', ' . $orderDetails['country']);
$pdf->Ln(7);
$pdf->Cell(40, 10, 'Zip Code: ' . $orderDetails['zip_code']);
$pdf->Ln(10);

// Order Items
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Order Items', 0, 1, 'C');
$pdf->Ln(5);

// Table header for items
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Item', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Price (USD)', 1);
$pdf->Ln();

// Table rows with item details
$pdf->SetFont('Arial', '', 12);
foreach ($orderDetails['items'] as $item) {
    $pdf->Cell(90, 10, $item['item'], 1);
    $pdf->Cell(30, 10, $item['qty'], 1, 0, 'C');
    $pdf->Cell(40, 10, '$' . number_format($item['price'], 2), 1, 0, 'R');
    $pdf->Ln();
}

// Total Price
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(120, 10, 'Total Price:', 1);
$pdf->Cell(40, 10, '$' . number_format($orderDetails['total_price'], 2), 1, 0, 'R');
$pdf->Ln(10);

// Output the PDF to browser
$pdf->Output('I', 'order_confirmation.pdf');
?>
