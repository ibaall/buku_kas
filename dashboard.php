<?php
session_start();
require_once "connection.php";

$conn = getConnection();

if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT SUM(amount_budget) as total FROM budgets"; 

$totalAmountResult = mysqli_query($conn, $query);

if ($totalAmountResult) {
    $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);

    $totalAmount = $totalAmountRow['total'];

    $_SESSION['total_amount'] = $totalAmount;

} else {
    $totalAmount = 0;
    echo "Error: " . mysqli_error($conn);
}

$totalQuery = "SELECT SUM(amount_expenses) as total FROM expenses";
$totalResult = mysqli_query($conn, $totalQuery);

if ($totalResult) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalExpenses = $totalRow['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}

$budgetQuery = "SELECT SUM(amount_budget) as total FROM budgets";
$budgetResult = mysqli_query($conn, $budgetQuery);

if ($budgetResult) {
    $budgetRow = mysqli_fetch_assoc($budgetResult);
    $totalBudget = $budgetRow['total'];
} else {
    echo "Error: " . mysqli_error($conn);
}
$balance = $totalBudget - $totalExpenses;

$sql = "SELECT * FROM debt";
$resultdebt = $conn->query($sql);

$sql = "SELECT * FROM tax";
$resulttax = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Kas</title>
    <!-- <link rel="stylesheet" href="Assets/dashboard.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <style>
      * {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  user-select: none;
  --webkit-user-select: none;
}
::-webkit-scrollbar {
  width: 0px;
}

.topbar {
  position: fixed;
  top: 0;
  height: 50px;
  width: 100%;
  background-color: #05992f;
  display: flex;
  align-items: center;
  padding: 0 15px;
  justify-content: space-between;
  color: white;
}

#signout-link {
  color: white;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
  margin-right: 20px;
}

.sidebar {
  position: fixed;
  top: 50px;
  left: 0;
  width: 90px;
  height: 100%;
  display: flex;
  align-items: center;
  flex-direction: column;
  background: rgba(3, 3, 3, 0.8);
  backdrop-filter: blur(17px);
  --webkit-backdrop-filter: blur(17px);
  border-right: 1px solid rgba(255, 0, 0, 0, 1);
  transition: width 0.3s ease;
}
.sidebar:hover {
  width: 260px;
}

.sidebar .logo {
  color: #000;
  display: flex;
  align-items: center;
  padding: 25px 10px 15px;
}

.logo span {
  color: orange;
}

.logo img {
  width: 43px;
  border-radius: 50%;
}

.logo h2 {
  font-size: 1.15rem;
  font-weight: 600;
  margin-left: 15px;
  display: none;
}

.sidebar:hover .logo h2 {
  display: block;
}

.sidebar .links {
  list-style: none;
  margin-top: 20px;
  overflow-y: auto;
  scrollbar-width: none;
  height: calc(100%);
}

.sidebar .links::-webkit-scrollbar {
  display: none;
}

.links li {
  display: flex;
  border-radius: 4px;
  align-items: center;
  transition: background-color 0.3s ease;
}

.links li:hover {
  background: #05992f;
  cursor: pointer;
}

.links h4 {
  color: #222;
  font-weight: 500;
  display: none;
  margin-bottom: 10px;
  transition: display 0.3s ease;
}

.sidebar:hover .links h4 {
  display: block;
}

.links hr {
  margin: 10px 8px;
  border: 1px solid #4c4c4c;
  transition: border-color 0.3s ease;
}

.sidebar:hover .links hr {
  border-color: transparent;
}

.links li span {
  padding: 12px 10px;
}

.links li a {
  padding: 10px;
  color: #000;
  display: none;
  font-weight: 500;
  white-space: nowrap;
  text-decoration: none;
  transition: color 0.3s ease;
}

.sidebar:hover .links li a {
  display: block;
}

.links .logout-link {
  margin-top: 20px;
}

.links li:hover a {
  color: white;
  /* Change text color on hover */
}

.sidebar:hover .links li a {
  display: block;
}

.links .logout-link {
  margin-top: 20px;
}

.links li:hover a {
  color: white;
  /* Change text color on hover */
}

.links h4 {
  color: #222;
  font-weight: 500;
  display: none;
  margin-bottom: 10px;
}

.sidebar:hover .links h4 {
  display: block;
}

.links hr {
  margin: 10px 8px;
  border: 1px solid #4c4c4c;
}

