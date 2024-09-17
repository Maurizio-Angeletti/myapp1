<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Modifica Utente<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1>Modifica Utente</h1>

<?= form_open(route_to('users.update', $user->id)) ?>

<div class="form-group">
    <label for="username">Nome Utente</label>
    <input type="text" name="username" class="form-control" value="<?= esc($user->username) ?>" required>
</div>

<div class="form-group mt-3">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="<?= esc($user->email) ?>" required>
</div>



<div class="form-group mt-3">

    <select name="group" class="form-control">
        <option value="user" <?= $user->getGroups()['0'] === 'user' ? 'selected' : '' ?>>User</option>
        <option value="developer" <?= $user->getGroups()['0'] === 'developer' ? 'selected' : '' ?>>Developer</option>
        <option value="admin" <?= $user->getGroups()['0'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="superadmin" <?= $user->getGroups()['0'] === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
    </select>
</div>

<div class="form-group mt-3">

<div>
        <p>Gruppi</p>
    </div>
    
    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
    <?php foreach ($groups as $groupName => $groupDetails): ?>
            <?php 
            $isChecked = $user->inGroup($groupName) ? 'checked' : '';
            $isDisabled = ($user->id == auth()->user()->id) ? 'disabled' : ''; // Disabilita se l'utente corrente sta modificando sé stesso
            ?>
            
            <input type="checkbox" name="groups[]" value="<?= esc($groupName) ?>" 
                   class="btn-check" id="btncheck-<?= esc($groupName) ?>" autocomplete="off" <?= $isChecked ?> <?= $isDisabled ?>>
            <label class="btn btn-outline-primary" for="btncheck-<?= esc($groupName) ?>">
                <?= esc($groupDetails['title']) ?>
            </label>
        <?php endforeach; ?>
    </div>
</div>

<button type="submit" class="btn btn-primary mt-3">Salva</button>
<?= form_close() ?>
<?= $this->endSection() ?>