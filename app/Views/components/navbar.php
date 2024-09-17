<?= $this->section('navbar') ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= route_to('home') ?>">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= route_to('home') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= route_to('annunci.index') ?>">Annunci</a>
                </li>
                <?php if (auth()->loggedIn()): ?>
                    <?php if (auth()->user()->inGroup("superadmin")): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= route_to('users.index') ?>">Users</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (auth()->loggedIn()): ?>
                    <li class="nav-item">
                        <span class="nav-link">Logged in as: <?= auth()->user()->username ?></span>
                    </li>


                    <?php foreach (auth()->user()->getGroups() as $groupName): ?>
                        <li class="nav-item">
                        <span class="nav-link">Role: <?= $groupName ?></span>
                    </li>
                    <?php endforeach; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/register') ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?= $this->endSection() ?>