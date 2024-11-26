<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Status</title>
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
                <h1>Product Status</h1>
                <h3>Active Products</h3>
                <ul>
                    <?php
                    $activeProducts = mysqli_query($con, "SELECT ProductTitle FROM prod_info WHERE Status = 'active'");
                    while ($product = mysqli_fetch_assoc($activeProducts)) {
                        echo "<li>{$product['ProductTitle']}</li>";
                    }
                    ?>
                </ul>
                <h3>Inactive Products</h3>
                <ul>
                    <?php
                    $inactiveProducts = mysqli_query($con, "SELECT ProductTitle FROM prod_info WHERE Status = 'inactive'");
                    while ($product = mysqli_fetch_assoc($inactiveProducts)) {
                        echo "<li>{$product['ProductTitle']}</li>";
                    }
                    ?>
                </ul>
            </main>
        </div>
    </div>
</body>
</html>
