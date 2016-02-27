<span id="contest-register-cell-<?= $contest_id ?>">
  <?php
  $user_id = NULL;
  if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
  }
  $query = "SELECT contestants FROM contest WHERE contest_id=$contest_id";
  $contestants = json_decode(mysql_fetch_row(mysql_query($query))[0]);
  ?>
  <?php if (!is_array($contestants) || !in_array($user_id, $contestants) || !isset($user_id)): ?>
    <a href="#" id="contest-register-<?= $contest_id ?>" class="btn btn-primary">Register</a>
    <script src="../assets/js/jquery.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $('#contest-register-<?= $contest_id ?>').click(function () {
          <?php if (!isset($user_id)): ?>
          alert("You haven't logged in.");
          <?php else: ?>
          $.ajax({
            type: 'POST',
            url: 'ajax_contestregister.php',
            data: {
              user_id: '<?= $user_id ?>',
              contest_id: <?= $contest_id ?>
            },
            success: function (msg) {
              if (msg == 'success') {
                $('#contest-register-cell-<?= $contest_id ?>').append('<span class="label label-success">Registered</span>');
                $('#contest-register-<?= $contest_id ?>').remove();
              } else {
                alert(msg);
              }
            }
          });
          <?php endif; ?>
        });
      });
    </script>
  <?php else: ?>
    <span class="label label-success">Registered</span>
    <!-- TODO Add cancel -->
  <?php endif; ?>
</span>