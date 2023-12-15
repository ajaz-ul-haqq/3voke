 <!-- footer section start -->
<style>
h4 {
    font-size: 20px;
    font-weight: 700;
}
</style> 
 <div class="footer-main" style="background:black;" id="About">
        <div class="footer-area pt-5">
            <div class="container">
                <div class="row  justify-content-between">
                    <div class="col-lg-3 col-md-4 col-sm-8">
                         <div class="single-footer-caption mb-30">
                              <!-- logo -->
                             <div class="footer-logo">
                                 <a href="index.php">
                                 <img src="<?php echo webdata('company_logo');?>">   
                                 </a>
                             </div>
                             <div class="footer-tittle">
                                 <div class="footer-pera">
<p class="info1 text-white">Manage your Marketplace, Automate Smart UPI Collect Payments, All from a single platform. Fast forward your business with <?php echo webdata('company_name');?>.</p>
                                </div>
                             </div>
                         </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-5">
                        <div class="single-footer-caption mb-50">
                            <div class="text-white">
                                <h4 class="text-white">Quick Links</h4>
                     <p class="call_text"><a href="docs/rechpay-terms_V2.docx" style="color: #ffffff;">Terms of Services</a></p>
                     <p class="call_text"><a href="#" style="color: #ffffff;">API Docs</a></p>
                     <p class="call_text"><a href="#Payments" style="color: #ffffff;">Payments</a></p>
                     <p class="call_text"><span style="color: #ffffff;">UPI</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-7">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4 class="text-white">Support</h4>
                                
                     <p class="call_text"><a href="#" style="color: #ffffff;">+91 <?php echo support('mobile');?></a></p>
                     <p class="call_text"><a href="#" style="color: #ffffff;">+91 <?php echo support('mobile1');?></a></p>
                     <p class="call_text"><a href="#" style="color: #ffffff;"><?php echo support('email');?></a></p>
                     
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-8">
                        <div class="single-footer-caption mb-50">
                             <div class="footer-tittle">
							  <h4 class="text-white">Corporate Address</h4>
                                 <div class="footer-pera">
                                     <p class="info1 text-white">
                                       <?php echo webdata('company_about');?>  
                                         
                                     </p>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
                
                </div>
            </div><hr style="background:white;">
			<div class="col-md-12 pb-4 text-center text-white" style="background:black;"><?php echo webdata('web_rights');?></div>
        </div>
      <!-- footer section end -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <?php echo webdata('live_chat');?>
   </body>
</html>

