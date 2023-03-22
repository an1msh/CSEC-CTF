<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.html");
    exit;
}
?>
<html>
<head>
<title>Dashboard</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#generatePdfForm").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "generate_pdf.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                if (response.size > 0) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(response);
                    link.download = 'invoice.pdf';
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    $("#result").html("Error generating PDF");
                }
            },
            error: function() {
                $("#result").html("An error occurred.");
            }
        });
    });
});
</script>
</head>
<body>
<h1>Welcome, <?php echo $_SESSION["username"]; ?></h1>
<form id="generatePdfForm" enctype="multipart/form-data">
<label for="company_name">Company Name:</label>
<input type="text" name="company_name" id="company_name" required><br>
<label for="invoice_amount">Invoice Amount:</label>
<input type="text" name="c" id="invoice_amount" required><br>
<input type="submit" value="Generate PDF">
</form>
<div id="result"></div>
<a href="logout.php">Logout</a>
</body>
</html>
