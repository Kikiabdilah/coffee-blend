<?php require "../includes/header.php" ?>
<?php require "../config/config.php" ?>
<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];


	//data for single product
	$product = $conn->query("SELECT * FROM products WHERE id='$id'");
	$product->execute();

	$singleproduct = $product->fetch(PDO::FETCH_OBJ);

	//data for related product
	$relatedproducts = $conn->query("SELECT * FROM products WHERE type='$singleproduct->type' AND id !='$singleproduct->id'");

	$relatedproducts->execute();

	$allrelatedproducts = $relatedproducts->fetchAll(PDO::FETCH_OBJ);


	//add to cart 
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$image = $_POST['image'];
		$price = $_POST['price'];
		$pro_id = $_POST['pro_id'];
		$description = $_POST['description'];
		$quantity = $_POST['quantity'];
		$user_id = $_SESSION['user_id'];

		$insert_cart = $conn->prepare("INSERT INTO cart (name, image, price, pro_id, description,quantity, user_id) VALUES (:name, :image, :price, :pro_id, :description, :quantity, :user_id)");

		$insert_cart->execute([
			":name" => $name,
			":image" => $image,
			":price" => $price,
			":pro_id" => $pro_id,
			":description" => $description,
			":quantity" => $quantity,
			":user_id" => $user_id,
		]);

		echo "<script>alert('added to cart successfully')</script>";
	}

	//validation for the cart
	if (isset($_SESSION['user_id'])) {
		$validatecart = $conn->query("SELECT * FROM cart WHERE pro_id='$id' AND user_id='$_SESSION[user_id]'");
		$validatecart->execute();

		$rowcount = $validatecart->rowCount();
	}

}
?>
<section class="home-slider owl-carousel">

	<div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);"
		data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">

				<div class="col-md-7 col-sm-12 text-center ftco-animate">
					<h1 class="mb-3 mt-5 bread">Product Detail</h1>
					<p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span></p>
				</div>

			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="images/menu-2.jpg" class="image-popup"><img
						src="<?php echo APPURL; ?>/images/<?php echo $singleproduct->image; ?>" class="img-fluid"
						alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?php echo $singleproduct->name; ?></h3>
				<p class="price"><span>$<?php echo $singleproduct->price; ?></span></p>
				<p><?php echo $singleproduct->description; ?></p>
				<form method="POST" action="product-single.php?id=<?php echo $id; ?>">

					<div class="row mt-4">
						<div class="col-md-6">
							<!-- <div class="form-group d-flex">
								<div class="select-wrap ">
									<div class="icon"><span class="ion-ios-arrow-down"></span></div>
									<select name="" id="" class="form-control">
										<option value="">Small</option>
										<option value="">Medium</option>
										<option value="">Large</option>
										<option value="">Extra Large</option>
									</select>
								</div>
							</div> -->
						</div>
						<div class="w-100"></div>
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
									<i class="icon-minus"></i>
								</button>
							</span>

							<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1"
								min="1" max="100">
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
									<i class="icon-plus"></i>
								</button>
							</span>
						</div>
					</div>
					<input name="name" value="<?php echo $singleproduct->name; ?>" type="hidden">
					<input name="image" value="<?php echo $singleproduct->image; ?>" type="hidden">
					<input name="price" value="<?php echo $singleproduct->price; ?>" type="hidden">
					<input name="pro_id" value="<?php echo $singleproduct->id; ?>" type="hidden">
					<input name="description" value="<?php echo $singleproduct->description; ?>" type="hidden">
					<?php if ($rowcount > 0): ?>
						<button name="submit" type="submit" class="btn btn-primary btn-outline-primary py-3 px-5"
							disabled>Added to
							Cart</button>
					<?php else: ?>
						<button name="submit" type="submit" class="btn btn-primary py-3 px-5">Add to
							Cart</button>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section ftco-animate text-center">
				<span class="subheading">Discover</span>
				<h2 class="mb-4">Related products</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
					the blind texts.</p>
			</div>
		</div>
		<div class="row">
			<?php foreach ($allrelatedproducts as $allrelatedproduct): ?>
				<div class="col-md-3">
					<div class="menu-entry">
						<a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $allrelatedproduct->id; ?>"
							class="img"
							style="background-image: url(<?php echo APPURL; ?>/images/<?php echo $allrelatedproduct->image; ?>);"></a>
						<div class="text text-center pt-4">
							<h3><a href="#"><?php echo $allrelatedproduct->name; ?></a></h3>
							<p><?php echo $allrelatedproduct->description; ?></p>
							<p class="price"><span>$<?php echo $allrelatedproduct->price; ?></span></p>
							<p><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $allrelatedproduct->id; ?>"
									class="btn btn-primary btn-outline-primary">Show</a></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php require "../includes/footer.php"; ?>