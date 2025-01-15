<html><head><title>Cart</title></head>
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
    

    echo "<h1>Current Cart:</h1><br>";

    echo "<table border=1 cellspace=3>";
    echo "<tr>";
    echo "<th>" . "PART NUMBER" . "</th>";
    echo "<th>" . "PART DESCRIPTION" . "</th>";
    echo "<th>" . "PART QUANTITY" . "</th>"; 
    echo "<th>" . "PART WEIGHT" . "</th>"; 
    echo "<th>" . "PART PRICE" . "</th>"; 
    echo "</tr>";
    $max=sizeof($_SESSION['cart']);
    for($i=1; $i<$max; $i++)
    {    
        echo "<tr>";     
        while (list ($key, $val) = each ($_SESSION['cart'][$i])) 
        { 
            echo " <td>  $val  </td>"; 
        } // inner array while loop
        echo "</tr>";

    } // outer array for loop
    echo "</table>";

    $max=sizeof($_SESSION['cart']);

    
    echo "<br> <br> " . "Use this to remove a certain number of a product from the current cart:";
    echo "<br> " . "<form action=parts.php method=POST>";

    echo "Product:    " . "<select name=removeproduct>";

    for($i=1; $i<$max; $i++)
    {    
        $_SESSION['cart'];
        foreach ($_SESSION['cart'][$i] as $key => $value) 
        {
            if (!is_numeric($value)) 
            {
                echo "<option> ". $value . "</option>";
            }
        }

    } // inner array while loop
 

    echo "</select>";

    echo  "Quantity:  " . "<input type=text name=removeamount />";  

    echo   "<input type=submit name=submit value=submit />";

    echo "</form>";


    echo " <br> <button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/parts.php'>";
    echo "Click here to return to the parts page." . "</button>";

    echo " <br> <br> <button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/checkout.php'>";
    echo "Click here to go to checkout page." . "</button>";
?>
