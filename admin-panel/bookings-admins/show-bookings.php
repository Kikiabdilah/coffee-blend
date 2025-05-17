<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php

if (!isset($_SESSION['admin_name'])) {
  header("location: " . ADMINURL . "/admins/login-admins.php");
  exit();
}

//Admin
$bookings = $conn->query(("SELECT * FROM bookings"));
$bookings->execute();
$allbookings = $bookings->fetchall(PDO::FETCH_OBJ);

?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4 d-inline">Bookings</h5>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Firs Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Date</th>
              <th scope="col">Time</th>
              <th scope="col">Phone</th>
              <th scope="col">Message</th>
              <th scope="col">Status</th>
              <th scope="col">Change Status</th>
              <th scope="col">Created At</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $counter = 1;
            foreach ($allbookings as $bookings): ?>
              <tr>
                <th scope="row"><?php echo $counter++; ?></th>
                <td><?php echo $bookings->first_name; ?></td>
                <td><?php echo $bookings->last_name; ?></td>
                <td><?php echo $bookings->date; ?></td>
                <td><?php echo $bookings->time; ?></td>
                <td><?php echo $bookings->phone; ?></td>
                <td><?php echo $bookings->message; ?></td>
                <td><?php echo $bookings->status; ?></td>
                <td><a href="change-status.php?id=<?php echo $bookings->id; ?>"
                    class="btn btn-warning text-center ">Change Status</a></td>
                <td><?php echo $bookings->created_at; ?></td>
                <td><a href="delete-bookings.php?id=<?php echo $bookings->id; ?>"
                    class="btn btn-danger  text-center ">Delete</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php require "../layouts/footer.php"; ?>