<?php
    session_start();
    require_once "connection.php";

    $conn = getConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($conn, $_POST['expensess-title']);
        $notes = mysqli_real_escape_string($conn, $_POST['Notes-text']);
        $amount = mysqli_real_escape_string($conn, $_POST['total-amount']);
        $expensesDate = mysqli_real_escape_string($conn, $_POST['expenses']);

        $query = "INSERT INTO expenses (title_expenses, notes_expenses, amount_expenses, expenses_date) VALUES ('$title', '$notes', '$amount', '$expensesDate')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // echo "<script>alert('Data inserted successfully');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    $searchTitle = isset($_POST['search-title']) ? mysqli_real_escape_string($conn, $_POST['search-title']) : '';

$fetchQuery = "SELECT * FROM expenses";
if (!empty($searchTitle)) {
    $fetchQuery .= " WHERE title LIKE '%$searchTitle%'";
}


    function displayTotalExpenses() {
        global $conn;

        $totalQuery = "SELECT SUM(amount_expenses) as total FROM expenses";
        $totalResult = mysqli_query($conn, $totalQuery);

        if ($totalResult) {
            $totalRow = mysqli_fetch_assoc($totalResult);
            $totalAmount = $totalRow['total'];

            // echo "<script>alert('Total Expenses: $totalAmount');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    $fetchQuery = "SELECT * FROM expenses";
    $fetchResult = mysqli_query($conn, $fetchQuery);


    
    ?>


    <!DOCTYPE html>


    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cash Out</title>
        <link rel="icon" href="img/logo-title.png" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap">
        <link rel="stylesheet" href="Assets/cashout.css">
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
                <li>
                <span><img src="img/debtt.png" alt="Dashboard"></span>
                <a href="debt.php">Debt</a>
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
        <div class="user-amount-container">
            <div class="wrapper">
                <div class="container">
                    <div class="total-amount-container">
                        <h3>Pengeluaran</h3>
                        <div class="dropdown">
                        </div>
                        <div>
                        <form method="post" action="">
        <input type="text" name="expensess-title" id="expensess-title" placeholder="Title">
        <input type="text" name="Notes-text" id="Notes-text" placeholder="Notes...">
        <input type="text" name="total-amount" id="total-amount" placeholder="Enter Total Amount">
        <input type="date" name="expenses" id="expenses" placeholder="Select Expenses Date">
        <button type="submit" class="submit-expensesbtn" id="total-amount-button">Tambahkan Pengeluaran</button>
    </form>

                        </div>
                    </div>
                    </div>
                 <div class="search-container">
    <div class="list-expenses" id="list-expenses">
    <div class="table-container">
        <table border="1px" id="expenses-table">
            <tr>
                <th>Title of Expenses</th>
                <th>Notes</th>
                <th>Amount</th>
                <th>Expenses Date</th>
                <th>Actions</th>
            </tr>
         
    </div>
</div>

            <?php

            if ($fetchResult) {
                while ($row = mysqli_fetch_assoc($fetchResult)) {
                    echo "<tr>";
                    echo "<td>{$row['title_expenses']}</td>";
                    echo "<td>{$row['notes_expenses']}</td>";
                    echo "<td>{$row['amount_expenses']}</td>";
                    echo "<td>{$row['expenses_date']}</td>";
                    echo '<td class="action-buttons">
                    <a href="delete_cashout.php?delete=' . $row['ExpenseID'] . '" class="delete-button">Paid Off</a>
                    <a href="edit_cashout.php?id=' . $row['ExpenseID'] . '" class="edit-button">Edit</a>
                </td>';
        echo "</tr>";
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            ?>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchForm = document.querySelector('.search form');
        const expensesTable = document.getElementById('expenses-table');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); 

            const searchTerm = document.getElementById('search-title').value.toLowerCase();
            const rows = expensesTable.getElementsByTagName('tr');

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