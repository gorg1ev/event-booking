<?php

$title = 'Event Form';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>

<section class="container">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/navbar.php' ?>

    <form action="/create-event" class="w-25" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="5" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price per Ticket</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Pick a date</label>
            <input type="datetime-local" class="form-control" name="date" id="date">
        </div>
        <div>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
            <?php endif; ?>
            <button class="btn btn-primary">Create</button>
        </div>
    </form>
</section>

<?php
unset($_SESSION['error']);
require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php';
?>
