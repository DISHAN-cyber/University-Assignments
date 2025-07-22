<?php

session_start();
include "connection.php";

// Sanitize user input
$email = $_SESSION["u"]["email"];
$search = $_POST["s"] ?? '';
$time = $_POST["t"] ?? '0';
$qty = $_POST["q"] ?? '0';
$condition = $_POST["c"] ?? '0';

// Base query
$query = "SELECT * FROM `product` WHERE `user_email` = ?";
$params = [$email];
$types = 's';

// Add search filter
if (!empty($search)) {
    $query .= " AND `title` LIKE ?";
    $params[] = '%' . $search . '%';
    $types .= 's';
}

// Add condition filter
if ($condition != "0") {
    $query .= " AND `condition_condition_id` = ?";
    $params[] = $condition;
    $types .= 'i';
}

// Handle sorting
$sort_order = [];

if ($time != "0") {
    $sort_order[] = $time == "1" ? "`datetime_added` DESC" : "`datetime_added` ASC";
}

if ($qty != "0") {
    $sort_order[] = $qty == "1" ? "`qty` DESC" : "`qty` ASC";
}

// Apply sorting to query
if (!empty($sort_order)) {
    $query .= " ORDER BY " . implode(", ", $sort_order);
}

// Prepare and execute the query
$stmt = Database::prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$product_num = $result->num_rows;

// Pagination setup
$results_per_page = 3;
$number_of_pages = ceil($product_num / $results_per_page);
$pageno = max(1, (int) ($_POST["page"] ?? 1));
$page_results = ($pageno - 1) * $results_per_page;

// Fetch paginated results
$paginated_query = $query . " LIMIT ? OFFSET ?";
$types .= 'ii';  // Append types for LIMIT and OFFSET
$params[] = $results_per_page;
$params[] = $page_results;

$stmt = Database::prepare($paginated_query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$selected_rs = $stmt->get_result();

?>

<div class="offset-1 col-10 text-center">
    <div class="row justify-content-center">

        <?php while ($selected_data = $selected_rs->fetch_assoc()): ?>
            <!-- card -->
            <div class="card mb-3 mt-3 col-12 col-lg-6">
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <?php
                        $productImg_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                        $productImg_data = $productImg_rs->fetch_assoc();
                        ?>
                        <img src="<?php echo $productImg_data["img_path"] ?? 'resources/no_img.svg'; ?>" class="img-fluid rounded-start" style="height: 150px;" />
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($selected_data["title"]); ?></h5>
                            <span class="card-text fw-bold text-primary">Rs. <?php echo htmlspecialchars($selected_data["price"]); ?>.00</span><br />
                            <span class="card-text fw-bold text-success"><?php echo htmlspecialchars($selected_data["qty"]); ?></span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="toggle<?php echo $selected_data["id"]; ?>" onchange="changeStatus(<?php echo $selected_data['id']; ?>);" <?php echo $selected_data["status_status_id"] == 2 ? 'checked' : ''; ?> />
                                <label class="form-check-label fw-bold text-info" for="toggle<?php echo $selected_data["id"]; ?>">
                                    <?php echo $selected_data["status_status_id"] == 2 ? 'Make Your Product Active' : 'Make Your Product Deactive'; ?>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row g-1">
                                        <div class="col-12 d-grid">
                                            <a href="updateProduct.php?id=<?php echo $selected_data["id"]; ?>" class="btn btn-success fw-bold">Update</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
        <?php endwhile; ?>

    </div>
</div>

<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) echo '#'; else echo "onclick=\"sort1(" . ($pageno-1) . ");\""; ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($x = 1; $x <= $number_of_pages; $x++): ?>
                <li class="page-item <?php if ($x == $pageno) echo 'active'; ?>">
                    <a class="page-link" onclick="sort1(<?php echo $x; ?>);"><?php echo $x; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) echo '#'; else echo "onclick=\"sort1(" . ($pageno+1) . ");\""; ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php
// Close the statement and connection
$stmt->close();
Database::$connection->close();
?>
