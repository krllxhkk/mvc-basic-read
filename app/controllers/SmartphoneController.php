<?php

class SmartphoneController extends BaseController
{
private $smartphoneModel;

    public function __construct()
    {
        $this->smartphoneModel = $this->model('Smartphone');
    }

    public function index($display = 'none', $message = '')
    {
        /**
         * Haal de resultaten van de model binnen
         */
        $result = $this->smartphoneModel->getAllSmartphones();

        //var_dump($result);

        /**
         * Het $data-array geeft informatie mee aan de view-pagina
         */
        $data = [
            'title'  => 'Overzicht Smartphones',
            'display' => $display,
            'message' => $message,
            'result' => $result
        ];

        /**
         * Met de view-method uit de BaseController-class wordt de view
         * aangeroepen
         */
        $this->view('smartphones/index', $data);
    }

    public function details($id)
    {
        $result = $this->SmartphoneModel->delete($id);
        
        header('Refresh: 3; url=' . URLROOT . '/SmartphoneController/index');

        $this->index('flex', 'Record is verwijderd');
    }
    public function delete($id)
    {
        $result = $this->smartphoneModel->delete($id);
        
        header('Refresh: 3; url=' . URLROOT . '/SmartphoneController/index');

        $this->index('flex', 'Record is verwijderd');
    }
    public function create()
    {
        $data = [
            'title' => 'Nieuwe smartphone toevoegen',
            'display' => 'none',
            'message' => '',
            'errors' => []
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

if (empty(trim($_POST['merk']))) {
    $errors['merk'] = 'Voer een merk in';
} elseif (strlen($_POST['merk']) > 20) {
    $errors['merk'] = 'Merk mag maximaal 20 tekens bevatten';
}

if (empty(trim($_POST['model']))) {
    $errors['model'] = 'Voer een model in';
} elseif (strlen($_POST['model']) > 20) {
    $errors['model'] = 'Model mag maximaal 20 tekens bevatten';
}

if (empty($_POST['prijs'])) {
    $errors['prijs'] = 'Voer een prijs in';
} elseif (!is_numeric($_POST['prijs']) || $_POST['prijs'] < 0 || $_POST['prijs'] > 9999.99) {
    $errors['prijs'] = 'Voer een geldige prijs in (0 - 9999,99)';
}

if (empty($_POST['geheugen'])) {
    $errors['geheugen'] = 'Voer een geheugen in';
} elseif (!is_numeric($_POST['geheugen']) || $_POST['geheugen'] < 0 || $_POST['geheugen'] > 4000) {
    $errors['geheugen'] = 'Voer een geldig geheugen in (0 - 4000 GB)';
}

if (empty(trim($_POST['besturingssysteem']))) {
    $errors['besturingssysteem'] = 'Voer een besturingssysteem in';
} elseif (strlen($_POST['besturingssysteem']) > 20) {
    $errors['besturingssysteem'] = 'Maximaal 20 tekens';
}

if (empty($_POST['schermgrootte'])) {
    $errors['schermgrootte'] = 'Voer een schermgrootte in';
} elseif (!is_numeric($_POST['schermgrootte']) || $_POST['schermgrootte'] < 0 || $_POST['schermgrootte'] > 10) {
    $errors['schermgrootte'] = 'Voer een geldige schermgrootte in (0 - 10 inch)';
}

if (empty($_POST['releasedatum'])) {
    $errors['releasedatum'] = 'Voer een releasedatum in';
} elseif (!DateTime::createFromFormat('Y-m-d', $_POST['releasedatum'])) {
    $errors['releasedatum'] = 'Voer een geldig datum in (jjjj-mm-dd)';
}

if (empty($_POST['megapixels'])) {
    $errors['megapixels'] = 'Voer het aantal megapixels in';
} elseif (!is_numeric($_POST['megapixels']) || $_POST['megapixels'] < 0 || $_POST['megapixels'] > 200) {
    $errors['megapixels'] = 'Voer een geldig aantal in (0 - 200)';
}

if (!empty($errors)) {
    $data['errors'] = $errors;
} else {
    $data['display'] = 'flex';
    $data['message'] = 'De gegevens zijn opgeslagen';
    $data['color'] = 'success';

        $this->smartphoneModel->create($_POST);

        header('Refresh: 3; URL=' . URLROOT . '/SmartphoneController/index');
    }
        }
    

        $this->view('smartphones/create', $data);
    }

public function update($id = NULL)
{
    $data = [
        'title' => 'Wijzig smartphone',
        'display' => 'none',
        'message' => '',
        'color' => 'success',
        'errors' => []
    ];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $errors = [];

        if (empty(trim($_POST['merk']))) {
            $errors['merk'] = 'Voer een merk in';
        } elseif (strlen($_POST['merk']) > 20) {
            $errors['merk'] = 'Merk mag maximaal 20 tekens bevatten';
        }

        if (empty(trim($_POST['model']))) {
            $errors['model'] = 'Voer een model in';
        } elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['model'])) {
    $errors['model'] = 'Model mag alleen letters en cijfers bevatten';
}
        if (empty($_POST['prijs'])) {
            $errors['prijs'] = 'Voer een prijs in';
        } elseif ($_POST['prijs'] == 0) {
    $errors['prijs'] = 'Prijs mag niet 0 zijn';
}

        if (empty($_POST['geheugen'])) {
            $errors['geheugen'] = 'Voer een geheugen in';
        } elseif ($_POST['geheugen'] % 2 != 0) {
    $errors['geheugen'] = 'Geheugen moet een even getal zijn';
}

        if (empty(trim($_POST['besturingssysteem']))) {
            $errors['besturingssysteem'] = 'Voer een besturingssysteem in';
        } elseif (!in_array(strtolower($_POST['besturingssysteem']), ['ios', 'android'])) {
    $errors['besturingssysteem'] = 'Alleen iOS of Android toegestaan';
}

        if (empty($_POST['schermgrootte'])) {
            $errors['schermgrootte'] = 'Voer een schermgrootte in';
        } elseif ($_POST['schermgrootte'] < 4) {
    $errors['schermgrootte'] = 'Schermgrootte moet minimaal 4 inch zijn';
}

        if (empty($_POST['releasedatum'])) {
            $errors['releasedatum'] = 'Voer een releasedatum in';
        } elseif ($_POST['releasedatum'] > date('Y-m-d')) {
    $errors['releasedatum'] = 'Releasedatum mag niet in de toekomst liggen';
}

        if (empty($_POST['megapixels'])) {
            $errors['megapixels'] = 'Voer het aantal megapixels in';
        } elseif (!is_numeric($_POST['megapixels']) || $_POST['megapixels'] < 0 || $_POST['megapixels'] > 200) {
            $errors['megapixels'] = 'Voer een geldig aantal in (0 - 200)';
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
            $data['display'] = 'flex';
            $data['message'] = 'Vul alle velden in';
            $data['color'] = 'danger';
        } else {
            $this->smartphoneModel->updateSmartphone($_POST);

            $data['display'] = 'flex';
            $data['message'] = 'Het record is succesvol opgeslagen';
            $data['color'] = 'success';

            header('Refresh:3; url=' . URLROOT . '/SmartphoneController/index');
        }
    }

    $data['smartphone'] = $this->smartphoneModel->getSmartphoneById($id);
    $this->view('smartphones/update', $data);
}
}
