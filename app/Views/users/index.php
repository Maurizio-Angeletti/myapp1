<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Elenco Utenti<?= $this->endSection() ?>


<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<h1>Elenco Utenti</h1>
<a href="<?= route_to('users.create') ?>" class="btn btn-primary">Crea Utente</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Utente</th>
            <th>Email</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user->id) ?></td>
                <td><?= esc($user->username) ?></td>
                <td><?= esc($user->email) ?></td>
                <td>
                    <a href="<?= route_to('users.edit', $user->id) ?>" class="btn btn-warning">Modifica</a>
                    <a href="<?= route_to('users.delete', $user->id) ?>" class="btn btn-danger"
                        onclick="return confirm('Sei sicuro di voler eliminare questo utente?')">Elimina</a>


                        
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>