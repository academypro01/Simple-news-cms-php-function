<?php
pageGuard();
$messages = getAllContactsMessage();
sessionStatus();
while($row = mysqli_fetch_assoc($messages)):
?>
<div class="card col-12 col-sm-12 col-md-12 p-2">
  <div class="card-header bg-info">
    <?php echo $row['email']; ?>
  </div>
  <p><?php echo $row['message']; ?></p>
  <div class="card-footer row justify-content-between">
      <p><?php echo $row['date']; ?></p>
      <div>
          <a href="index.php?page=delete_messages&message_id=<?php echo $row['id']; ?>">
          <button class='btn btn-danger'>Delete</button>
            </a>
      </div>
  </div>
</div>
<?php
endwhile;
?>