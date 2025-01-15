<!DOCTYPE html>
<html lang="en">
<head>

  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <title>Parts</title>
</head>
<body>  <!-- Header Bar -->
  <header class="w3-container w3-cyan">
    <h5><a href="index.php">Home</a>
    <a href="parts.php">Shop</a>
    <a href="employeeportal.php">Warehouse</a>
    <a href="adminportal.php">Admin</a>
    <a href="receiving.php">Receiving</a>
    <a href="shipping.php">Shipping</a>
  </header>
<?php
function draw_table($rows){
  echo "<table border=1 cellspacing=1>";
  echo "<tr>";
  foreach($rows[0] as $key => $item ){
    echo "<th>$key</th>";
  }
  echo "</tr>";
  foreach($rows as $row){
    echo "<tr>";
    foreach($row as $key => $item){
      echo "<td>$item</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
}
  try {
    $dsn = "mysql:host=courses;dbname=z1922762";
    $username = "z1922762";
    $password = "2003May20";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    ?>
    <h4>Add a New Weight Bracket: </h4>
    <form method="post" action="shipping.php">
    Min: <input type="text" name="min" />
    Max: <input type="text" name="max" />
    Cost: <input type="text" name="cost" />
    <input type="submit" value="submit" />
    </form> <?php
    if(!empty($_POST["min"]) && !empty($_POST["max"]) && !empty($_POST["cost"])){
      $rs = $pdo->prepare("INSERT INTO WEIGHT VALUES(?, ?, ?);");
      $rs->execute(array($_POST["min"], $_POST["max"], $_POST["cost"]));
      if(!$rs) { echo "Error in query"; die(); }
      echo "<p>Weight Bracket Added!</p>";
    }
    $rs = $pdo->query("SELECT * FROM WEIGHT ORDER BY MIN;");

    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>All Weight Brackets: </h3>";
    draw_table($rows);
  }
  catch(PDOexception $e) {
    echo "Connection to database failed: " . $e->getMessage();
  }
?>
</body>
</html>
