<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <title>UPI Gateway Features</title>
  <style>
    .feature-item {
      text-align: center;
      margin-bottom: 30px;
      cursor: pointer;
    }

    .feature-icon {
      font-size: 48px;
      color: #007bff;
      margin-bottom: 15px;
    }

    .feature-title {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .feature-description {
      font-size: 16px;
      color: #333;
    }

    @media (max-width: 768px) {
      .feature-item {
        margin-bottom: 60px;
      }
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">UPI Gateway Features</h1>
    <div class="row">
      <div class="col-md-4">
        <div class="feature-item">
          <i class="feature-icon fas fa-coins"></i>
          <h2 class="feature-title">Zero Fees</h2>
          <p class="feature-description">Your UPI gateway offers a seamless payment acceptance solution without any transaction fees.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-link"></i>
          <h2 class="feature-title">UPI Integration</h2>
          <p class="feature-description">The gateway is integrated with the Unified Payments Interface (UPI) for accepting payments from any UPI-enabled app or bank.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-cogs"></i>
          <h2 class="feature-title">Easy Setup</h2>
          <p class="feature-description">Setting up your UPI gateway is quick and straightforward, allowing businesses to start accepting payments in no time.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-lock"></i>
          <h2 class="feature-title">Secure Transactions</h2>
          <p class="feature-description">The gateway ensures secure and encrypted transactions, protecting sensitive customer data and financial information.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-item">
          <i class="feature-icon fas fa-mobile-alt"></i>
          <h2 class="feature-title">Multi-Platform Support</h2>
          <p class="feature-description">It supports various platforms, including websites, mobile apps, and e-commerce platforms, offering flexibility to businesses across different channels.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-money-check-alt"></i>
          <h2 class="feature-title">Instant Settlement</h2>
          <p class="feature-description">Funds received through UPI payments are settled instantly into the business's bank account, reducing the waiting period for access to funds.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-history"></i>
          <h2 class="feature-title">Transaction History</h2>
          <p class="feature-description">A comprehensive transaction history is provided, allowing businesses to keep track of all UPI payments received.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-paint-brush"></i>
          <h2 class="feature-title">Customizable Payment Experience</h2>
          <p class="feature-description">The UPI gateway offers customizable payment interfaces, allowing businesses to align the look and feel with their brand.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-item">
          <i class="feature-icon fas fa-qrcode"></i>
          <h2 class="feature-title">QR Code Integration</h2>
          <p class="feature-description">Businesses can generate dynamic QR codes to receive UPI payments, making it convenient for customers to scan and pay.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-id-card"></i>
          <h2 class="feature-title">Multiple UPI IDs</h2>
          <p class="feature-description">Your UPI gateway allows businesses to associate multiple UPI IDs with a single account, facilitating payments received from different channels.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-bell"></i>
          <h2 class="feature-title">Real-time Notifications</h2>
          <p class="feature-description">Instant notifications are sent to businesses and customers for successful UPI transactions, ensuring transparency and prompt updates.</p>
        </div>
        <div class="feature-item">
          <i class="feature-icon fas fa-hand-holding-usd"></i>
          <h2 class="feature-title">Refund Management</h2>
          <p class="feature-description">The UPI gateway offers a streamlined refund process, allowing businesses to initiate and manage refunds seamlessly.</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".feature-item").click(function() {
        $(this).toggleClass("active");
      });
    });
  </script>
</body>

</html>
