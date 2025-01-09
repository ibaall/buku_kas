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
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        h2 {
            font-size: 18px;
            margin-top: 30px;
        }

        /* Gaya Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #05992f;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Kustomisasi Kolom */
        table th:nth-child(3), table td:nth-child(3) {
            text-align: right;
        }

        table th:nth-child(4), table td:nth-child(4), 
        table th:nth-child(5), table td:nth-child(5) {
            text-align: center;
        }
    </style>
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
$html .= '<h2>Budget Report</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Title</th>
                <th>Notes</th>
                <th>Amount</th>
                <th>Budget Date</th>
            </tr>
        </thead>
        <tbody>';

foreach ($sqlBudget as $row) {
    $html .= "<tr>
        <td>{$row['title_budget']}</td>
        <td>{$row['notes_budget']}</td>
        <td>{$row['amount_budget']}</td>
        <td>{$row['budget_date']}</td>
    </tr>";
}

$html .= '</tbody></table>';

$html .= '<h2>Tax Report</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Tax Total</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>';

foreach ($sqlTax as $row) {
    $html .= "<tr>
        <td>{$row['product_name']}</td>
        <td>{$row['tax_total']}</td>
        <td>{$row['due_date_tax']}</td>
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
