<!DOCTYPE html>
<html lang="en">
<head>
  <!-- required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <title>Receiving</title>
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
  <h3>Select a Part Number and a Quantity to Add</h3>
  <form action="" method="POST">
    Part Num:<input type="text" name="pnum" placeholder="1">
    Quantity:<input type="text" name="quan" placeholder="5">
    <button type="submit">Update</button>
  </form>
  <?php
    $con = mysqli_connect("courses","z1922762","2003May20","z1922762");
    if(isset($_POST['pnum']) && isset($_POST['quan']))
    {
      $pnum = $_POST['pnum'];
      $quan = $_POST['quan'];
      $query = "UPDATE parts_main SET qty = qty + '$quan' WHERE number = '$pnum';";
      $query_run = mysqli_query($con,$query);
    }
  ?>
  <!-- Search Bar -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card mt-4">
          <div class="card-header">
            <h4>Filter Parts </h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-7">

                <form action="" method="GET">
                  <div class="input-group mb-3">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Parts">
                    <button type="submit" class="btn btn-primary">Filter</button>
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
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>  <!-- Get Data -->
                <?php

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
                          <td><?= $items['qty']; ?></td>
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
