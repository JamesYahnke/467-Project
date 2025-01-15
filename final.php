<html><head><title>Final Order</title></head>
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

    $pdo = 0;

    try { // if something goes wrong, an exception is thrown
        $dsn = "mysql:host=courses; dbname=z1922762";
        $pdo = new PDO($dsn, "z1922762", "2003May20");
    }
    catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
    }


    if(isset($_POST['statussubmit']))
    {
        $verify = 0;
        $cn = $_POST["name"]; //Cus name
        $ce = $_POST["email"]; //Cus email
        $ca = $_POST["address"]; // Cus address
        $cc = $_POST["cc"]; // Cus credit card
        $cx = $_POST["exp"]; // Cus exp
        $cm = $_POST["money"];
        $cw = $_POST["weight"];

        //<?php
        $url = 'http://blitz.cs.niu.edu/CreditCard/';
        $data = array(
            'vendor' => 'Defective Parts',
            'trans' => '907-987654321-296',
            'cc' => $cc,
            'name' => $cn, 
            'exp' => $cx, 
            'amount' => $cm);
        
        $options = array(
            'http' => array(
                'header' => array('Content-type: application/json', 'Accept: application/json'),
                'method' => 'POST',
                'content'=> json_encode($data)
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        $word = '"errors":["';
        $mystring = $result;

        // Test if string contains the word 
        if(strpos($mystring, $word) != true)
        {
            echo "<h1>Thank you for using our website.  Have a great day!</h1>";

            $date = date('y-m-d h:i:s');
            $sql = "INSERT INTO ORDERS (ORDER_DATE, CUS_NAME, CUS_EMAIL, CUS_ADDRESS, TOTAL, ORDER_WEIGHT, STATUS, TRACKING)
            VALUES('$date',
                '$cn',
                '$ce',
                '$ca',
                '$cm',
                '$cw',
                'RECEIVED',
                'NULL')";

            $pdo->query($sql);

            $rs = $pdo->query("SELECT ORDER_NUM FROM ORDERS ORDER BY ORDER_NUM DESC LIMIT 1");
            $data = ($rs->fetch());

            $ordernumber = $data["ORDER_NUM"];

            $max=sizeof($_SESSION['cart']);

            for($n=1; $n<$max; $n++)
            {
                $keys = array_keys($_SESSION['cart']);
            }
        
            for($i = 1; $i <  $max; $i++) 
            {

                $descrip = 0;
                $partnumber = 0;
                $numparts = 0;
                $weight = 0;

                while (list ($key, $value) = each ($_SESSION['cart'][$i])) 
                {   
                    if ($key == 'description')
                    {
                        $descrip = $value;
                        //echo "$value";
                    }
                    if ($key == 'number')
                    {
                        //echo "$value";
                        $partnumber = $value;
                    }
                    if ($key == 'quantity')
                    {
                       // echo "$value";
                        $numparts = $value;
                    }
                    if ($key == 'price')
                    {
                       // echo "$value";
                        $weight = $value;                
                    }
                }        
                

                $sql = "INSERT INTO `HAS` (`ORDER_NUM`, `NUM`, `DESC`, `WEIGHT`, `QTY`) VALUES (:XORDER_NUM, :XNUM, :XDESC, :XWEIGHT, :XQTY)";

                $prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $success = $prepared->execute(array(':XORDER_NUM' => $ordernumber, ':XNUM' => $partnumber, ':XDESC' => $descrip, ':XWEIGHT' => $weight, ':XQTY' => $numparts));

                $rs = $pdo->query("SELECT qty FROM parts_main WHERE description = '$descrip'");
                while ($data = ($rs->fetch()))
                {
                    $subtractfrom = $data["qty"];
                }

                //echo " <br> subtractfrom before this:  " . $subtractfrom . " <br>";
                $subtractfrom = $subtractfrom - $numparts;
                //echo " <br> subtractfrom after:  " . $subtractfrom . " <br>";
                $stmt = $pdo->prepare("UPDATE parts_main SET qty = :XQTY WHERE description = :XDESC");
                $stmt->bindParam(':XQTY', $subtractfrom, PDO::PARAM_INT);
                $stmt->bindParam(':XDESC', $descrip, PDO::PARAM_STR);
                $stmt->execute();

            }
            unset($_SESSION['cart']);
            echo " <br> <br> would you like to create a new order?     ->";
            echo "<button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/parts.php'>";
            echo "create new order" . "</button>";
        }
        else
        {
            echo "There was an error processing your credit card information.  Please try again! <br>";
            echo "<button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/checkout.php'>";
            echo "back to checkout" . "</button>";           
        }
    } 
?>