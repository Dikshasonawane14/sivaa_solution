<div class="sidebar d-flex flex-column bg-dark text-white p-3">
    <h3 class="text-center mb-4">Dashboard</h3>
    <a href="dashboard.php" class="nav-link text-white">Dashboard Home</a>
    <a href="add_product.php" class="nav-link text-white">Add Product</a>
    <a href="view_product.php" class="nav-link text-white">View Products</a>
    <a href="product_status.php" class="nav-link text-white">Product Status</a>
    <a href="report.php" class="nav-link text-white">Report</a>
    <a href="logout.php" class="nav-link text-white">Logout</a>
</div>

<style>
    /* Sidebar fixed position and constant size */
    .sidebar {
        width: 200px; /* Fixed width for sidebar */
        height: 100vh; /* Full height of the viewport */
        position: fixed; /* Keep sidebar fixed on the left */
        top: 0;
        left: 0;
        padding-top: 30px;
        z-index: 100; /* Ensure sidebar stays on top */
    }

    /* Main content alignment */
    .main-content {
        margin-left: 250px; /* Offset content for sidebar */
        padding: 20px; /* Space around content */
    }

    .sidebar a {
        padding: 10px 15px;
        border-radius: 5px;
    }

    .sidebar a:hover {
        background-color: #495057;
    }
</style>
