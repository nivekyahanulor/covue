<?php

// include the TCPDF class
require_once(dirname(__FILE__).'/tcpdf.php');

class TCPDF_TERMS extends TCPDF {

    public function Header()
    {
        $image_file = 'assets/img/covue_logo_black.png';
        $this->Image($image_file, 10, 10, 70, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, '3rd Floor, Pro Palace 1-6-19 Azuchimachi Chuo-ku, Osaka, 541-0052 Japan', 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->SetY(-15);
        $this->Cell(0, 10, 'iorjapan@covue.com | +81 050-8881-2699', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}