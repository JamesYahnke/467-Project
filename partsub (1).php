<html><head><title>Add To Cart</title></head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
    <header class="w3-container w3-cyan">
    <h5><a href="index.php">Home</a>
    <a href="parts.php">Shop</a>
    <a href="employeeportal.php">Warehouse</a>
    <a href="adminportal.php">Admin</a>
    <a href="receiving.php">Receiving</a>
    <a href="shipping.php">Shipping</a>
    </header>
</body>
</html>

<?php

    session_start();

    try { // if something goes wrong, an exception is thrown
        $dsn = "mysql:host=courses; dbname=z1922762";
        $pdo = new PDO($dsn, "z1922762", "2003May20");
    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
    }

    /*
    try { // if something goes wrong, an exception is thrown
        $dsn = "mysql:host=blitz.cs.niu.edu; dbname=csci467";
        $pdo = new PDO($dsn, 'student', 'student');
        }
        catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
        }
*/


    $prodd = $_POST["product"];
    $totalprod = 0;
    $rs = $pdo->query("SELECT qty FROM parts_main WHERE description = '$prodd'");
    while ($data = ($rs->fetch()))
    {
        $totalprod = $data["qty"];
    }

    if ($totalprod != 0)
    {
        echo "<br> " . "<form action=parts.php method=POST>";

        echo "product    " . "<select name=product>";
      
        echo "<option> ". $prodd . "</option>";     

        echo "</select>";

        /////////////////////////////

        echo  "quantity:  " . "<input type=text name=quantity />";  

        echo   "<input type=submit name=submit value=submit />";

        echo "</form>";

        echo "There are currently " . $totalprod . " available for purchase. <br>";
    }
    else
    {
        echo "This must be a popular product!  We are currently out of stock at this time, please try again some other time. <br>";
    }
    echo "<button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/cart.php'>";

    echo "Click Here to return without adding to the cart." . "</button>";
?>
