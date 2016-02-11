<?php
require 'inc/database.php';

$contest_id = isset($_GET['contest_id']) ? intval($_GET['contest_id']) : 1;
$start_time = mysql_fetch_row(mysql_query("SELECT start_time FROM contest WHERE contest_id=$contest_id"))[0];
$end_time = mysql_fetch_row(mysql_query("SELECT end_time FROM contest WHERE contest_id=$contest_id"))[0];

$problems_result = mysql_query("SELECT problem_id FROM contest_problem WHERE contest_id=$contest_id");
$problem_ids = [];
while ($problem = mysql_fetch_row($problems_result)) {
  $problem_ids[] = $problem[0];
}

$contestants_result = mysql_query("SELECT contestants FROM contest WHERE contest_id=$contest_id");
$contestants = json_decode(mysql_fetch_row($contestants_result)[0]);

$total_scores = [];
$table_data = [];
foreach ($contestants as $contestant) {
  foreach ($problem_ids as $problem_id) {
    $query = <<<EOD
SELECT MAX(score)
FROM solution
WHERE user_id='$contestant' AND problem_id=$problem_id AND in_date BETWEEN '$start_time' AND '$end_time'
EOD;
    $score = mysql_fetch_row(mysql_query($query))[0];
    $table_data[$contestant][$problem_id] = $score;
    if (!array_key_exists($contestant, $total_scores)) {
      $total_scores[$contestant] = 0;
    }
    $total_scores[$contestant] += $score;
  }
}
array_multisort($total_scores, SORT_DESC, $contestants, SORT_ASC, $table_data);

$Title = "Contest $contest_id status";
?>

<!DOCTYPE html>
<html>
  <?php require 'head.php'; ?>
  <body>
    <?php require 'page_header.php'; ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span10 offset1">
          <?php require 'contest_status_table.php'; ?>
        </div>
      </div>
      <footer>
        <p>&copy; 2012-2014 Bashu Middle School</p>
      </footer>
    </div>
  </body>
</html>
