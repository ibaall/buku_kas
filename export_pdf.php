<?php
session_start();
require_once "connection.php";
require 'vendor/autoload.php'; // Autoload Dompdf if using Composer

use Dompdf\Dompdf;

// Mulai koneksi database
$conn = getConnection();

$sqlDebt = $conn->query("SELECT * FROM debt")->fetch_all(MYSQLI_ASSOC);
$sqlExpenses = $conn->query("SELECT * FROM expenses")->fetch_all(MYSQLI_ASSOC);
$sqlBudget = $conn->query("SELECT * FROM budgets")->fetch_all(MYSQLI_ASSOC);
$sqlTax = $conn->query("SELECT * FROM tax")->fetch_all(MYSQLI_ASSOC);

$conn->close();

// Masukkan HTML laporan ke dalam string
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report PDF</title>
    <link rel="stylesheet" href="Assets/reports.css">
</head>
<body>
    <h1>Laporan Buku Kas</h1>
    <h2>Debt Report</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Debtor Name</th>
                <th>Information</th>
                <th>Amount</th>
                <th>Debt Date</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>';

foreach ($sqlDebt as $row) {
    $html .= "<tr>
        <td>{$row['debtor_name']}</td>
        <td>{$row['title_debt']}</td>
        <td>{$row['amount_debt']}</td>
        <td>{$row['debt_date']}</td>
        <td>{$row['debt_due_date']}</td>
    </tr>";
}

$html .= '</tbody></table>';

$html .= '<h2>Expenses Report</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Expenses Category</th>
                <th>Information</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>';

foreach ($sqlExpenses as $row) {
    $html .= "<tr>
        <td>{$row['title_expenses']}</td>
        <td>{$row['notes_expenses']}</td>
        <td>{$row['amount_expenses']}</td>
        <td>{$row['expenses_date']}</td>
    </tr>";
}

$html .= '</tbody></table>';

$html .= '</body>
</html>';

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html); // Masukkan HTML ke Dompdf

// (Opsional) Sesuaikan ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'landscape');

// Render PDF
$dompdf->render();

// Kirim PDF ke browser
$dompdf->stream("Report.pdf", ["Attachment" => 0]); // Ubah ke "Attachment" => 1 untuk unduh otomatis
?>