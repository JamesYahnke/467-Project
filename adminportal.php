<html><head><title>Admin Portal</title></head>
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
        <?php
        try
        {
            $dsn = "mysql:host=courses;dbname=z1922762";
            $pdo = new PDO($dsn, "z1922762", "2003May20");
        }
        catch(PDOexception $e)
        {
            echo "Connection to database failed: " . $e->getMessage();
            die();
        }

        echo "<h1>Customer Orders</h1>";
        // Column titles
        echo "All Orders\n";
        echo "<table border=1 cellspacing=2>";
        echo "<tr>";
        echo "<td>Order Number</td>";
        echo "<td>Date</td>";
        echo "<td>Customer Name</td>";
        echo "<td>Customer email</td>";
        echo "<td>Customer Address</td>";
        echo "<td>Total</td>";
        echo "<td>Order Weight</td>";
        echo "<td>Status</td>";
        echo "<td>Tracking</td>";
        echo "</tr>";
            // Show table of outstanding order information
            $order = $pdo->query("SELECT * FROM ORDERS;");
            $rows = $order->fetchAll(PDO::FETCH_ASSOC);

            // Table data
            foreach($rows as $row)
            {
                echo "<tr>";
                echo "<td>", $row["ORDER_NUM"], "</td><td>", $row["ORDER_DATE"], "</td><td>", $row["CUS_NAME"], "</td><td>", $row["CUS_EMAIL"], "</td><td>", $row["CUS_ADDRESS"], "</td><td>", $row["TOTAL"], "</td><td>", $row["ORDER_WEIGHT"], "</td><td>", $row["STATUS"], "</td><td>", $row["TRACKING"], "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br><br>";
            
            // Pull order information + contents
            echo"<html><body>";
            echo"<form action='' method='GET'>";
            echo"<br>";
            echo"<p>Pull Order Details</p>";
            echo"Order Number<input type='text' name='ordernum' required/>";
            echo"<br><br>";
            echo"<input type='submit' name='ordersubmit' value='Submit' /> <br>";
            echo"<input type='reset' name='reset' value='Reset Form' /> <br>";
            echo "</form></body></html>";

            
            if(isset($_GET['ordersubmit']))
            {
                $on = $_GET["ordernum"];
            
                $cmd = "SELECT * FROM ORDERS WHERE ORDER_NUM=?";
                $stmt = $pdo->prepare($cmd);
                $stmt->execute([$on]);
                $gt = $stmt->fetch();

                if($gt)
                {
                    echo "<h1>Customer order details for: $on</h1>";
                    // Column titles
                    echo "<table border=1 cellspacing=2>";
                    echo "<tr>";
                    echo "<td>Order Number</td>";
                    echo "<td>Date</td>";
                    echo "<td>Customer Name</td>";
                    echo "<td>Customer email</td>";
                    echo "<td>Customer Address</td>";
                    echo "<td>Total</td>";
                    echo "<td>Order Weight</td>";
                    echo "<td>Status</td>";
                    echo "<td>Tracking</td>";
                    echo "</tr>";
                    
                    $order = $pdo->query("SELECT * FROM ORDERS WHERE ORDER_NUM = '$on';");
                    $rows = $order->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Table data
                    foreach($rows as $row){
                        echo "<tr>";
                        echo "<td>", $row["ORDER_NUM"], "</td><td>", $row["ORDER_DATE"], "</td><td>", $row["CUS_NAME"], "</td><td>", $row["CUS_EMAIL"], "</td><td>", $row["CUS_ADDRESS"], "</td><td>", $row["TOTAL"], "</td><td>", $row["ORDER_WEIGHT"], "</td><td>", $row["STATUS"], "</td><td>", $row["TRACKING"], "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
            
                    echo "<h3>Order contents</h3>";
                    // Column titles
                    echo "<table border=1 cellspacing=2>";
                    echo "<tr>";
                    echo "<td>Order Number</td>";
                    echo "<td>Number</td>";
                    echo "<td>Name</td>";
                    echo "<td>Weight</td>";
                    echo "<td>QTY</td>";
                    echo "</tr>";
                    
                    $order = $pdo->query("SELECT * FROM HAS WHERE ORDER_NUM = '$on';");
                    $rows = $order->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Table data
                    foreach($rows as $row){
                        echo "<tr>";
                        echo "<td>", $row["ORDER_NUM"], "</td><td>", $row["NUM"], "</td><td>", $row["DESC"], "</td><td>", $row["WEIGHT"], "</td><td>", $row["QTY"], "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<br>";
                }
                else
                {
                    echo "Order not found!";
                    echo "<br>";
                }
            }
        ?>
    </body>
</html>