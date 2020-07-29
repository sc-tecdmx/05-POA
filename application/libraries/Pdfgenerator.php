<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdfgenerator {
    public function __construct(){
        $pdf = new DOMPDF();
        $CI = & get_instance();
        $CI->dompdf = $pdf;
    }
}
