<!DOCTYPE html>
<html>
<head>
<title>Payment Gateway - Test Demo</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    h2 {
        color: #343a40;
        margin-top: 0;
    }

    form label {
        color: #343a40;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .card {
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
</style>
</head>
<body>
<div class="container py-5">

<div class="row">
    
<div class="col-md-6 mb-4">
    
<h2 class="mb-3">Test Demo</h2>
<p>Fill Payment Details and Pay</p>
<hr>
<form action="txnProcess.php" method="post">
    <div class="form-group">
        <label for="gateway_type">Gateway Type:</label>
        <select id="gateway_type" name="gateway_type" class="form-control" required>
            <option value="Advanced">Advanced</option>
            <option value="Robotics">Robotics</option>
            <option value="Normal">Normal</option>
        </select>
    </div>
    <div class="form-group">
        <label for="txnAmount">Txn Amount:</label>
        <input type="text" id="txnAmount" name="txnAmount" value="1" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="txnNote">Txn Note:</label>
        <input type="text" id="txnNote" name="txnNote" value="Test Payment" placeholder="Enter Txn Note" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="cust_Mobile">Mobile No:</label>
        <input type="text" id="cust_Mobile" name="cust_Mobile" placeholder="Enter Your Mobile" maxlength="10" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="cust_Email">Email:</label>
        <input type="email" id="cust_Email" name="cust_Email" placeholder="Enter Your Email" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Payment</button>
</form>
</div> 

<div class="col-md-6 mt-4">
<div class="card p-4">    
<h2 class="mb-3">Video Tutorial</h2>
<p>Video tutorial helps to understand how the UPI gateway works</p>
<hr>
<!-- Video tutorial content goes here -->
</div>
</div>

</div>

</div>    
</body>
</html>
