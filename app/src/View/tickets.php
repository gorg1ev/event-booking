<?php

$title = 'Tickets';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>
<section class="container">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/navbar.php' ?>

    <?php if ($tickets): ?>
        <table class="table">
            <thead>
            <tr>

                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Amount</th>
                <th scope="col">Total</th>
                <th scope="col">Date when ticket is bought</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td>
                        <a href="/event?id=<?= $ticket['event_id'] ?>">
                            <?= $ticket['title'] ?>
                        </a>
                    </td>
                    <td>$<?= $ticket['price'] ?></td>
                    <td><?= $ticket['amount'] ?></td>
                    <td>$<?= $ticket['price'] * $ticket['amount'] ?></td>
                    <td>
                        <?php
                        $date = new DateTime($ticket['date_bought']);
                        echo $date->format('F j, Y, g:i A');
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h5>There are no tickets yet!</h5>
    <?php endif; ?>


</section>


<?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php'; ?>

