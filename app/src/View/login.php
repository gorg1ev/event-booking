<?php
$title = 'Login';
require __DIR__ . DIRECTORY_SEPARATOR . 'components/head.php';
?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-black text-white">
                        <div class="card-body p-5 text-center">
                            <h2 class="fw-bold text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your email and password!</p>
                            <form action="/login" method="post" class="mt-5 text-black">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="" name="email"
                                           value="<?= $_SESSION['login_email'] ?? '' ?>">
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" placeholder=""
                                           name="password">
                                    <label for="password">Password</label>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5 mt-5 w-100" type="submit">Login
                                </button>

                                <p class="text-white-50 mt-5">Dont have an account? <a class="text-white"
                                                                                       href="/register">Register</a>
                                </p>
                            </form>

                            <?php if (isset($_SESSION['login_error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $_SESSION['login_error'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
unset($_SESSION['login_email']);
unset($_SESSION['login_error']);
require __DIR__ . DIRECTORY_SEPARATOR . 'components/footer.php';
?>