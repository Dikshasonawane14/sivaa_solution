<?php include 'connect.php'; ?>

<?php

$sql = "SELECT `ProductTitle`, `ProductDatetime`, `ProductRate`, `BalanceQuantity` FROM prod_info";
$result = $con->query($sql);

// CSV download logic
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Set headers to trigger CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="products_report.csv"');
    
    // Open PHP output stream for CSV
    $output = fopen('php://output', 'w');
    
    // Write the CSV header row
    fputcsv($output, ['Product Title', 'Product Date', 'Product Rate', 'Balance Quantity']);
    
    // Check if there are rows and write them to CSV
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);  // Write each row to the CSV
        }
    } else {
        // In case no products are found in the database
        fputcsv($output, ["No records found"]);
    }
    
    // Close the output stream
    fclose($output);
    exit();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .report-container {
            text-align: center;
            padding-top: 50px;
        }
        
        .main-content {
            margin-left: 220px; /* Sidebar offset */
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <?php include('sidebar.php');?>
  

    <!-- Main Content -->
    <div class="main-content">
        <div class="container report-container">
            <h1 class="mb-4">Product Registration Report</h1>
            <p>Click the button below to download the product registration report as a CSV file.</p>
            <!-- Button to trigger CSV download -->
            <a href="report.php?download=csv" class="btn btn-success btn-lg">Download CSV</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
