<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
  exit();
}

//Admin
$products = $conn->query(("SELECT * FROM products"));
$products->execute();
$allproducts = $products->fetchall(PDO::FETCH_OBJ);

?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Foods</h5>
        <a href="create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Name</th>
              <th scope="col">Image</th>
              <th scope="col">Price</th>
              <th scope="col">Type</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 1;
            foreach ($allproducts as $products): ?>
              <tr>
                <th scope="row"><?php echo $counter++; ?></th>
                <td><?php echo $products->name; ?></td>
                <td><img src="images/<?php echo $products->image; ?>" style="width: 50px; height: 50px;">
                </td>
                </td>
                <td>$<?php echo $products->price; ?></td>
                <td><?php echo $products->type; ?></td>
                <td><a href="delete-products.php?id=<?php echo $products->id; ?>"
                    class="btn btn-danger text-center ">Delete</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<?php require "../layouts/footer.php"; ?>