.sidebar:hover .links hr {
  border-color: transparent;
}

.links li span {
  padding: 12px 10px;
}

.links li a {
  padding: 10px;
  color: white;
  display: none;
  font-weight: 500;
  white-space: nowrap;
  text-decoration: none;
}

.sidebar:hover .links li a {
  display: block;
}

body {
  font-family: sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f2f2f2;
}

.container {
  margin: 0 auto;
  padding: 20px;
  max-width: 600px;
}

/* h1 {
  text-align: center;
  font-size: 24px;
  margin-bottom: 40px;
  margin-top: 40px;
} */

.cards {
  position: relative;
  right: 260px;
  /* margin-right:500px; */
  display: flex;
  /* justify-content: space-between; */
  color: white;
  /* text-align: center; */
}

.card1 {
  background-color: #0a7e00;
  padding: 20px 80px;
  margin: 0 10px;
  /* border-radius: 5px; */
  box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
}
.card2 {
  background-color: #970000;
  padding: 20px 80px;
  margin: 0 50px;
  /* border-radius: 5px; */
  box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
}
.card3 {
  background-color: #c38f08;
  padding: 20px 80px;
  margin: 0 10px;
  /* border-radius: 5px; */
  box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.5);
}
.card1 img {
  position: absolute;
  left: 260px;
  top: 18px;

  /* width:70px; */
}
.card2 img {
  position: absolute;
  left: 665px;
  top: 18px;
}
.card3 img {
  position: absolute;
  left: 1050px;
  width:10%;
  top: 12px;
}

.cards h3 {
  font-weight:normal;
  font-size: 15px;
  margin-bottom: 5px;
  /* background-color: pink; */
  width: 180px;
  position:relative;
  right:35px;
}

.cards p {
  font-weight: bold;
  margin-bottom:5px;
  position:relative;
  right:35px;
  /* background-color: blue; */
  font-size: 17px;
  color: #777;
}

.navigation {
  text-align: center;
  margin-top: 20px;
}

.previous-button {
  border: none;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
}
.next-button {
  border: none;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
}

table {
  width: 100%;
  border-collapse: collapse;
  /* margin-top: 20px; */
}

th  ,
td {
  border: 1px solid #ddd;
  padding: 5px 12px;
  text-align: center;
}

th {
  font-weight: normal;
  text-align: center;
  background-color: #05992f;
  color: white;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #ddd;
}

    </style>
  </head>
  <body>

    <!-- TOP-BAR -->
    <div class="topbar" style="border-bottom:5px solid #02571a; background-color:#108f34 " >
    <h4></h4>
      <!-- <h4></h4><img style="width:6%; border-radius: 5px" src="img/logoo.png" alt="">Buku Kas</h4> -->
      <a href="logout.php" id="signout-link">Sign Out</a>
    </div>
    
    <!-- MAIN CONTENT -->
    <div class="container">
      <!-- <h1>Welcome,!</h1> -->
      <div class="top" style="margin-top: 60px; position:relative; right:250px;" >
      <h1 style="font-size:14px;">Welcome <?php echo $_SESSION["username"]; ?> ! <br> <span style="font-size:25px">DASHBOARD</span></h1>
      </div>
      <div class="cards" style="margin-top: 20px">
        <div class="card1">
          <div class="side">

          </div>
          <p style="color: white;">Total Income</p>
          <h3>Rp.<?php echo $totalAmount ?></h3>
          <img src="img/enter.png" alt="">
          
        </div>
        <div class="card2">
          <p style="color:white;">Total Outcome</p>
        <h3>Rp.<?php echo $totalExpenses ?></h3>
          <img src="img/out.png" alt="">
        </div>
        <div class="card3">
          <p style="color:white;">Balance</p>
        <h3>Rp.<?php echo $balance ?></h3>
          <img src="img/cash.png" alt="">
        </div>
      </div>
    </div>

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
            <a href="debt.php">Debt</a> </li>
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
  </body>
  
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const signoutLink = document.getElementById("signout-link");

        signoutLink.addEventListener("click", function(event) {
          event.preventDefault();

          const confirmLogout = confirm("Are you sure you want to sign out?");

          if (confirmLogout) {
            console.log("User is signed out");
            window.location.href = "logout.php"
          } else {
            console.log("User chose not to sign out");
          }
        });
      });
    </script>
</html>