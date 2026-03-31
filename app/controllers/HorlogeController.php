<?php

class HorlogeController extends BaseController
{
    private $horlogeModel;

    public function __construct()
    {
        $this->horlogeModel = $this->model('Horloge');
    }

    public function index($display = 'none', $message = '')
    {
        $result = $this->horlogeModel->getAllHorloges();

        $data = [
            'title'  => 'Overzicht Horloges',
            'display' => $display,
            'message' => $message,
            'result' => $result
        ];

        $this->view('horloges/index', $data);
    }

    public function details($id)
    {
        $result = $this->horlogeModel->delete($id);
        
        header('Refresh: 3; url=' . URLROOT . '/HorlogeController/index');

        $this->index('flex', 'Record is verwijderd');
    }

    public function delete($id)
    {
        $result = $this->horlogeModel->delete($id);
        
        header('Refresh: 3; url=' . URLROOT . '/HorlogeController/index');

        $this->index('flex', 'Record is verwijderd');
    }

    public function create()
    {
        $data = [
            'title' => 'Nieuw horloge toevoegen',
            'display' => 'none',
            'message' => '',
            'errors' => []
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];

            if (empty(trim($_POST['merk']))) {
                $errors['merk'] = 'Voer een merk in';
            } elseif (strlen($_POST['merk']) > 50) {
                $errors['merk'] = 'Merk mag maximaal 50 tekens bevatten';
            }

            if (empty(trim($_POST['model']))) {
                $errors['model'] = 'Voer een model in';
            } elseif (strlen($_POST['model']) > 50) {
                $errors['model'] = 'Model mag maximaal 50 tekens bevatten';
            }

            if (empty($_POST['prijs'])) {
                $errors['prijs'] = 'Voer een prijs in';
            } elseif (!is_numeric($_POST['prijs']) || $_POST['prijs'] < 0 || $_POST['prijs'] > 999999) {
                $errors['prijs'] = 'Voer een geldige prijs in';
            }

            if (!isset($_POST['isactief']) || $_POST['isactief'] === '') {
                $errors['isactief'] = 'Maak een keuze';
            }

            if (empty(trim($_POST['omschrijving']))) {
                $errors['omschrijving'] = 'Voer een omschrijving in';
            } elseif (strlen($_POST['omschrijving']) > 255) {
                $errors['omschrijving'] = 'Omschrijving mag maximaal 255 tekens bevatten';
            }

            if (!empty($errors)) {
                $data['errors'] = $errors;
            } else {
                $data['display'] = 'flex';
                $data['message'] = 'De gegevens zijn opgeslagen';
                $data['color'] = 'success';

                $this->horlogeModel->create($_POST);

                header('Refresh: 3; URL=' . URLROOT . '/HorlogeController/index');
            }
        }

        $this->view('horloges/create', $data);
    }

    public function update($id = NULL)
    {
        $data = [
            'title' => 'Wijzig horloge',
            'display' => 'none',
            'message' => '',
            'color' => 'success',
            'errors' => []
        ];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $errors = [];

            if (empty(trim($_POST['merk']))) {
                $errors['merk'] = 'Voer een merk in';
            } elseif (strlen($_POST['merk']) > 50) {
                $errors['merk'] = 'Merk mag maximaal 50 tekens bevatten';
            } elseif (!preg_match('/^[a-zA-Z\s\-]+$/', $_POST['merk'])) {
                $errors['merk'] = 'Merk mag alleen letters bevatten';
            }

            if (empty(trim($_POST['model']))) {
                $errors['model'] = 'Voer een model in';
            } elseif (!preg_match('/^[a-zA-Z0-9\s\-]+$/', $_POST['model'])) {
                $errors['model'] = 'Model mag alleen letters en cijfers bevatten';
            }

            if (empty($_POST['prijs'])) {
                $errors['prijs'] = 'Voer een prijs in';
            } elseif ($_POST['prijs'] == 0) {
                $errors['prijs'] = 'Prijs mag niet 0 zijn';
            }

            if (!isset($_POST['isactief']) || $_POST['isactief'] === '') {
                $errors['isactief'] = 'Maak een keuze';
            }

            if (empty(trim($_POST['omschrijving']))) {
                $errors['omschrijving'] = 'Voer een omschrijving in';
            } elseif (strlen($_POST['omschrijving']) > 255) {
                $errors['omschrijving'] = 'Omschrijving mag maximaal 255 tekens bevatten';
            }

            if (!empty($errors)) {
                $data['errors'] = $errors;
                $data['display'] = 'flex';
                $data['message'] = 'Vul alle velden in';
                $data['color'] = 'danger';
            } else {
                $this->horlogeModel->updateHorloge($_POST);

                $data['display'] = 'flex';
                $data['message'] = 'Het record is succesvol opgeslagen';
                $data['color'] = 'success';

                header('Refresh:3; url=' . URLROOT . '/HorlogeController/index');
            }
        }

        $data['horloge'] = $this->horlogeModel->getHorlogeById($id);
        $this->view('horloges/update', $data);
    }
}