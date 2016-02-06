<?php
require 'inc/checklogin.php';

function get_page_id($contest_id)
{
  return ($contest_id - 1) / 10 + 1;
}

$page_id = 1;
if (isset($_GET['page_id'])) {
  $page_id = intval($_GET['page_id']);
} elseif (isset($_SESSION['view_contest'])) {
  $page_id = get_page_id($_SESSION['view_contest']);
}

require 'inc/database.php';
$contest_id_max = mysql_fetch_assoc(mysql_query("SELECT max(contest_id) FROM contest"))['contest_id'];
$page_id_max = get_page_id($contest_id_max);
if ($page_id < 1 || $page_id > $page_id_max) {
  die('Wrong Page ID.');
}

$contests = mysql_query("SELECT * FROM contest WHERE contest_id BETWEEN $page_id * 10 - 9 AND $page_id * 10");
$Title = "Contestset $page_id";
?>

<!DOCTYPE html>
<html>
  <?php require 'head.php'; ?>

  <body>
    <?php require 'page_header.php' ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="pagination pagination-centered">
          <ul>
            <?php
            if ($page_id_max > 1):
              for ($i = 1; $i <= $page_id_max; ++$i):
                ?>
                <li class="<?= ($i == $page_id) ? 'active' : '' ?>">
                  <a href="contestset.php?page_id=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php
              endfor;
            endif;
            ?>
          </ul>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span10 offset1">
          <?php require 'contestset_table.php' ?>
        </div>
      </div>
      <div class="row-fluid">
        <ul class="pager">
          <li>
            <a class="pager-pre-link shortcut-hint" title="Alt+A" href="#" id="btn-pre">&larr; Previous</a>
          </li>
          <li>
            <a class="pager-next-link shortcut-hint" title="Alt+D" href="#" id="btn-next">Next &rarr;</a>
          </li>
        </ul>
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
        var cur_page = <?= $page_id ?>, max_page = <?= $page_id_max ?>
          $('#nav_set').parent().addClass('active');
        $('#ret_url').val("contestset.php?page_id=" + cur_page);

        //TODO save contest
        $('#btn-next').click(function () {
          if (cur_page < max_page) {
            location.href = 'contestset.php?page_id=' + (cur_page + 1);
          }
          return false;
        });
        $('#btn-pre').click(function () {
          if (cur_page > 10) {
            location.href = 'contestset.php?page_id=' + (cur_page - 1);
          }
          return false;
        });
      });
    </script>
  </body>
</html>