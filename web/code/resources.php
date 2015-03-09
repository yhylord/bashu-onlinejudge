<?php
require('inc/checklogin.php');
$Title="Learning Resources";
?>
<!DOCTYPE html>
<html>
  <?php require('head.php'); ?>
  <body>
    <?php require('page_header.php') ?>  
          
    <div class="container-fluid about-page">
      <div class="row-fluid">
        <div class="span12">
          <iframe src="about:blank" id="extplorer" name="extplorer" frameborder="0" style="width: 100%;height: 600px;"></iframe>
        </div>
      </div>
      
      <hr>
      <footer>
        <p>&copy; 2012-2015 Bashu Middle School</p>
      </footer>
    </div>
    <form action="eXtplorer/" method="post" target="extplorer" id="extplorer_login">
      <input type="hidden" name="option" value="com_extplorer">
      <input type="hidden" name="action" value="login">
      <input type="hidden" name="type" value="extplorer">
      <input type="hidden" name="username" value="<?php echo $_SESSION['user']; ?>">
      <input type="hidden" name="password" value="useless">
      <input type="hidden" name="lang" value="simplified_chinese">
    </form>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script type="text/javascript"> 
      $(document).ready(function(){
        $('#ret_url').val("resources.php");
        $('#nav_res').parent().addClass('active');
        $('#extplorer_login').get(0).submit();
      });
    </script>
  </body>
</html>
