<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Gruppi<?= $this->endSection() ?>


<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<h1>Gruppi User</h1>

<?= form_open(route_to('users.groups', $user->id)) ?>

<div class="form-group">
    <label for="username">User</label>
    <input type="checkbox" name="groups[]" class="form-control" value="user" <?= $user->inGroup("user") ? "checked" : "" ?>>
</div>

<div class="form-group mt-3">
    <label for="username">Admin</label>
    <input type="checkbox" name="groups[]" class="form-control" value="admin" <?= $user->inGroup("admin") ? "checked" : "" ?>>
</div>




<div class="form-group mt-3">
    <label for="group">Gruppo</label>
    <select name="group" class="form-control">
        <option value="user" <?= $user->getGroups()['0'] === 'user' ? 'selected' : '' ?>>User</option>
        <option value="developer" <?= $user->getGroups()['0'] === 'developer' ? 'selected' : '' ?>>Developer</option>
        <option value="admin" <?= $user->getGroups()['0'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="superadmin" <?= $user->getGroups()['0'] === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
    </select>
</div>

<button type="submit" class="btn btn-primary mt-3">Salva</button>
<?= form_close() ?>
<?= $this->endSection() ?>