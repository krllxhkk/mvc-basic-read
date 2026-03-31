<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-10">
            <h3><?php echo $data['title']; ?></h3>
        </div>
    </div>

    <div class="row mt-3 d-<?= $data['display']; ?> justify-content-center">
        <div class="col-10 text-begin text-primary">
            <div class="alert alert-success" role="alert">
                <?= $data['message']; ?>
            </div>
        </div>
    </div>

    <div class="row mt-3 d-flex justify-content-center">
        <div class="col-10 text-begin text-danger">
            <a href="<?= URLROOT; ?>/HorlogeController/create"
               class="btn btn-warning"
               role="button">Nieuw horloge
            </a>
        </div>
    </div>

    <div class="row mb-3 justify-content-center">
        <div class="col-10">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Prijs (€)</th>
                        <th>IsActief</th>
                        <th>Omschrijving</th>
                        <th>DatumAangemaakt</th>
                        <th>Verwijder</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($data["result"] as $horloge): ?>
                    <tr>
                        <td><?= $horloge->Merk; ?></td>
                        <td><?= $horloge->Model; ?></td>
                        <td><?= $horloge->Prijs; ?></td>
                        <td><?= $horloge->IsActief ? 'Ja' : 'Nee'; ?></td>
                        <td><?= $horloge->Omschrijving; ?></td>
                        <td><?= $horloge->DatumAangemaakt; ?></td>
                        <td class="text-center">
                        <a href="<?= URLROOT; ?>/HorlogeController/update/<?= $horloge->Id; ?>">
                            <i class="bi bi-pencil-square text-primary"></i>
                        </a>
                    </td>
                        <td class="text-center">
                            <a href="<?= URLROOT; ?>/HorlogeController/delete/<?= $horloge->Id; ?>"
                                onclick="return confirm('Weet je zeker dat je dit record wilt verwijderen?');">
                                <i class="bi bi-trash-fill text-danger"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <a href="<?= URLROOT; ?>/homepage/index" class="btn btn-primary">Terug</a>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>