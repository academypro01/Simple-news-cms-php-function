<?php
$quote = randomQuote();
?>
<div>
    <h1>Welcome to Dashboard <?php echo $_SESSION['username']; ?></h1>
    <hr>
    <p>Today is: <?php echo date("Y/m/d H:i:s"); ?></p>
    <hr>

    <figure>
    <blockquote class="blockquote">
        <p><?php echo $quote['content']; ?></p>
    </blockquote>
    <figcaption class="blockquote-footer">
        <cite title="Source Title"><?php echo $quote['author']; ?></cite>
    </figcaption>
    </figure>
</div>