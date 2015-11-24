<div class="content">
  <table border="1">
    <tr>
      <th>Page</th>
      <th>Total Hits</th>
    </tr>
  <?php
    $history = $Database->query("SELECT * FROM `hits`");
    while ($row = $history->fetch(PDO::FETCH_OBJ)) {
        echo "<tr><td>{$row->page}</td><td>{$row->hitcount}</td></tr>";
    }
   ?>
 </table>
</div>
