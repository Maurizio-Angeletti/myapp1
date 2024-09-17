<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Crea Nuovo Annuncio<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<a href="<?= route_to('annunci.index') ?>">Torna alla lista degli annunci</a>

<h1>Crea Nuovo Annuncio</h1>

<?= form_open('/annunci/create') ?>
<div class="form-group">
    <label for="titolo">Titolo</label>
    <input type="text" name="titolo" class="form-control" required>
</div>
<div class="form-group">
    <label for="descrizione">Descrizione</label>
    <textarea name="descrizione" class="form-control" required></textarea>
</div>
<div class="form-group">
    <label for="prezzo">Prezzo</label>
    <input type="number" name="prezzo" class="form-control" required>
</div>
<button type="submit" class="btn btn-primary mt-3">Crea</button>
<?= form_close() ?>
<?= $this->endSection() ?>