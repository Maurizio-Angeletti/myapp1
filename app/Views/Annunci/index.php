<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Elenco Annunci<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Elenco Annunci</h1>
    <a href="<?= route_to('annunci.new') ?>" class="btn btn-primary">Crea Annuncio</a>

    <ul>
        <?php foreach ($annunci as $annuncio): ?>
            <li>
                <h3><?= esc($annuncio->titolo) ?></h3>
                <p><?= esc($annuncio->descrizione) ?></p>
                <p>Prezzo: <?= esc($annuncio->prezzo) ?> €</p>
            </li>
        <?php endforeach; ?>
    </ul>
<?= $this->endSection() ?>
