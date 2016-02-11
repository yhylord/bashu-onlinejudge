<?php
session_start();
if (!isset($_SESSION['user'], $_SESSION['administrator'])) {
  var_dump($_SESSION);
  die('You are not the administrator');
}

/**
 * Class ContestEditor
 *
 * Creates or edits contests.
 *
 * Receives title, start time (required), end time (required), description, id (if edit) and problems (required) of contests
 * , checks them (throws exceptions if needed) and saves.
 */
class ContestEditor
{
  private $title, $start_time, $end_time, $description, $id, $problems;

  public function __construct()
  {
    require 'inc/database.php';

    $this->title = isset($_POST['title']) ? mysql_real_escape_string($_POST['title']) : '';

    if (!isset($_POST['start_time'])) {
      throw new Exception('Start time not set');
    }
    $this->start_time = mysql_real_escape_string($_POST['start_time']);
    //TODO add min value

    if (!isset($_POST['end_time'])) {
      throw new Exception('End time not set');
    }
    $this->end_time = mysql_real_escape_string($_POST['end_time']);
    //TODO add min value

    $this->description = isset($_POST['description']) ? mysql_real_escape_string($_POST['description']) : '';

    if (!isset($_POST['problems'])) {
      throw new Exception('Problems not set');
    }
    /**
     * Split input by line break
     *
     * @see http://stackoverflow.com/a/11165332/3226641
     */
    $this->problems = preg_split('/\n|\r/', $_POST['problems'], -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($this->problems)) {
      throw new Exception('Invalid problems');
    }
    $problem_id_max = mysql_fetch_row(mysql_query("SELECT MAX(problem_id) FROM problem"))[0];
    $problem_id_min = mysql_fetch_row(mysql_query("SELECT MIN(problem_id) FROM problem"))[0];
    foreach ($this->problems as $index => &$problem) {
      if (!is_numeric($problem) || !($problem_id_min <= intval($problem) && intval($problem) <= $problem_id_max)) {
        throw new Exception("Invalid problem ID: $problem (No. $index in the problem list)");
      }
      $problem = intval($problem);
    }
  }

  public function add()
  {
    $this->id = 1;
    $result = mysql_query("SELECT MAX(contest_id) FROM contest");
    if (($row = mysql_fetch_row($result)) && intval($row[0])) {
      $this->id = intval($row[0]) + 1;
    }
    $add_contest_info = "INSERT INTO contest (contest_id, title, start_time, end_time, description, contestants)
                VALUES ($this->id, '$this->title', '$this->start_time', '$this->end_time', '$this->description', '[]')";
    $this->test($add_contest_info);
    $this->add_problems();
    header("Location: contestpage.php?contest_id=$this->id");
  }

  /**
   * Executes MySQL statements and throws exceptions if failed.
   *
   * @param $query string a MySQL statement to be executed
   * @throws Exception if query failed
   */
  private function test($query)
  {
    if (!mysql_query($query)) {
      throw new Exception("Operation failed");
    }
  }

  private function add_problems()
  {
    foreach ($this->problems as $problem) {
      $title = mysql_fetch_row(mysql_query("SELECT title FROM problem WHERE problem_id=$problem"))[0];
      $add_problem = "INSERT INTO contest_problem (problem_id, contest_id, title) VALUES ($problem, $this->id, '$title')";
      $this->test($add_problem);
    }
  }

  public function edit()
  {
    if (!isset($_POST['contest_id'])) {
      throw new Exception('No such contest');
    }
    $this->id = intval($_POST['contest_id']);
    $update_contest_info = "UPDATE contest
              SET title='$this->title', start_time='$this->start_time', end_time='$this->end_time', description='$this->title'
              WHERE contest_id=$this->id";
    $this->test($update_contest_info);
    $delete_previous_problems = "DELETE FROM contest_problem WHERE contest_id=$this->id";
    $this->test($delete_previous_problems);
    $this->add_problems();
    header("Location: contestpage.php?contest_id=$this->id");
  }
}

if (!isset($_POST['op'])) {
  echo 'Invalid operation.';
}

try {
  $editor = new ContestEditor();
  $editor->$_POST['op']();
} catch (Exception $e) {
  echo $e->getMessage();
  return;
}
echo 'success';