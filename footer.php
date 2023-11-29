<?php $urlpage= basename($_SERVER['PHP_SELF']);
$active='';

?>
<div class="appBottomMenu">
  <div class="item <?php if($urlpage=='index.php'){echo'active';}?>"> <a href="index.php">
    <p> <i class="icon ion-md-home"></i> <span>Home</span> </p>
    </a>  </div>
  <div class="item <?php if ($urlpage == 'login.php' ||  $urlpage == 'signup.php' || $urlpage == 'profile.php') { echo 'active'; } ?>"> <a href="login.php" class="icon toggleSidebar">
    <p> <i class="icon ion-md-person"></i> <span>My </span> </p>
    </a> </div>
</div>