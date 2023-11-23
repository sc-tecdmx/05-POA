<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdfgenerator {
    public function __construct(){
        $pdf = new DOMPDF();
        $CI = & get_instance();
        $CI->dompdf = $pdf;
    }
}
