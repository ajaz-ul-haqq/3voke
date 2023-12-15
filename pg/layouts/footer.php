</div>
    
    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="assets/dist/js/vendor.js"></script>
    <script src="assets/dist/js/adminx.js"></script>
    <script src="assets/dist/js/table2excel.js"></script>
	<script src="assets/dist/js/custom-new.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    
	<script type="text/javascript">
        function Export(str) {
            $(".table").table2excel({
                filename: str+".xls"
            });
        }
    </script>
<script src="assets/dist/js/swipe.js"></script>
<script>
       
            window.onload = function() {

                document.addEventListener('swiped-right', function(e) {
                    //alert(e.type);
                    $(".adminx-sidebar").addClass("in");   
                });
                
                document.addEventListener('swiped-left', function(e) {
                    //alert(e.type);
                    $(".adminx-sidebar").removeClass("in");   
                });

            }
   </script>
  
  </body>
</html>