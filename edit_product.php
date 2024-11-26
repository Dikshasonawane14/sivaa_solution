<?php
include 'connect.php';

$productId = $_GET['id'] ?? null;

// Fetch product details if an ID is provided
if ($productId) {
    $query = "SELECT * FROM prod_info WHERE id = $productId";
    $result = $con->query($query);
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "<script>alert('Product not found'); window.location.href='view_product.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid Product ID'); window.location.href='view_product.php';</script>";
    exit();
}

// Update product details on form submission
if (isset($_POST['Update'])) {
    $productTitle = $_POST['ProductTitle'];
    $productDescription = $_POST['ProductDescription'];
    $productDateTime = $_POST['ProductDateTime'];
    $productRate = $_POST['ProductRate'];
    $productMRP = $_POST['ProductMRP'];
    $balanceQuantity = $_POST['BalanceQuantity'];
    $status = $_POST['Status'];

    $updateQuery = "
        UPDATE `prod_info` 
        SET 
            `ProductTitle` = '$productTitle',
            `ProductDescription` = '$productDescription',
            `ProductDateTime` = '$productDateTime',
            `ProductRate` = '$productRate',
            `ProductMRP` = '$productMRP',
            `BalanceQuantity` = '$balanceQuantity',
            `Status` = '$status'
        WHERE `id` = $productId
    ";

    if ($con->query($updateQuery)) {
        echo "<script>alert('Product updated successfully'); window.location.href='view_product.php';</script>";
    } else {
        echo "<script>alert('Failed to update product');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
   <?php include('sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Edit Product</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="ProductTitle" class="form-label">Product Title</label>
                <input type="text" class="form-control" name="ProductTitle" value="<?= $product['ProductTitle'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="ProductDescription" class="form-label">Description</label>
                <textarea class="form-control" name="ProductDescription" rows="4" required><?= $product['ProductDescription'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ProductDateTime" class="form-label">Date and Time</label>
                <input type="datetime-local" class="form-control" name="ProductDateTime" value="<?= date('Y-m-d\TH:i', strtotime($product['ProductDateTime'])) ?>" required>
            </div>
            <div class="mb-3">
                <label for="ProductRate" class="form-label">Rate</label>
                <input type="number" class="form-control" name="ProductRate" step="0.01" value="<?= $product['ProductRate'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="ProductMRP" class="form-label">MRP</label>
                <input type="number" class="form-control" name="ProductMRP" step="0.01" value="<?= $product['ProductMRP'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="BalanceQuantity" class="form-label">Balance Quantity</label>
                <input type="number" class="form-control" name="BalanceQuantity" value="<?= $product['BalanceQuantity'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="Status" class="form-label">Status</label>
                <select class="form-select" name="Status" required>
                    <option value="active" <?= $product['Status'] == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $product['Status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" name="Update" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
