<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Products</title>
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
                <h1>View Products</h1>

                <!-- Filters Form -->
                <form method="GET" class="row mb-4">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search by Title/Description</label>
                        <select id="search" name="search" class="form-select">
                            <option value="">Select Title or Description</option>
                            <?php
                            $searchQuery = "SELECT DISTINCT ProductTitle, ProductDescription FROM prod_info";
                            $searchResult = $con->query($searchQuery);
                            while ($row = $searchResult->fetch_assoc()) {
                                $value = htmlspecialchars($row['ProductTitle'] ?: $row['ProductDescription']);
                                echo "<option value='$value'" . (isset($_GET['search']) && $_GET['search'] == $value ? ' selected' : '') . ">$value</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="filter_date" class="form-label">Filter by Date</label>
                        <select id="filter_date" name="filter_date" class="form-select">
                            <option value="">Select Date</option>
                            <?php
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                // Filter dates based on selected search term (title/description)
                                $search = $_GET['search'];
                                $dateQuery = "SELECT DISTINCT DATE(ProductDateTime) AS ProductDate FROM prod_info WHERE (ProductTitle = ? OR ProductDescription = ?)";
                                $stmt = $con->prepare($dateQuery);
                                $stmt->bind_param("ss", $search, $search);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $date = htmlspecialchars($row['ProductDate']);
                                    echo "<option value='$date'" . (isset($_GET['filter_date']) && $_GET['filter_date'] == $date ? ' selected' : '') . ">$date</option>";
                                }
                                $stmt->close();
                            } else {
                                // Default date filter query if no search term is selected
                                $dateQuery = "SELECT DISTINCT DATE(ProductDateTime) AS ProductDate FROM prod_info";
                                $dateResult = $con->query($dateQuery);
                                while ($row = $dateResult->fetch_assoc()) {
                                    $date = htmlspecialchars($row['ProductDate']);
                                    echo "<option value='$date'" . (isset($_GET['filter_date']) && $_GET['filter_date'] == $date ? ' selected' : '') . ">$date</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="filter_status" class="form-label">Filter by Status</label>
                        <select id="filter_status" name="filter_status" class="form-select">
                            <option value="">Select Status</option>
                            <?php
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                // Filter statuses based on selected search term (title/description)
                                $search = $_GET['search'];
                                $statusQuery = "SELECT DISTINCT Status FROM prod_info WHERE (ProductTitle = ? OR ProductDescription = ?)";
                                $stmt = $con->prepare($statusQuery);
                                $stmt->bind_param("ss", $search, $search);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $status = htmlspecialchars($row['Status']);
                                    echo "<option value='$status'" . (isset($_GET['filter_status']) && $_GET['filter_status'] == $status ? ' selected' : '') . ">$status</option>";
                                }
                                $stmt->close();
                            } else {
                                // Default status filter query if no search term is selected
                                $statusQuery = "SELECT DISTINCT Status FROM prod_info";
                                $statusResult = $con->query($statusQuery);
                                while ($row = $statusResult->fetch_assoc()) {
                                    $status = htmlspecialchars($row['Status']);
                                    echo "<option value='$status'" . (isset($_GET['filter_status']) && $_GET['filter_status'] == $status ? ' selected' : '') . ">$status</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="view_product.php" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <?php
                // Pagination Variables
                $limit = 10; // Products per page
                $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1; // Ensure valid page number
                $offset = ($page - 1) * $limit;

                // Initialize Filters
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
                $filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

                // Base Query
                $baseQuery = "SELECT * FROM prod_info WHERE 1=1";

                // Filter Conditions
                $conditions = [];
                $params = [];

                if (!empty($search)) {
                    $conditions[] = "(ProductTitle = ? OR ProductDescription = ?)";
                    $params[] = $search;
                    $params[] = $search;
                }

                if (!empty($filter_date)) {
                    $conditions[] = "DATE(ProductDateTime) = ?";
                    $params[] = $filter_date;
                }

                if (!empty($filter_status)) {
                    $conditions[] = "Status = ?";
                    $params[] = $filter_status;
                }

                // Apply Filters to Query
                if (!empty($conditions)) {
                    $baseQuery .= " AND " . implode(" AND ", $conditions);
                }

                // Count Total Records for Pagination
                $countQuery = str_replace("SELECT *", "SELECT COUNT(*) AS total", $baseQuery);
                $stmt = $con->prepare($countQuery);
                if ($stmt) {
                    $stmt->execute($params);
                    $result = $stmt->get_result();
                    $totalRecords = $result->fetch_assoc()['total'];
                    $stmt->close();
                } else {
                    $totalRecords = 0;
                }

                $totalPages = ceil($totalRecords / $limit);

                // Fetch Products for the Current Page
                $finalQuery = $baseQuery . " LIMIT ?, ?";
                $params[] = $offset;
                $params[] = $limit;

                $stmt = $con->prepare($finalQuery);
                if ($stmt) {
                    $stmt->execute($params);
                    $result = $stmt->get_result();
                }
                ?>

                <!-- Products Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date & Time</th>
                            <th>Rate</th>
                            <th>MRP</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductTitle']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductDescription']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductDateTime']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductRate']) ?></td>
                                    <td><?= htmlspecialchars($row['ProductMRP']) ?></td>
                                    <td><?= htmlspecialchars($row['BalanceQuantity']) ?></td>
                                    <td><?= htmlspecialchars($row['Status']) ?></td>
                                    <td>
                                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&filter_date=<?= urlencode($filter_date) ?>&filter_status=<?= urlencode($filter_status) ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&filter_date=<?= urlencode($filter_date) ?>&filter_status=<?= urlencode($filter_status) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&filter_date=<?= urlencode($filter_date) ?>&filter_status=<?= urlencode($filter_status) ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </main>
        </div>
    </div>
</body>
</html>
