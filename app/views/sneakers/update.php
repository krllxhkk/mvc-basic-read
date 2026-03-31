<?php require_once APPROOT . '/views/includes/header.php'; ?>

<?php //var_dump($_POST); ?>

<!-- Voor het centreren van de container gebruiken we het bootstrap grid -->
<div class="container">
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-6">
            <h3 class="text-success"><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <!-- Terugkoppeling naar de gebruiker -->
    <div class="row mt-3 d-<?= $data['display']; ?> justify-content-center">
        <div class="col-6">
            <div class="alert alert-<?= $data['color'] ?? 'success'; ?>" role="alert">
                <?= $data['message']; ?>
            </div>
        </div>
    </div>

    <!-- Update formulier -->
    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-6">
            <form action="<?= URLROOT; ?>/SneakerController/update" method="post">
                <div class="mb-3">
                    <label for="merk" class="form-label">Merk</label>
                    <input name="merk" type="text" class="form-control <?= isset($data['errors']['merk']) ? 'is-invalid' : ''; ?>" id="merk" value="<?= $_POST['merk'] ?? $data['sneaker']->Merk; ?>">
                    <?php if (isset($data['errors']['merk'])): ?>
                        <div class="invalid-feedback"><?= $data['errors']['merk']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input name="model" type="text" class="form-control <?= isset($data['errors']['model']) ? 'is-invalid' : ''; ?>" id="model" value="<?= $_POST['model'] ?? $data['sneaker']->Model; ?>">
                    <?php if (isset($data['errors']['model'])): ?>
                        <div class="invalid-feedback"><?= $data['errors']['model']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input name="type" type="text" class="form-control <?= isset($data['errors']['type']) ? 'is-invalid' : ''; ?>" id="type" value="<?= $_POST['type'] ?? $data['sneaker']->Type; ?>">
                    <?php if (isset($data['errors']['type'])): ?>
                        <div class="invalid-feedback"><?= $data['errors']['type']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="isactief" class="form-label">Actief</label>
                    <select name="isactief" class="form-control <?= isset($data['errors']['isactief']) ? 'is-invalid' : ''; ?>" id="isactief">
                        <option value="">Maak een keuze</option>
                        <option value="1" <?= (($_POST['isactief'] ?? $data['sneaker']->IsActief) == 1) ? 'selected' : ''; ?>>Ja</option>
                        <option value="0" <?= (($_POST['isactief'] ?? $data['sneaker']->IsActief) == 0) ? 'selected' : ''; ?>>Nee</option>
                    </select>
                    <?php if (isset($data['errors']['isactief'])): ?>
                        <div class="invalid-feedback"><?= $data['errors']['isactief']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="omschrijving" class="form-label">Omschrijving</label>
                    <input name="omschrijving" type="text" class="form-control <?= isset($data['errors']['omschrijving']) ? 'is-invalid' : ''; ?>" id="omschrijving" value="<?= $_POST['omschrijving'] ?? $data['sneaker']->Opmerking; ?>">
                    <?php if (isset($data['errors']['omschrijving'])): ?>
                        <div class="invalid-feedback"><?= $data['errors']['omschrijving']; ?></div>
                    <?php endif; ?>
                </div>

                <input type="hidden" name="id" value="<?= $_POST['id'] ?? $data['sneaker']->Id; ?>">
                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>

            <a href="<?= URLROOT; ?>/homepage/index"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
</div>
<!-- eind tabel -->

<?php require_once APPROOT . '/views/includes/footer.php'; ?>