<?php
require 'vendor/autoload.php';

class CertificatePDF extends FPDF {
    // Certificate dimensions (Landscape A4)
    function __construct() {
        parent::__construct('L', 'mm', 'A4');
        $this->SetMargins(20, 20, 20);
    }

    // Add cosmic background, border, and logo
    function Header() {
        // Background gradient (deep blue to purple)
        $this->SetFillColor(0, 50, 100); // Deep blue
        $this->Rect(0, 0, $this->w, $this->h/2, 'F');
        $this->SetFillColor(50, 0, 100); // Purple
        $this->Rect(0, $this->h/2, $this->w, $this->h/2, 'F');

        // Galaxy swirl (simulated with curves)
        $this->SetDrawColor(255, 255, 255); // White
        $this->SetLineWidth(0.5);
        $this->Curve(30, 50, 80, 100, 150, 50, 220, 100);
        $this->Curve(40, 60, 90, 110, 160, 60, 230, 110);

        // Scattered stars
        $this->SetFillColor(255, 255, 255); // White
        $this->SetDrawColor(255, 215, 0); // Gold outline
        $this->drawStar(40, 40, 4, 'FD');
        $this->drawStar(80, 180, 3, 'FD');
        $this->drawStar(220, 60, 4, 'FD');
        $this->drawStar(150, 200, 3, 'FD');
        $this->drawStar(100, 50, 3, 'FD');
        $this->drawStar(200, 150, 4, 'FD');

        // Glowing border (double line in gold)
        $this->SetDrawColor(255, 215, 0); // Gold
        $this->SetLineWidth(0.5);
        $this->Rect(15, 15, $this->w-30, $this->h-30);
        $this->SetLineWidth(0.2);
        $this->Rect(17, 17, $this->w-34, $this->h-34);

        // Add rocket logo
        if (file_exists('assets/images/rocket_icon.png')) {
            $this->Image('assets/images/rocket_icon.png', $this->w/2-20, 20, 40); // Top-center rocket
        } else {
            // Fallback if logo is missing
            $this->SetFont('Helvetica', 'B', 12);
            $this->SetTextColor(255, 255, 255);
            $this->SetXY($this->w/2-20, 20);
            $this->Cell(40, 10, 'Rocket Logo', 0, 0, 'C');
        }
    }

    // Draw a simple curve for the galaxy swirl or comet trail
    function Curve($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4) {
        $this->_out(sprintf('%.2f %.2f m %.2f %.2f %.2f %.2f %.2f %.2f c',
            $x1 * $this->k, ($this->h - $y1) * $this->k,
            $x2 * $this->k, ($this->h - $y2) * $this->k,
            $x3 * $this->k, ($this->h - $y3) * $this->k,
            $x4 * $this->k, ($this->h - $y4) * $this->k));
        $this->_out('S');
    }

    // Draw a simple star
    function drawStar($x, $y, $r, $style = 'D') {
        $points = [];
        for ($i = 0; $i < 10; $i++) {
            $angle = deg2rad($i * 36);
            $radius = ($i % 2 == 0) ? $r : $r / 2;
            $points[] = $x + $radius * cos($angle);
            $points[] = $y + $radius * sin($angle);
        }
        $this->_out(sprintf('%.2f %.2f m', $points[0] * $this->k, ($this->h - $points[1]) * $this->k));
        for ($i = 2; $i < count($points); $i += 2) {
            $this->_out(sprintf('%.2f %.2f l', $points[$i] * $this->k, ($this->h - $points[$i + 1]) * $this->k));
        }
        $this->_out('h');
        if ($style == 'F' || $style == 'FD') {
            $this->_out('f');
        }
        if ($style == 'D' || $style == 'FD') {
            $this->_out('S');
        }
    }

    // Add title
    function addTitle($text) {
        // Simulated glow effect with a shadow
        $this->SetFont('Helvetica', 'B', 36);
        $this->SetTextColor(200, 200, 200); // Gray shadow
        $this->SetXY($this->w/2-80, 72);
        $this->Cell(160, 10, $text, 0, 1, 'C');
        $this->SetTextColor(255, 255, 255); // White
        $this->SetXY($this->w/2-80, 70);
        $this->Cell(160, 10, $text, 0, 1, 'C');
    }

    // Add main text
    function addText($text) {
        $this->SetFont('Times', '', 16);
        $this->SetTextColor(255, 255, 255); // White
        $this->SetX(20);
        $this->MultiCell(0, 8, $text, 0, 'C');
    }

    // Add motivational message
    function addMotivationalMessage($text) {
        $this->SetFont('Helvetica', 'B', 18);
        $this->SetTextColor(255, 255, 100); // Yellow
        $this->SetX(20);
        $this->MultiCell(0, 8, $text, 0, 'C');
    }

    // Add recipient name
    function addRecipient($name) {
        $this->SetFont('Times', 'B', 40);
        $this->SetTextColor(255, 215, 0); // Gold
        $this->SetY(100);
        $this->Cell(0, 15, $name, 0, 0, 'C');
        // Add comet trail beside the name
        $this->SetDrawColor(255, 255, 255); // White
        $this->SetLineWidth(0.5);
        $this->Curve(180, 110, 190, 115, 200, 105, 210, 110);
        // Add stars on either side
        $this->SetFillColor(255, 255, 255);
        $this->SetDrawColor(255, 215, 0);
        $this->drawStar(80, 105, 4, 'FD');
        $this->drawStar(220, 105, 4, 'FD');
    }

    // Add completion date
    function addDate($date) {
        $this->SetFont('Times', 'I', 14);
        $this->SetTextColor(200, 200, 200);
        $this->SetY(150);
        $this->Cell(0, 10, 'Launched on: ' . date('F j, Y', strtotime($date)), 0, 0, 'C');
        // Add a star beside the date
        $this->SetXY(180, 150);
        $this->drawStar(185, 155, 3, 'FD');
    }

    // Add simplified signature
    function addSignatures() {
        $this->SetFont('Times', '', 12);
        $this->SetTextColor(255, 255, 255);
        $this->SetY(170);
        $this->SetX(120);
        $this->Cell(80, 5, 'Star Guide: Nova Bright', 0, 0, 'C');
        $this->SetY(180);
        $this->SetX(120);
        $this->SetDrawColor(255, 215, 0); // Gold
        $this->Cell(80, 1, '', 'T');
    }

    // Add certificate ID
    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Courier', '', 10);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 10, 'Cosmic Code: ' . uniqid(), 0, 0, 'C');
    }
}

// Process form data
$recipient = $_POST['name'] ?? 'Cosmic Learner';
$course = $_POST['course'] ?? 'Beginner Galaxy Course';
$date = $_POST['date'] ?? date('Y-m-d');
$description = $_POST['description'] ?? '';

// Create PDF
$pdf = new CertificatePDF();
$pdf->AddPage();

// Add content
$pdf->addTitle('Cosmic Beginner Certificate');
$pdf->addText('This certifies that');
$pdf->addRecipient($recipient);
$pdf->addMotivationalMessage('You’ve Launched into Learning!');
$pdf->addText('has explored the');
$pdf->addText('"' . $course . '"');
if (!empty($description)) {
    $pdf->addText($description);
}
$pdf->addDate($date);
$pdf->addSignatures();

// Generate filename
$filename = 'cosmic_certificate_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($recipient)) . '.pdf';

// Output PDF
$pdf->Output('D', $filename);
exit;