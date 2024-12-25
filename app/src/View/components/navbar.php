<?php use App\Enum\UserRole; ?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Event Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php if (isset($_SESSION['user']) && in_array(UserRole::ADMIN->name, $_SESSION['user']['roles'])): ?>
                        <a class="nav-link" aria-current="page" href="/add-event">Add Event</a>
                    <?php endif; ?>
                </li>
            </ul>
            <ul class="navbar-nav ">
                <?php if (isset($_SESSION['user']) === false): ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/register">Register</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="<?= $_SESSION['user']['avatar'] ?>" alt="Avatar" class="border rounded-circle"
                                 height="35" width="35">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/my-profile">My Profile</a></li>
                            <li><a class="dropdown-item" href="/tickets">Tickets</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
