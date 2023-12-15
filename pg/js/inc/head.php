<?php
require_once('system/function.php');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <script data-ad-client="ca-pub-3556385823385370" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title><?php echo webdata('web_tag');?></title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- owl carousel style -->
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.0.0-beta.2.4/assets/owl.carousel.min.css" />
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="<?php echo webdata('web_fav');?>" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<style>
.book_bt a {
    width: 100%;
    float: left;
    font-size: 16px;
    color: #ffffff;
    text-align: center;
    background-color: #151515;
    border: 2px solid #ffffff;
    border-radius: 30px;
    padding: 5px 0px;
}
.sign-new-up {
    background-image: linear-gradient(67deg, #039, #0cf);
    padding: 169px 0 158px;
    /* position: relative; */
}
.banner_section {
    width: 100%;
    float: left;
    padding-bottom: 150px;
}

.background-1 {

   background-image: url(../images/Web-Header-Background-1.svg);
   background-position: center;
   background-repeat: no-repeat;
   background-size: cover;
}
.title {
    text-align: center;
    font-size: 28px;
    color: #011f3f;
    margin: 10px 0;
    letter-spacing: 1px;
}

.price {
    background-image: linear-gradient(67deg, #039, #0cf);
    padding: 169px 0 158px;
    /* position: relative; */
}
.footer_section {
    width: 100%;
    float: left;
    background-color: #007dcb;
    height: auto;
}

body {
    color: #ffffff;
    font-size: 1rem;
    font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;
    line-height: 1.80857;
    font-weight: normal;
    overflow-x: hidden;
}
</style> 


  </head>
   <body>
      <!--header section start -->
      <div class="header_section">
         <div class="container">
            <nav class="navbar navbar-dark bg-dark">
               <a class="logo" href="index.php" style="width: 40%;"><img src="<?php echo webdata('company_logo');?>"></a>
               <div class="search_section">
                  <ul>
                     <li><a href="https://wa.me/91<?php echo support('mobile');?>"><img src="images/whatsapp.png" width="20"></a></li>
                     <li><a href="#Pricing">Pricing</a></li>
					 <li><a href="trial/index.php">Try Demo <span class="badge badge-danger pt-2 pb-2">Free</span></a></li>
					 <li><a href="CreateAccount"><button class="btn btn-primary-outline  btn-sm">Create Account</button></a></li>
                     <li><a href="Login"><button class="btn btn-primary btn-sm">Log In</button></a></li>
                  </ul>
               </div>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse mt-3" id="navbarsExample01">
                  <ul class="navbar-nav mr-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="#Home">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="trial/index.php">Try Demo <span class="badge badge-danger pt-2 pb-2">Free</span></a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#Pricing">Pricing</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#Support">Support</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#About">About</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="Login"><button class="btn btn-primary btn-sm">Log In</button></a>
                     </li>
                  </ul>
               </div>
            </nav>
         </div>
         <!--banner section start -->