<?php
$title = 'Profile';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>
<section class="container">
    <?php require __DIR__ . DIRECTORY_SEPARATOR . 'components/navbar.php' ?>

    <form action="/my-profile" method="post" class="mt-5 text-black" style="width: 400px" enctype="multipart/form-data">
        <div class="form-floating mb-3 d-flex">
            <div>
                <img src="http://localhost<?= $_SESSION['user']['avatar'] ?>" alt="Avatar"
                     class="border rounded-circle me-3" height="100" width="100">
            </div>
            <input type="file" class="form-control border-0" name="avatar">
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="fullName" placeholder=""
                   name="fullName" value="<?= $_SESSION['user']['full_name'] ?>">
            <label for="fullName">Full Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" placeholder=""
                   value="<?= $_SESSION['user']['email'] ?>" disabled>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" placeholder=""
                   name="password">
            <label for="password">New Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="confirm" placeholder=""
                   name="confirmPassword">
            <label for="confirm">Confirm New Password</label>
        </div>
        <?php if (isset($_SESSION['update_profile_error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['update_profile_error'] ?>
            </div>
        <?php endif; ?>
        <button class="btn btn-outline-dark btn-lg px-5 mt-5 w-100" type="submit">Change</button>
    </form>
</section>


<?php
unset($_SESSION['update_profile_error']);
require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php';
?>

