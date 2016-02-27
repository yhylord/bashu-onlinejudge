<?php
$logged_in = isset($_SESSION['user']);
?>
<table class="table table-striped table-bordered" id="contestset-table">
  <thead>
    <tr>
      <th style="width: 6%">ID</th>
      <th colspan=<?= $logged_in ? 2 : 1 ?>>Title</th>
      <th style="width: 20%">Start Time</th>
      <th style="width: 20%">End Time</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($contest = mysql_fetch_assoc($contests)):
      $contest_id = $contest['contest_id'];
      ?>
      <tr>
        <td><?= $contest_id ?></td>
        <?php if ($logged_in): ?>
          <td>
            <?php require 'contest_register.php' ?>
          </td>
        <?php endif; ?>
        <td style="text-align: left; border-left: 0">
          <a href="contestpage.php?contest_id=<?= $contest_id ?>"><?= $contest['title'] ?></a>
        </td>
        <td><?= $contest['start_time'] ?></td>
        <td><?= $contest['end_time'] ?></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>