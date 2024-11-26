<?php include 'connect.php'; ?>
<?php 
session_start();
if(empty($_SESSION['ActiveUserId'])){
  header('location:login1.php');
  exit();
}


$totalProductsQuery = "SELECT COUNT(*) AS TotalProducts FROM prod_info";
$totalProductsResult = $con->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch_assoc()['TotalProducts'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard Home</title>
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
                <h1>Welcome to the Dashboard</h1>
                <p>Navigate through the sidebar to manage your products.</p>

                <!-- Total Products Card -->
                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Total Products</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $totalProducts ?></h5>
                        <p class="card-text">Products currently in the system.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
