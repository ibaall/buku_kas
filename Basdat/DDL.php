<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

// Buat Koneksi
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$connection) {
  die("Koneksi dengan database gagal: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}

// PILIH DATABASE
$result = mysqli_select_db($connection, "db_user");
if (!$result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "Database <b>'db_user'</b> berhasil dipilih... <br>";
}

//ISI TABEL BUDGET
$query = "CREATE TABLE `budgets` (
  `BudgetID` int(11) NOT NULL,
  `UserID` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `budget_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";



$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'Budget'</b> berhasil dibuat... <br>";
}

//ISI TABEL EXPENSES
$query = "CREATE TABLE `expenses` (
  `ExpenseID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expenses_date` date NOT NULL,
  `UserID` int(20) DEFAULT NULL,
  `BudgetID` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'Expenses'</b> berhasil dibuat... <br>";
}

//ISI TABEL DEBT
$query = " CREATE TABLE `debt` (
  `DebtID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `debt_date` date NOT NULL,
  `due_date` date NOT NULL,
  `debtor_name` varchar(255) NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'DEBT'</b> berhasil dibuat... <br>";
}

//ISI TABEL USER
$query = " CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'USER'</b> berhasil dibuat... <br>";
}

// F.K BUDGETS
$query  = "ALTER TABLE `budgets`
          ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`)";
  $query_result = mysqli_query($connection, $query);
  if(!$query_result){
      die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
  }
  else {
    echo "F.K <b>'budgets'</b> berhasil dibuat... <br>";
  }

  // F.K DEBT
$query  = "ALTER TABLE `debt`
ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
$query_result = mysqli_query($connection, $query)";
if(!$query_result){
die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
echo "F.K <b>'Debt'</b> berhasil dibuat... <br>";
}



// F.K EXPENSES
$query  = "ALTER TABLE `expenses`
ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`BudgetID`) REFERENCES `budgets` (`BudgetID`)";

if(!$query_result){
die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
echo "F.K <b>'Debt'</b> berhasil dibuat... <br>";
}
  

// P.K untuk tabel `budgets`
$query  = "ALTER TABLE `budgets`
ADD PRIMARY KEY (`BudgetID`),
ADD KEY `UserID` (`UserID`)";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "P.K <b>'user'</b> berhasil dibuat... <br>";
}

// P.K untuk tabel `debt`
$query  = "ALTER TABLE `debt`
ADD PRIMARY KEY (`DebtID`),
ADD KEY `UserID` (`UserID`)";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "P.K <b>'user'</b> berhasil dibuat... <br>";
}

// P.K untuk tabel `debt`
$query  = "ALTER TABLE `expenses`
ADD PRIMARY KEY (`ExpenseID`),
ADD KEY `UserID` (`UserID`),
ADD KEY `BudgetID` (`BudgetID`)";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "P.K <b>'user'</b> berhasil dibuat... <br>";
}

// P.K untuk tabel `tax`
$query  = "ALTER TABLE `tax`
ADD PRIMARY KEY (`tax_id`)";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "P.K <b>'user'</b> berhasil dibuat... <br>";
}


// P.K untuk tabel `user`
$query  = "ALTER TABLE `user`
ADD PRIMARY KEY (`UserID`)";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "P.K <b>'user'</b> berhasil dibuat... <br>";
}



// A.I untuk tabel `budgets`
$query  = "ALTER TABLE `budgets`
MODIFY `BudgetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "A.I <b>'user'</b> berhasil dibuat... <br>";
}

// A.I untuk tabel `debt`
$query  = "ALTER TABLE `debt`
MODIFY `DebtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "A.I <b>'user'</b> berhasil dibuat... <br>";
}

// A.I untuk tabel `expenses`
$query  = "ALTER TABLE `expenses`
MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "A.I <b>'user'</b> berhasil dibuat... <br>";
}

// A.I untuk tabel `tax`
$query  = "ALTER TABLE `tax`
MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT;";
$query_result = mysqli_query($connection, $query);
if(!$query_result){
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
else {
  echo "A.I <b>'user'</b> berhasil dibuat... <br>";
}


?>