<?php


$title = 'Home';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>
<section class="container">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/navbar.php' ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="p-3 text-warning-emphasis bg-warning border border-warning-subtle rounded-3">
            <?= $_SESSION['error'] ?>
        </div>
    <?php endif; ?>
    <?php if (empty($events)): ?>
        <p>No events available at the moment.</p>
    <?php else: ?>
        <div class="d-flex gap-3 mt-3">
            <?php foreach ($events as $event): ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?= 'http://localhost' . $event['thumbnail'] ?>" class="card-img-top"
                         alt="<?= $event['title'] ?>">
                    <div class="card-body">
                        <small class="card-text">
                            <?php
                            $date = new DateTime($event['expired_date']);
                            echo $date->format('F j, Y, g:i A');
                            ?>
                        </small>
                        <h5 class="card-title"><?= $event['title'] ?></h5>
                        <small class="card-text"><?= $event['location'] ?></small>
                        <br>
                        <a href="<?= '/event?id=' . $event['id'] ?>" class="btn btn-primary mt-3">More details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>


<?php
unset($_SESSION['error']);
require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php'; ?>

