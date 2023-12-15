<?php
require_once('layouts/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Payment Gateway Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Custom CSS styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }
    
    .container {
      margin-top: 50px;
      text-align: center;
    }
    
    h1 {
      font-size: 36px;
      color: #333;
      margin-bottom: 20px;
    }
    
    p {
      font-size: 18px;
      color: #555;
      margin-bottom: 30px;
    }
    
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
    
    .features {
      margin-top: 50px;
      margin-bottom: 50px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
    }
    
    .feature-item {
      flex-basis: 25%;
      padding: 0 20px;
      margin-bottom: 30px;
      transition: transform 0.3s ease-in-out;
    }
    
    .feature-item:hover {
      transform: translateY(-10px);
    }
    
    .feature-icon {
      font-size: 36px;
      color: #007bff;
      margin-bottom: 10px;
    }
    
    .feature-title {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }
    
    .feature-description {
      font-size: 16px;
      color: #555;
    }
    
    .logo {
      margin-bottom: 20px;
    }
    
    @media (max-width: 576px) {
      /* Styles for small devices (e.g., smartphones) */
      h1 {
        font-size: 28px;
      }
    
      p {
        font-size: 16px;
      }
      
      .feature-item {
        flex-basis: 50%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Welcome to the Plugin Page</h1>
    <p>If you need the plugin, please contact us on WhatsApp:</p>
    <a href="https://wa.me/918619170399" class="btn btn-primary">Contact us on WhatsApp</a>
    
    <div class="features">
      <div class="feature-item">
        <i class="feature-icon fas fa-rocket"></i>
        <h2 class="feature-title">Fast and Efficient</h2>
        <p class="feature-description">Our plugin is designed to be fast and efficient, ensuring optimal performance.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-cogs"></i>
        <h2 class="feature-title">Easy to Use</h2>
        <p class="feature-description">With a user-friendly interface, our plugin is easy to set up and use.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-mobile-alt"></i>
        <h2 class="feature-title">Mobile Responsive</h2>
        <p class="feature-description">Our plugin is fully responsive, providing a seamless experience on all devices.</p>
      </div>
      
      <div class="feature-item">
        <i class="feature-icon fas fa-star"></i>
        <h2 class="feature-title">Great Ratings</h2>
        <p class="feature-description">Our plugin has received top ratings and positive reviews from satisfied customers.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-comments"></i>
        <h2 class="feature-title">Excellent Support</h2>
        <p class="feature-description">We provide exceptional customer support to assist you with any plugin-related queries.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-lock"></i>
        <h2 class="feature-title">Secure</h2>
        <p class="feature-description">Rest assured, our plugin follows industry standards to ensure the security of your data.</p>
      </div>
      
      <div class="feature-item">
        <i class="feature-icon fas fa-palette"></i>
        <h2 class="feature-title">Customizable</h2>
        <p class="feature-description">Easily customize the plugin to match your website's design and branding.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-chart-line"></i>
        <h2 class="feature-title">Analytics Integration</h2>
        <p class="feature-description">Integrate the plugin with analytics tools to gain valuable insights and track performance.</p>
      </div>
      <div class="feature-item">
        <i class="feature-icon fas fa-handshake"></i>
        <h2 class="feature-title">Partnership Opportunities</h2>
        <p class="feature-description">Explore partnership opportunities and collaborate with us to enhance your website's functionality.</p>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
require_once('layouts/footer.php');
?>
