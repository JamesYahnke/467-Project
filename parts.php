<!DOCTYPE html>
<html lang="en">
<head>
  <!-- required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="w3-right-align"><a href="cart.php">Cart</a></div></h5>
  </header>
<?php

    session_start();

    //---------------------run the "unset" command to reset the current cart (dont have to wait till session ends)
    //unset($_SESSION['cart']);


    //login stuff
    try { // if something goes wrong, an exception is thrown
      $dsn = "mysql:host=courses; dbname=z1922762";
      $pdo = new PDO($dsn, "z1922762", "2003May20");
  }
  catch(PDOexception $e) { // handle that exception
      echo "Connection to database failed: " . $e->getMessage();
  }

    try { // if something goes wrong, an exception is thrown
        $dsn2 = "mysql:host=blitz.cs.niu.edu; dbname=csci467";
        $pdo2 = new PDO($dsn2, 'student', 'student');
        }
        catch(PDOexception $e) { // handle that exception
        echo "Connection to database failed: " . $e->getMessage();
        }

 
        //if the cart is set, then everything is working and we are on the home page
        if (isset($_SESSION['cart']))
        {
        }
        //else, we need to make a new cart.
        else
        {
            $_SESSION['cart']=array(array("number","description", "quantity", "price", "weight", "pictureURL")); // Declaring session array
        }


        echo "<br> " . "Use this to add a product to your cart:";
        echo "<br> " . "<form action=partsub.php method=POST>";
        $rs = $pdo->query("SELECT DISTINCT description from parts_main");

        echo "product:    " . "<select name=product>";

        while($data = ($rs->fetch()))
        {
            echo "<option> ". $data["description"] . "</option>";
        }

        echo "</select>";

        echo   "<input type=submit name=submit value=submit />";

        echo "</form>";


        echo "<button onclick=window.location.href='https://students.cs.niu.edu/~z1922762/G1A/cart.php'>";
        echo "Click here to go to the current cart" . "</button>";


        //if the partsub page came back as positive
        if (isset($_POST["product"]))
        {
            $prd = $_POST["product"];
            $qnt = $_POST["quantity"];


            $max=sizeof($_SESSION['cart']);       
            $bigcheck = 0;
            $check = 0;
            for($i=1; $i<$max; $i++)
            {  
  
                while (list ($key) = each ($_SESSION['cart'][$i])) 
                { 
                    if ($check == 1)
                    {

                      $rs = $pdo->query("SELECT qty FROM parts_main WHERE description = '$prd' LIMIT 1");
                      while($data = ($rs->fetch()))
                      {
                        $bigquan = $data["qty"];
                      }

                      if ($_SESSION['cart'][$i][$key] + $qnt <= $bigquan)
                      {
                        $_SESSION['cart'][$i][$key] += $qnt;
                        $bigcheck = 1;
                        $check = 2;
                      }
                      elseif($_SESSION['cart'][$i][$key] + $qnt > $bigquan)
                      {
                        $_SESSION['cart'][$i][$key] = $bigquan;
                        $bigcheck = 1;
                        $check = 2;                        
                      }
                    }
        
                    if ( $_SESSION['cart'][$i][$key] == $prd)
                    {
                        $check = $check + 1;
                    }
        
                } // inner array while loop
        
            } // outer array for loop   
            if ($bigcheck == 0)
            {
                $rs = $pdo->query("SELECT * FROM parts_main WHERE description = '$prd'");
        
                while($data = ($rs->fetch()))
                {
                    $num = $data["number"];
                    $prc = $data["price"];
                    $wht = $data["weight"];
                }
                $rs = $pdo->query("SELECT qty FROM parts_main WHERE description = '$prd' LIMIT 1");
                while($data = ($rs->fetch()))
                {
                  $bigquan = $data["qty"];
                }
                if ($qnt > $bigquan)
                {
                  $qnt = $bigquan;
                }
                if ($qnt != 0)
                {
                  $b=array("number"=>"$num","description"=>"$prd","quantity"=>"$qnt","price"=>"$prc","weight"=>"$wht");
                  array_push($_SESSION['cart'],$b); // Items added to cart
                }
            }

        }


        //if the cart-page came back as positive
        if (isset($_POST["removeproduct"]))
        {
            $dsc = $_POST["removeproduct"];
            $qnt = $_POST["removeamount"];

            $max=sizeof($_SESSION['cart']);       
            $checker = 0;
            for($i=1; $i<$max; $i++)
            {    
                while (list ($key2) = each ($_SESSION['cart'][$i])) 
                { 
                    if ($checker == 1)
                    {
                        $_SESSION['cart'][$i][$key2] -= $qnt;
                        $checker = 999;
                    }             
                      
                    if ( $_SESSION['cart'][$i][$key2] == $dsc)
                    {
                        $checker += 1;
                    }
        
                } // inner array while loop
        
            } // outer array for loop   

            //checking to make sure no values are 0 or below
            for($n=1; $n<$max; $n++)
            {
                $keys = array_keys($_SESSION['cart']);
            }
            for($i = 0; $i < count($_SESSION['cart']); $i++) 
            {
                foreach($_SESSION['cart'][$keys[$i]] as $key => $value)
                {
                    if ($value <= '0')
                    {
                        unset($_SESSION['cart'][$i]);   
                        $_SESSION['cart'] = array_values($_SESSION['cart']);                      
                    }
                }
            }
        }
?>  
  <!-- Search Bar -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card mt-4">
          <div class="card-header">
            <h4>Search Parts for Sale </h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-7">

                <form action="" method="GET">
                  <div class="input-group mb-3">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Parts">
                    <button type="submit" class="btn btn-primary">Search</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Table Headers -->
      <div class="col-md-12">
        <div class="card mt-4">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Weight</th>
                  <th>Picture</th>
                </tr>
              </thead>
              <tbody>  <!-- Get Data -->
                <?php
                  $con = mysqli_connect("courses","z1922762","2003May20","z1922762");

                  if(isset($_GET['search']))
                  {
                    $filter = $_GET['search'];
                    $query = "SELECT * FROM parts_main WHERE CONCAT(number,description) LIKE '%$filter%' ";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                      foreach($query_run as $items)
                      {
                        ?>
                        <tr>
                          <td><?= $items['number']; ?></td>
                          <td><?= $items['description']; ?></td>
                          <td><?= $items['price']; ?></td>
                          <td><?= $items['weight']; ?></td>
<?php print '<td><img src="' .$items['pictureURL'] . '" alt="parts1" style="width:60%;max-width:320px"></td>'; ?>
                        </tr>
                        <?php
                      }
                    }
                    else
                    {
                      ?>
                        <tr>
                          <td colspan="5">No Parts Found</td>
                        </tr>
                      <?php
                    }
                  }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
