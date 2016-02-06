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
    <tr>
      <?php
      while ($contest = mysql_fetch_assoc($contests)):
        $contest_id = $contest['contest_id'];
        ?>
        <td><?= $contest_id ?></td>
        <?php if ($logged_in): ?>
        <td>
          <?php
          $query = "SELECT contestants FROM contest WHERE contest_id=$contest_id";
          $contestants = unserialize(mysql_fetch_assoc(mysql_query($query))['contestants']);
          ?>
          <?php if (in_array($_SESSION['user'], $contestants)): ?>
            <a href="#">Register</a> <!-- TODO Implement this -->
          <?php else: ?>
            <span class="label label-success">Registered</span>
          <?php endif; ?>
        </td>
      <?php endif; ?>
        <td style="text-align: left">
          <a href="contestpage.php?=<?= $contest_id ?>"><?= $contest['title'] ?></a>
        </td>
        <td><?= $contest['start_time'] ?></td>
        <td><?= $contest['end_time'] ?></td>
      <?php endwhile; ?>
    </tr>
  </tbody>
</table>