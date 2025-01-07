<?php
session_start();
require_once "connection.php";

$conn = getConnection();

function addTax($productName, $taxTotal, $dueDate, $conn) {
    $sql = "INSERT INTO tax (product_name, tax_total, due_date_tax) 
            VALUES ('$productName', $taxTotal, '$dueDate')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tax.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $deleteTaxId = $_GET['delete'];
    $deleteSql = "DELETE FROM tax WHERE id = $deleteTaxId";

    if ($conn->query($deleteSql) === TRUE) {
        header("Location: tax.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST["product-name"];
    $taxTotal = $_POST["tax-total"];
    $dueDate = $_POST["due-date"];

    if (empty($productName) || empty($taxTotal) || empty($dueDate)) {
        echo "<script>alert('Please fill in all the fields');</script>";
        echo '<script>window.location.href = "tax.php";</script>';
    } else {
        $checkSql = "SELECT * FROM tax WHERE product_name='$productName' AND tax_total=$taxTotal AND due_date_tax='$dueDate'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows == 0) {
            addTax($productName, $taxTotal, $dueDate, $conn);
        } else {
            echo "<script>alert('Data Already Exist');</script>";
            header("Location: tax.php");
        }
    }
}

// Tampilkan data dari tabel tax
$sqlTax = "SELECT * FROM tax";
$resultTax = $conn->query($sqlTax);
$conn->close();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buku Kas</title>
        <link rel="stylesheet" href="Assets/tax.css">
    </head>

    <body>
        <!-- SIDE BAR -->
        <aside class="sidebar">
        <div class="container">
            <div class="logo">
            <!-- <img src="img/logo.png" alt="logo"> -->
            <h2>BUKU<span>KAS</span></h2>
            </div>
        <ul class="links">
            <h4>Main Menu</h4>
            <li>
            <span><img src="img/dash (2).png" alt="Dashboard"></span>
            <a href="dashboard.php">Dashboard</a>
            </li>
                    
            <h4>Transaction</h4>
            <li>
                <span><img src="img/cashinn.png" alt="Dashboard"></span>
            <a href="CashIn.php">Cash In</a>
            </li>
            <li>
            <span><img src="img/cashoutt.png" alt="Dashboard"></span>
            <a href="CashOut.php">Cash Out</a>
            </li>
            <!-- <li>
            <span><img src="img/debtt.png" alt="Dashboard"></span>
            <a href="debt.php">Debt</a> -->
            <li>
            <span> <img src="img/tax.png" alt="Dashboard"></span>
            <a href="tax.php">Tax</a>
        </li>
            <!-- <li>
            <span> <img src="img/reportt.png" alt="Dashboard"></span>
            <a href="reports.php">Reports</a>
        </li>
            <li>
            <span> <img src="img/layanan.png" alt="Dashboard"></span>
            <a href="cs.php">Information Service</a> -->
        </li>
        </ul>
        </aside>

        <div class="topbar">
        <h4 style="color:white">Welcome <?php echo $_SESSION["username"]; ?> !</h4>
        <a href="logout.php" id="signout-link">Sign Out</a>
    </div>
        <div class="user-amount-container">

        <form method="post" action="">
    <h3>TAX</h3>
    <input type="text" name="product-name" placeholder="Enter Product Name ">
    <input type="text" name="tax-total" placeholder="Enter Amount of Tax">
    <input type="date" name="due-date" placeholder="Select Due Date">
    <button type="submit" class="submit" id="check-amount">Add Tax</button>
</form>


    <div class="debt-list" id="debt-list">
    <div class="table-container">
        <table border="1px">
        <tr>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
        <?php
while ($row = $resultTax->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row["product_name"]; ?></td>
        <td><?php echo $row["tax_total"]; ?></td>
        <td><?php echo $row["due_date_tax"]; ?></td>
        <td class="action-buttons">
    <a href="edit_tax.php?id=<?php echo $row['tax_id']; ?>" class="edit-button">Edit</a>
    <a href="delete_tax.php?delete=<?php echo $row['tax_id']; ?>" class="delete-button">Delete</a>
</td>
    </tr>
<?php
}
?>
       </table>
    </div>
</div>

    
    
    </body>

    </html> 