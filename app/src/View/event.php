<?php
$title = 'Event';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>
<section class="container">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/navbar.php' ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="p-3 text-warning-emphasis bg-warning border border-warning-subtle rounded-3">
            <?= $_SESSION['error'] ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="p-3 text-success-emphasis bg-success border border-success-subtle rounded-3">
            <?= $_SESSION['success'] ?>
        </div>
    <?php endif; ?>
    <div class="row mt-5">
        <?php if (empty($event)): ?>
            <div class="p-3 text-warning-emphasis bg-warning border border-warning-subtle rounded-3">
                Event with ID: <?= $_GET['id'] ?> is not found!
            </div>
        <?php else: ?>
            <div class="col-6">
                <div class="w-75">
                    <img src="http://localhost<?= $event['thumbnail'] ?>" alt="<?= $event['title'] ?>"
                         class="img-fluid rounded">
                </div>
                <div>
                    <small>
                        <?php
                        $date = new DateTime($event['expired_date']);
                        echo $date->format('F j, Y, g:i A');
                        ?>
                    </small>
                    <h2><?= $event['title'] ?></h2>
                    <p><?= $event['description'] ?></p>
                </div>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="col-6">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Buy tickets</h5>
                            <h6>Price per ticket: $<?= $event['price'] ?></h6>
                            <form action="/ticket" method="post">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" name="amount" id="amount" min="1"
                                           value="1">
                                    <input type="hidden" value="<?= $_GET['id'] ?>" name="id">
                                </div>
                                <button class="btn btn-primary">Buy</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-6 h-25 p-3 text-warning-emphasis bg-warning border border-warning-subtle rounded-3">
                    You need to be logged in to buy a ticker!
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php
unset($_SESSION['error']);
unset($_SESSION['success']);
require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php';
?>
