<script type='text/javascript', src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script type='text/javascript', src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script type='text/javascript', src='https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js'></script>
<script type='text/javascript', src='https://cdn.rawgit.com/almasaeed2010/AdminLTE/master/plugins/iCheck/icheck.min.js'></script>
<script>
	$(document).ready(function() {
      $(".sidebar-menu li a").on("click", function(){
      $(".sidebar-menu li").find(".active").removeClass("active");
      $(this).parent().addClass("active");
   });
});
</script>