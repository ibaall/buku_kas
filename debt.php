    <?php
session_start();
    require_once "connection.php";

    $conn = getConnection();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

    function addDebt($title, $amount, $debtDate, $dueDate, $debtorName, $conn) {
        $sql = "INSERT INTO debt (title_debt, amount_debt, debt_date, debt_due_date, debtor_name) 
            VALUES ('$title', $amount, '$debtDate', '$dueDate', '$debtorName')";

        if ($conn->query($sql) === TRUE) {
            // echo "<script>alert('Debt Added Successfully');</script>";
            header("Location: debt.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_GET['delete'])) {
        $deleteDebtId = $_GET['delete'];
        $deleteSql = "DELETE FROM debt WHERE DebtID = $deleteDebtId";
    
        if ($conn->query($deleteSql) === TRUE) {
            header("Location: debt.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["product-title"];
        $amount = $_POST["user-amount"];
        $debtDate = $_POST["debt-date"];
        $dueDate = $_POST["due-date"];
        $debtorName = $_POST["debtor-name"];

        if (empty($title) || empty($amount) || empty($debtDate) || empty($dueDate) || empty($debtorName)) {
            echo "<script>alert('Please fill in all the fields');</script>";
            echo '<script>window.location.href = "debt.php";</script>';
        } else {
            $checkSql = "SELECT * FROM debt WHERE title_debt='$title' AND amount_debt=$amount 
                AND debt_date='$debtDate' AND debt_due_date='$dueDate' AND debtor_name='$debtorName'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows == 0) {
                addDebt($title, $amount, $debtDate, $dueDate, $debtorName, $conn);
            } else {
                echo "<script>alert('Data Already Exist');</script>";
                header("Location: debt.php");
            }
        }
    }

//    $username = $_SESSION['username'];
$sql = "SELECT * FROM debt";
$result = $conn->query($sql);

    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/debt.css">
        <title>Buku Kas</title>
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
            <li>
            <span><img src="img/debtt.png" alt="Dashboard"></span>
            <a href="debt.php">Debt</a>
        </li>
        <li>
            <span> <img src="img/tax.png" alt="Dashboard"></span>
            <a href="tax.php">Tax</a>
        </li>
            <li>
            <span> <img src="img/reportt.png" alt="Dashboard"></span>
            <a href="reports.php">Reports</a>
        </li>
            <li>
            <span> <img src="img/layanan.png" alt="Dashboard"></span>
            <a href="cs.php">Information Service</a>
        </li>
        </ul>
        </aside>

        <div class="topbar">
        <h4 style="color:white;">Welcome <?php echo $_SESSION["username"]; ?> !</h4>
        <a href="logout.php" id="signout-link">Sign Out</a>
    </div>
</div>
        <div class="user-amount-container">

        <form method="post" action="">
        <h3>INPUT DEBT</h3>
        <input type="text" name="debtor-name" placeholder="Enter Debtor's Name"> 
        <input type="text" class="product-title" name="product-title" placeholder="Enter Information of Debt">
        <input type="text" name="user-amount" placeholder="Enter Amount of Debt">
        <input type="date" name="debt-date" placeholder="Select Debt Date">
        <input type="date" name="due-date" placeholder="Select Due Date">
        <button type="submit" class="submit" id="check-amount">Add Debt</button>    
    </form>

    <div class="debt-list" id="debt-list">
    <div class="table-container">
        <table border="1px">
        <tr>
            <th>Debtor Name</th>
            <th>Information</th>
            <th>Amount</th>
            <th>Debt Date</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
        <?php
        // Tampilkan data dari tabel debt
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["debtor_name"] . "</td>";
            echo "<td>" . $row["title_debt"] . "</td>";
            echo "<td>" . $row["amount_debt"] . "</td>";
            echo "<td>" . $row["debt_date"] . "</td>";
            echo "<td>" . $row["debt_due_date"] . "</td>";
            echo '<td class="action-buttons">
                    <a href="debt.php?delete=' . $row['DebtID'] . '" class="delete-button">Paid Off</a>
                    <a href="edit_debt.php?id=' . $row['DebtID'] . '" class="edit-button">Edit</a>
                </td>';
            echo "</tr>";
        }
        ?>
       </table>
    </div>
</div>

    
    
    </body>

    </html> 