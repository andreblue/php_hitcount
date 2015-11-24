<div class="content">
  <table border="1">
    <tr>
      <th>IP</th>
      <th>Time Visited</th>
      <th>Page</th>
    </tr>
  <?php
    $history = $Database->query("SELECT * FROM `history` LIMIT 30");
    while ($row = $history->fetch(PDO::FETCH_OBJ)) {
        echo "<tr><td>{$row->ip}</td><td>{$row->time_visited}</td><td>{$row->page}</td></tr>";
    }
   ?>
 </table>
</div>
