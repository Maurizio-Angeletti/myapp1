<?= $this->extend('layouts/layout-main') ?>

<?= $this->section('title') ?>Home<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('components/navbar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Home</h1>

    <?php if (session()->has("message")): ?> 
        <p><?= session("message") ?></p>
    <?php endif; ?>

    <?php if (session()->has(key: "error")): ?> 
        <p><?= session("errpr") ?></p>
    <?php endif; ?>
    
<?= $this->endSection() ?>
