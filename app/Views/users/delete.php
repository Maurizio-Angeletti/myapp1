<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Elimina Utente<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Elimina Utente</h1>
    <p>Sei sicuro di voler eliminare l'utente <strong><?= esc($user->username) ?></strong>?</p>

    <?= form_open(route_to('users.delete', $user->id)) ?>
        <button type="submit" class="btn btn-danger">Sì, elimina</button>
        <a href="/users" class="btn btn-secondary">Annulla</a>
    <?= form_close() ?>
<?= $this->endSection() ?>
