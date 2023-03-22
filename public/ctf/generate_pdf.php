<?php
session_start();
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $company_name = $_POST["company_name"];
    $invoice_amount = $_POST["invoice_amount"];

    $target_dir = "/var/www/html/ctf/uploads/" . $username . "/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $pdf_content = "<h1>Company Name: " . $company_name . "</h1>";
    $pdf_content .= "<h2>Invoice Amount: " . $invoice_amount . "</h2>";

    $html_file = $target_dir . "temp.html";
    $pdf_file = $target_dir . $username . "-invoice.pdf";

    file_put_contents($html_file, $pdf_content);

    $command = "sudo -u www-data wkhtmltopdf --enable-local-file-access " . escapeshellarg($html_file) . " " . escapeshellarg($pdf_file);
    shell_exec($command);
    ob_start();
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=" . basename($pdf_file));
    header("Content-Length: " . filesize($pdf_file));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($pdf_file);
    ob_end_flush();

    unlink($html_file);
    unlink($pdf_file);
}
?>
