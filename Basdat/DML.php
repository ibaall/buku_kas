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
$query = " 
INSERT INTO `budgets` (`UserID`, `title`, `notes`, `amount`, `budget_date`) VALUES
(22, 'LISTRIKk', 'token listrik', 2000.00, '2024-01-02'),
(23, 'AIRR', 'minum', 450000.00, '2023-10-02')";


$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'Budget'</b> berhasil dibuat... <br>";
}

//ISI TABEL EXPENSES
$query = " 
INSERT INTO `expenses` (`title`, `notes`, `amount`, `expenses_date`, `UserID`, `BudgetID`) VALUES
('AIR', 'AIR Galonn', 45000.00, '2023-12-01', null, null),
('BENSIN', 'Bensin Benik', 25000.00, '2023-12-03', null, null)";

$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'Expenses'</b> berhasil dibuat... <br>";
}

//ISI TABEL DEBT
$query = " 
INSERT INTO `debt` (`DebtID`, `title`, `amount`, `debt_date`, `due_date`, `debtor_name`, `UserID`) VALUES
(59, 'Pembelian Alat Kantorr', 250000, '2023-11-22', '2005-04-20', 'Dwiki', null),
(60, 'Pembelian Alat Makann', 25000, '2203-11-22', '2005-04-20', 'Rhmat', null)";

$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'DEBT'</b> berhasil dibuat... <br>";
}

//ISI TABEL USER
$query = " 
INSERT INTO `user` (`username`, `password`) VALUES
('admin', 'admin'),
('user', 'user')";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "data <b>'USER'</b> berhasil dibuat... <br>";
}

$query = " 
INSERT INTO `tax` (`tax_ID`, `product_name`, `taxt_total`,`due_date_tax`) VALUES
(8, 'Motor', 250000, '2023-10-10');
(9, 'ROYA', 250000, '2023-12-10')";
$query_result = mysqli_query($connection, $query);
if (!$query_result) {
  die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
} else {
  echo "isi <b>Tax</b> berhasil dibuat... <br>";
}



?>