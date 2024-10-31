<?php
require __DIR__ . '/../../vendor/fpdf/fpdf/original/fpdf.php'; 
$pdo = require __DIR__ . '/../../config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /../View/auth/login.php');
    exit();
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("ID de CV manquant.");
}

$cv_id = $_POST['id'];
$query = "SELECT * FROM cvs WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $cv_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$cv = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cv) {
    die("CV non trouvé.");
}


$career = json_decode($cv['career'], true);
$education = json_decode($cv['education'], true);
$skills = json_decode($cv['skills'], true);

$bg_color = isset($_POST['bg_color']) ? $_POST['bg_color'] : '#ffffff';
$text_color = isset($_POST['text_color']) ? $_POST['text_color'] : '#000000';

class PDF extends FPDF
{
    private $bg_color;
    private $text_color;
    private $title;

    function __construct($bg_color, $text_color, $title)
    {
        parent::__construct();
        $this->bg_color = $bg_color;
        $this->text_color = $text_color;
        $this->title = $title;
    }

    function Header()
    {
        list($r, $g, $b) = sscanf($this->bg_color, "#%02x%02x%02x");
        $this->SetFillColor($r, $g, $b);
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255); 
        $this->Cell(0, 10, utf8_decode($this->title), 0, 1, 'C', true);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function SetTextColorFromHex($hex)
    {
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $this->SetTextColor($r, $g, $b);
    }
}

$pdf = new PDF($bg_color, $text_color, $cv['title']);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColorFromHex($text_color); 

$pdf->Cell(0, 10, utf8_decode('Titre: ' . $cv['title']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Nom: ' . $cv['first_name'] . ' ' . $cv['last_name']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Date de naissance: ' . $cv['birth_date']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Téléphone: ' . $cv['phone']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Email: ' . $cv['email']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Passions: ' . $cv['passions']), 0, 1);

$pdf->Cell(0, 10, utf8_decode('Carrière:'), 0, 1);
foreach ($career as $item) {
    $pdf->Cell(0, 10, utf8_decode($item), 0, 1);
}

$pdf->Cell(0, 10, utf8_decode('Éducation:'), 0, 1);
foreach ($education as $item) {
    $pdf->Cell(0, 10, utf8_decode($item), 0, 1);
}

$pdf->Cell(0, 10, utf8_decode('Compétences:'), 0, 1);
foreach ($skills as $item) {
    $pdf->Cell(0, 10, utf8_decode($item), 0, 1);
}

$pdf->Output('D', 'cv.pdf');
?>