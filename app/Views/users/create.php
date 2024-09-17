<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Crea Nuovo Utente<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Crea Nuovo Utente</h1>

    <?= form_open('/users/store') ?>
        <div class="form-group">
            <label for="username">Nome Utente</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="group">Gruppo</label>
            <select name="group" class="form-control">
                <option value="user">User</option>
                <option value="developer">Developer</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Crea</button>
    <?= form_close() ?>
<?= $this->endSection() ?>
