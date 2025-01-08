<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM debt";
$resultdebt = $conn->query($sql);

$sql = "SELECT * FROM expenses";
$resultexpenses = $conn->query($sql);

$sql = "SELECT * FROM budgets";
$resultbudget = $conn->query($sql);

$sql = "SELECT * FROM tax";
$resulttax = $conn->query($sql);

$conn->close();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buku Kas</title>
        <link rel="stylesheet" href="Assets/reports.css">
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
            <h4>Welcome <?php echo $_SESSION["username"]; ?> !</h4>
            <a href="logout.php" id="signout-link">Sign Out</a>
    </div>


<!--TABEL DEBT  -->

    <div class="debt-container">
    <h3>Report Debt</h3>
    <div class="report-list" id="report-list">
        <div class="table-container">
        <table border="1px">
        <tr>
            <th>Debtor Name</th>
            <th>Information</th>
            <th>Amount</th>
            <th>Debt Date</th>
            <th>Due Date</th>
        </tr>
        <?php
        // Tampilkan data dari tabel debt
        while ($row = $resultdebt->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["debtor_name"] . "</td>";
            echo "<td>" . $row["title_debt"] . "</td>";
            echo "<td>" . $row["amount_debt"] . "</td>";
            echo "<td>" . $row["debt_date"] . "</td>";
            echo "<td>" . $row["debt_due_date"] . "</td>";
            echo "</tr>";
        }
        ?>
            </table>
        </div>
    </div>
</div>


<!-- TABEL EXPENSES -->
        <div class="cashout-container">
        <h3>Report Cash Out</h3>
       
        <div class="report-list" id="report-list">
                <div class="table-container">
                    <table border="1px">
            <tr>
                <th>Expenses Category</th>
                <th>Informatiom</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            <?php
        // Tampilkan data dari tabel debt
        while ($row = $resultexpenses->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["title_expenses"] . "</td>";
            echo "<td>" . $row["notes_expenses"] . "</td>";
            echo "<td>" . $row["amount_expenses"] . "</td>";
            echo "<td>" . $row["expenses_date"] . "</td>";
            echo "</tr>";
        }
        ?>
            
            </table>
                </div>
            </div>
</div>




<!-- TABEL BUDGET -->
<div class="budget-container">
<h3>Report Cash In</h3> 
<div class="report-list" id="report-list">
        <div class="table-container">
            <table border="1px">
    <tr>
        <th>Title</th>
        <th>Notes</th>
        <th>Amount</th>
        <th>Budget Date</th>
    </tr>
    <?php
        // Tampilkan data dari tabel debt
        while ($row = $resultbudget->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["title_budget"] . "</td>";
            echo "<td>" . $row["notes_budget"] . "</td>";
            echo "<td>" . $row["amount_budget"] . "</td>";
            echo "<td>" . $row["budget_date"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
        </div>
    </div>
    </div>

    <div class="tax-container">
<h3>Report Tax</h3> 
<div class="report-list" id="report-list">
        <div class="table-container">
            <table border="1px">
    <tr>
        <th>Title</th>
        <th>Notes</th>
        <th>Budget Date</th>
    </tr>
    <?php
        // Tampilkan data dari tabel debt
        while ($row = $resulttax->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["tax_total"] . "</td>";
            echo "<td>" . $row["due_date_tax"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
        </div>
    </div>
    <div class="export-section">
    <form action="export_pdf.php" method="POST">
        <button type="submit">Export to PDF</button>
    </form>
</div>

    </div>
</body>
    </html>