<?php
require 'inc/checklogin.php';

$contest_id = 1;
if (isset($_GET['contest_id'])) {
  $contest_id = intval($_GET['contest_id']);
} elseif (isset($_SESSION['view_contest'])) {
  $contest_id = intval($_SESSION['view_contest']);
}

require 'inc/database.php';

$query = "SELECT * FROM contest WHERE contest_id=$contest_id";
$contest_info = mysql_fetch_assoc(mysql_query($query));
if (!$contest_info) {
  die('Wrong Contest ID.');
}
$Title = "Contest $contest_id";
$contest_problems = mysql_query("SELECT problem_id, title FROM contest_problem WHERE contest_id=$contest_id");
$_SESSION['view_contest'] = $contest_id;
?>

<!DOCTYPE html>
<html>

  <?php require 'head.php' ?>

  <body>
    <?php require 'page_header.php' ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span9">
          <div class="center problem-title">
            <h2><?= $contest_info['title'] ?></h2>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <h3 class="problem-subtitle">Description</h3>
              <div class="well well-small"><?= nl2br($contest_info['description']); ?></div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <h3 class="problem-subtitle">Problems</h3>
            </div>
          </div>
          <div class="row-fluid">
            <div class="pagination pagination-centered">
              <ul>
                <li><a href="level.php?level=1">Levels &raquo;</a></li>
              </ul>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
              <?php require 'contestpage_table.php'; ?>
            </div>
          </div>
        </div>
        <div class="span3">
          <div class="row-fluid">
            <div class="span12">
              <div class="well well-small">
                <table class="table table-condensed table-striped" style="margin-bottom: 0">
                  <tbody>
                    <tr>
                      <td style="text-align: left">Start Time:</td>
                      <td><?= $contest_info['start_time'] ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: left">End Time:</td>
                      <td><?= $contest_info['end_time'] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row-fluid">
            <div class="span12" style="text-align: center">
              <div class="well well-small problem-operation" style="margin-top: 10px" id="function">
                <?php require 'contest_register.php' ?>
                <a href="contest_status.php?contest_id=<?= $contest_id ?>" class="btn btn-info">Status</a>
                <!-- TODO Implement discussion for contests -->
                <a href="board.php?contest_id=<?= $contest_id ?>" class="btn btn-warning">Discuss</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <footer>
        <p>&copy; 2012-2014 Bashu Middle School</p>
      </footer>
    </div>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/common.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#nav_contest').parent().addClass('active');
        $('#ret_url').val("contestpage.php?contest_id=" + <?= $contest_id ?>);

        $('#contestpage_table').click(function (E) {
          var $target = $(E.target);
          if ($target.is('i.save_problem')) {
            var pid = $target.attr('data-pid');
            var op;
            if ($target.hasClass('icon-star'))
              op = 'rm_saved';
            else
              op = 'add_saved';
            $.get('ajax_saveproblem.php?prob=' + pid + '&op=' + op, function (result) {
              if (/__ok__/.test(result)) {
                $target.toggleClass('icon-star-empty');
                $target.toggleClass('icon-star');
              }
            });
          }
        });
      });
    </script>
  </body>
</html>