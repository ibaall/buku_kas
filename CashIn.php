<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if (isset($_SESSION['total_amount'])) {
    $totalAmount = $_SESSION['total_amount'];
} else {
    $totalAmount = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['budgets-title']);
    $notes = mysqli_real_escape_string($conn, $_POST['Notes-text']);
    $amount = mysqli_real_escape_string($conn, $_POST['total-amount']);
    $budgetDate = mysqli_real_escape_string($conn, $_POST['budget']);
    $userID = $_SESSION["UserID"]; 
    $query = "INSERT INTO budgets (UserID, title_budget, notes_budget, amount_budget, budget_date) VALUES ('$userID', '$title', '$notes', '$amount', '$budgetDate')";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        // echo "<script>alert('Data inserted successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$searchTitle = isset($_POST['search-title']) ? mysqli_real_escape_string($conn, $_POST['search-title']) : '';

$fetchQuery = "SELECT * FROM budgets";
if (!empty($searchTitle)) {
    $fetchQuery .= " WHERE title_budget LIKE '%$searchTitle%'";
}


$totalAmountQuery = "SELECT SUM(amount_budget) AS total FROM budgets";
$totalAmountResult = mysqli_query($conn, $totalAmountQuery);

if ($totalAmountResult) {
    $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);
    $totalAmount = $totalAmountRow['total'];

    // Store the updated total amount in the session
    $_SESSION['total_amount'] = $totalAmount;
} else {
    $totalAmount = 0;
    echo "Error: " . mysqli_error($conn);
}


// SEARCH BAR

?>

 


<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Outs</title>
    <link rel="icon" href="img/logo-title.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
    <link rel="stylesheet" href="Assets/cashin.css">
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
            <a href="Cashin.php">Cash In</a>
            </li>
            <li>
            <span><img src="img/cashoutt.png" alt="Dashboard"></span>
            <a href="Cashout.php">Cash Out</a>
            </li>
            <!-- <li>
            <span><img src="img/debtt.png" alt="Dashboard"></span>
            <a href="debt.php">Debt</a>
            <li>
            <span> <img src="img/tax.png" alt="Dashboard"></span>
            <a href="tax.php">Tax</a>
        </li>
            <li>
            <span> <img src="img/reportt.png" alt="Dashboard"></span>
            <a href="reports.php">Reports</a>
        </li> -->
            <li>
            <span> <img src="img/layanan.png" alt="Dashboard"></span>
            <a href="cs.php">Information Service</a>
        </li>
        </ul>
        </aside>

        <div class="topbar" style="border-bottom:5px solid #02571a; background-color:#108f34 " >
    <h4></h4>
      <!-- <h4></h4><img style="width:6%; border-radius: 5px" src="img/logoo.png" alt="">Buku Kas</h4> -->
      <a href="logout.php" id="signout-link">Sign Out</a>
    </div>
    <div class="user-amount-container">
        <div class="wrapper">
            <div class="container">
                <div class="total-amount-container">
                    <h3>budget</h3>
                    
                    <div>
                    <form method="post" action="">
    <input type="text" name="budgets-title" id="budgets-title" placeholder="Title">
    <input type="text" name="Notes-text" id="Notes-text" placeholder="Notes...">
    <input type="text" name="total-amount" id="total-amount" placeholder="Enter Total Amount">
    <input type="date" name="budget" id="budget" placeholder="Select budget Date">
    <button type="submit" class="submit-budgetbtn" id="total-amount-button">Set Budget</button>
</form>

                    </div>
                </div>
   
                <br>
                <div class="budget-list">
                    <h3>budget List</h3>

                    <div class="list-budget" id="list-budget">
                        <div class="table-container">
                            <table border="1px">
                                <tr>
                                    <th>Title of budget</th>
                                    <th>Notes</th>
                                    <th>Amount</th>
                                    <th>budget Date</th>
                                    <th>Action</th>
                                </tr>
                                <?php
$fetchQuery = "SELECT * FROM budgets";
$fetchResult = mysqli_query($conn, $fetchQuery);

if ($fetchResult) {
    while ($row = mysqli_fetch_assoc($fetchResult)) {
        echo "<tr>";
        echo "<td>{$row['title_budget']}</td>";
        echo "<td>{$row['notes_budget']}</td>";
        echo "<td>{$row['amount_budget']}</td>";
        echo "<td>{$row['budget_date']}</td>";
        echo '<td class="action-buttons">
                    <a href="delete_cashin.php?delete=' . $row['BudgetID'] . '" class="delete-button">Paid Off</a>
                    <a href="edit_cashin.php?id=' . $row['BudgetID'] . '" class="edit-button">Edit</a>
                </td>';
        echo "</tr>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
                            </table>
                        </div>
</body>
<script>
    let selectedCategory = "";
    document.addEventListener("DOMContentLoaded", function () {
        const searchForm = document.querySelector('.search form');
        const budgetsTable = document.getElementById('budgets-table');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); 

            const searchTerm = document.getElementById('search-title').value.toLowerCase();
            const rows = budgetsTable.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const titleCell = rows[i].getElementsByTagName('td')[0];
                const titleText = titleCell.textContent || titleCell.innerText;

                if (titleText.toLowerCase().includes(searchTerm)) {
                    rows[i].style.display = ''; 
                } else {
                    rows[i].style.display = 'none'; 
                }
            }
        });
    });
</script>

</html>
