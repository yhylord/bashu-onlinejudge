<table class="table table-hover table-bordered">
  <thead>
    <tr>
      <th>Rank</th>
      <th>Contestant</th>
      <th>Total Score</th>
      <?php foreach ($problem_ids as $problem_id): ?>
        <th>
          <a href="problempage.php?=problempage.php?problem_id=<?= $problem_id ?>"><?= $problem_id ?></a>
        </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php $rank = 0; ?>
    <?php foreach ($table_data as $contestant => $problems): ?>
      <tr>
        <td><?= ++$rank ?></td>
        <td><?= $contestant ?></td>
        <td><?= $total_scores[$contestant] ?></td>
        <?php foreach ($problems as $score): ?>
          <td><?= intval($score) ?></td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>