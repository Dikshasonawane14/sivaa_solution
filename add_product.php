<?php include 'connect.php'; ?>

<?php
if (isset($_POST['Submit'])) {
    // Collect form data
    $productTitle = $_POST['ProductTitle'];
    $productDescription = $_POST['ProductDescription'];
    $productDateTime = $_POST['ProductDateTime'];
    $productRate = $_POST['ProductRate'];
    $productMRP = $_POST['ProductMRP'];
    $balanceQuantity = $_POST['BalanceQuantity'];
    $status = $_POST['Status'];

    // SQL Query to insert data
    $sql = "INSERT INTO `prod_info` (`ProductTitle`, `ProductDescription`, `ProductDateTime`, `ProductRate`, `ProductMRP`, `BalanceQuantity`, `Status`) 
            VALUES ('$productTitle', '$productDescription', '$productDateTime', '$productRate', '$productMRP', '$balanceQuantity', '$status')";

    $res = mysqli_query($con, $sql);

    if ($res) {
        ?>
        <script type="text/javascript">
            alert("Data Saved Successfully");
            window.location.href = "view_product.php";
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            alert("Failed to save data. Please try again.");
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2">
                <?php include 'sidebar.php'; ?>
            </div>
            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4">
                <h1>Add Product</h1>
                <form method="POST">
                    <div class="mb-3">
                        <label for="ProductTitle" class="form-label">Product Title</label>
                        <input type="text" class="form-control" name="ProductTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" name="ProductDescription" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ProductDateTime" class="form-label">Date and Time</label>
                        <input type="datetime-local" class="form-control" name="ProductDateTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductRate" class="form-label">Rate</label>
                        <input type="number" class="form-control" name="ProductRate" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductMRP" class="form-label">MRP</label>
                        <input type="number" class="form-control" name="ProductMRP" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="BalanceQuantity" class="form-label">Balance Quantity</label>
                        <input type="number" class="form-control" name="BalanceQuantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-select" name="Status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="Submit" class="btn btn-primary">Add Product</button>
                </form>
            </main>
        </div>
    </div>
</body>
</html>
