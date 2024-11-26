<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete product from the database
    $deleteQuery = "DELETE FROM prod_info WHERE id = '$productId'";
    $res = mysqli_query($con, $deleteQuery);

    if ($res) {
        header('Location: view_product.php'); // Redirect back to view products page
    } else {
        echo "<script>alert('Failed to delete product');</script>";
    }
}
?>
