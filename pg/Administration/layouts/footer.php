</div>
    
    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="../assets/dist/js/vendor.js"></script>
    <script src="../assets/dist/js/adminx.js"></script>
    <script src="../assets/dist/js/table2excel.js"></script>
	<script src="../assets/dist/js/custom-new.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    
	<script type="text/javascript">
        function Export(str) {
            $(".table").table2excel({
                filename: str+".xls"
            });
        }
    </script>
<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  alert("Copied Successfully!");
  $temp.remove();
}   
</script>
  
  </body>
</html>