<html><head><title>Checkout</title></head>
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
    $grandtotal = 0;
     
    echo "<h1>Checkout Page:</h1><br>";

    echo "Weight Brackets used for calculating shipping price. <br> <br>";
    $rs = $pdo->query("SELECT * FROM WEIGHT");
    echo "<table border=0 cellspace=1 cellpadding=10 allign=right>";
    echo"<tr>";
    echo "<td>" . "Min" . "</td>";
    echo "<td>" . "Max    " . "</td>";
    echo "<td>" . "Cost" . "</td>"; 
    echo "</tr>";
 
    while($data = ($rs->fetch()))
    {
        echo "<tr>";
        
        echo "<td>" . ($data["MIN"]) . " Lb.</td>";
        echo "<td>   " . ($data["MAX"]) . " Lb.</td>";
        echo "<td>$" . ($data["COST"]) . "</td>";

        echo "</tr>";

    }
    echo "</table>";

    echo "<br> <br> FINAL CART <br> <br>";

    echo "<table border=1 cellspace=3 cellpadding=4>";
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
    echo " <br> <br> would you like to make any final changes?     ->";
    echo "<button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/parts.php'>";
    echo "Back to Cart" . "</button>";


    echo "</table>" . "<br> <br>";


    echo "<br> <br> CURRENT TOTALS <br>";

    $grossmoney = 0;
    $grossweight = 0;   
    $totalmoney = 0;
    $totalweight = 0;

   

    for($n=1; $n<$max; $n++)
    {
        $keys = array_keys($_SESSION['cart']);
    }

    for($i = 1; $i < count($_SESSION['cart']); $i++) 
    {
        echo "<br> <br>";
        echo "<table border=0 cellspace=5>";         

        foreach($_SESSION['cart'][$keys[$i]] as $key => $value)
        {   
            if ($key == 'number')
            {
                echo " <tr> <td> part number: </td>";
                echo "<td> $value </td> </tr>";
                $partnumber = $value;
            }
            if ($key == 'quantity')
            {
                echo " <tr> <td> number of parts buying: </td>";
                echo "<td> $value </td> </tr>";
                $numparts = $value;
            }
            if ($key == 'weight')
            {
                echo " <tr> <td> total price of buying " . $numparts . " instances of part number " . $partnumber . ": </td>";
                $grossmoney = $numparts * $value;
                echo "<td> $$grossmoney </td> </tr>";
                $totalmoney += $grossmoney;
            }
            if ($key == 'price')
            {
                echo " <tr> <td> total weight of " . $numparts . " instances of part number " . $partnumber . ": </td>";
                $grossweight = $numparts * $value;
                echo "<td> $grossweight </td> </tr>";
                $totalweight = $totalweight + $grossweight;                
            }
        }
        echo "</table> <br> <br>";



    }

    $rs = $pdo->query("SELECT COST FROM WEIGHT WHERE MIN < '$totalweight' ORDER BY MAX DESC LIMIT 1");


    echo "<table border=0 cellspace=1 cellpadding=5 allign=right>";
    echo"<tr>";
    echo "<td>" . "Total price of products: " . "</td>";
    echo "<td>$" .  $totalmoney  . "</td>";
    echo "</tr>";
    echo"<tr>";
    echo "<td>" . "Total weight of products: " . "</td>";
    echo "<td>" .  $totalweight  . " Lb</td>";
    echo "</tr>";
    echo "<td>" . "The added shipping cost for the weight is: " . "</td>";

    if ($rs != 'NULL')
    {
        while($data = ($rs->fetch()))
        {
            echo "<td>$"  . $data["COST"]  ."</td>";
            $grandtotal = $data["COST"] + $totalmoney;
            echo "</tr>";
            echo "<tr> <td> Your grand total will be:  </td>";
            echo "<td> $" . $grandtotal . "</td> </tr>";
        }
    }

    echo "</table>";


    echo"<html><body>";
    echo"<form action='final.php' method='POST'>";
    echo"<br>";
    echo"<p>Credit card input</p>";
    echo"Name:<br><input type='text' name='name' required/><br>";
    echo"eMail:<br><input type='text' name='email' required/><br>";
    echo"Address:<br><input type='text' name='address' required/><br>";
    echo"CC Num:<br><input type='text' name='cc' required/><br>";
    echo"Exp Date:<br><input type='text' name='exp' required/><br>";
    echo"<input type='submit' name='statussubmit' value='Submit' /> <br>";
    echo"<input type='reset' name='reset' value='Reset Form' /> <br>";
    echo"<input type='hidden' name='money' value='$grandtotal'>";
    echo"<input type='hidden' name='weight' value='$totalweight'>";
    echo"</form></body></html>";

?>
