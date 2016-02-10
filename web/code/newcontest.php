<?php
require 'inc/checklogin.php';
if (!isset($_SESSION['user'], $_SESSION['administrator'])) {
  $info = 'You are not administrator';
}
$Title = "New contest";
?>
<!DOCTYPE html>
<html>
  <?php require 'head.php'; ?>
  <body>
    <?php require 'page_header.php' ?>
    <!-- TODO Align with newproblem.php -->
    <div class="container-fluid edit-page">
      <?php
      if (isset($info)) {
        die($info);
      }
      ?>
      <form action="editcontest.php" method="post" id="edit_form" style="padding-top: 10px">
        <input type="hidden" name="op" value="add" required>
        <div class="row-fluid">
          <div class="span9">
            <p><span>Title: </span><textarea title="Title" class="span8" name="title" id="contest-title"
                                             rows="1"></textarea></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p><span>Start Time: <input title="Start Time" type="datetime-local" name="start_time"
                                        id="contest-start-time" required></span></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p><span>End Time: <input title="End Time" type="datetime-local" name="end_time" id="contest-end-time"
                                      required></span></p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              <span>Description:</span>
              <textarea title="Description" class="span12" name="description" id="contest-description"
                        rows="13"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9">
            <p>
              <span>Problems:</span>
              <textarea placeholder="Please split problems by line breaks" title="Problems" name="problems"
                        class="span12" id="" cols="30" rows="10"></textarea>
            </p>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span9" style="text-align:center">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div>
        </div>
      </form>
    </div>
    <div class="html-tools">
      <div class="well well-small margin-0" id="tools">
        <table class="table table-bordered table-condensed table-striped" style="width:100%">
          <caption>HTML Tools</caption>
          <thead>
            <tr>
              <th>Function</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_less">Less(&lt;)</button>
              </td>
              <td>&amp;lt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_greater">Greater(&gt;)</button>
              </td>
              <td>&amp;gt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_img">Image</button>
              </td>
              <td>&lt;img src=&quot;...&quot;&gt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_sup">Superscript</button>
              </td>
              <td>&lt;sup&gt;...&lt;/sup&gt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_sub">Subscript</button>
              </td>
              <td>&lt;sub&gt;...&lt;/sub&gt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_samp">Monospace</button>
              </td>
              <td>&lt;samp&gt;...&lt;/samp&gt;</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_inline">Inline TeX</button>
              </td>
              <td>[inline]...[/inline]</td>
            </tr>
            <tr>
              <td>
                <button class="btn btn-mini" id="tool_tex">TeX</button>
              </td>
              <td>[tex]...[/tex]</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="text-align:center;margin-top:10px">
        <button class="btn btn-info" id="btn_upload">Upload Image</button>
      </div>
    </div>
    <!--TODO Add datetimepicker -->
    <!--TODO Client side validation -->
  </body>
</html>
