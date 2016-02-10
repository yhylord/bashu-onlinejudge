<table class="table table-striped table-bordered" id="contestpage_table">
  <thead>
    <tr>
      <th style="width:6%">ID</th>
      <?php
      if (isset($_SESSION['user']))
        echo '<th colspan=2>Title</th>';
      else
        echo '<th>Title</th>';
      ?>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php
      while ($problem = mysql_fetch_assoc($contest_problems)):
        $problem_id = $problem['problem_id'];
        ?>
        <td><?= $problem_id ?></td>
        <td style="text-align:left">
          <a href="problempage.php?problem_id=<?= $problem_id ?>"><?= $problem['title'] ?></a>
        </td>
        <?php
        if (isset($_SESSION['user'])):
          $user_id = $_SESSION['user'];
          require_once 'inc/database.php';
          $saved = mysql_fetch_assoc(mysql_query("SELECT * FROM saved_problem WHERE user_id='$user_id' AND problem_id=$problem_id"));
          ?>
          <td class="width-for-2x-icon" style="border-left:0">
            <i data-pid="<?= $problem_id ?>"
               class="icon-2x text-warning save_problem <?= $saved ? 'icon-star' : 'icon-star-empty' ?>"
               style="cursor: pointer">
            </i>
          </td>
        <?php
        endif;
        ?>
      <?php
      endwhile;
      ?>
    </tr>
  </tbody>
</table>