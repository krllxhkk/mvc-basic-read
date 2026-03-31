<?php

class SneakerController extends BaseController
{
    private $sneakerModel;

    public function __construct()
    {
        $this->sneakerModel = $this->model('Sneaker');
    }

    public function index($display = 'none', $message = '')
    {
        $result = $this->sneakerModel->getAllSneakers();

        $data = [
            'title' => 'Mooiste Sneakers',
            'display' => $display,
            'message' => $message,
            'sneakers' => $result
        ];

        $this->view('sneakers/index', $data);
    }

    public function details($id)
    {
        $result = $this->sneakerModel->delete($id);
        
        header('Refresh:3; url=' . URLROOT . '/SneakerController/index');

        $this->index('flex', 'Record is verwijderd');
    }

    public function delete($id)
    {
        $result = $this->sneakerModel->delete($id);
        
        header('Refresh:3; url=' . URLROOT . '/SneakerController/index');

        $this->index('flex', 'Record is verwijderd');
    }

    public function create()
    {
        $data = [
            'title' => 'Nieuwe sneaker toevoegen',
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

            if (empty(trim($_POST['type']))) {
                $errors['type'] = 'Voer een type in';
            } elseif (strlen($_POST['type']) > 50) {
                $errors['type'] = 'Type mag maximaal 50 tekens bevatten';
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

                $this->sneakerModel->create($_POST);

                header('Refresh: 3; URL=' . URLROOT . '/SneakerController/index');
            }
        }

        $this->view('sneakers/create', $data);
    }

    public function update($id = NULL)
    {
        $data = [
            'title' => 'Wijzig sneaker',
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

            if (empty(trim($_POST['type']))) {
                $errors['type'] = 'Voer een type in';
            } elseif (!in_array($_POST['type'], ['Hardloop', 'Basketbal', 'Casual'])) {
                $errors['type'] = 'Kies Hardloop, Basketbal of Casual';
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
                $this->sneakerModel->updateSneaker($_POST);

                $data['display'] = 'flex';
                $data['message'] = 'Het record is succesvol opgeslagen';
                $data['color'] = 'success';

                header('Refresh:3; url=' . URLROOT . '/SneakerController/index');
            }
        }

        $data['sneaker'] = $this->sneakerModel->getSneakerById($id);
        $this->view('sneakers/update', $data);
    }
}