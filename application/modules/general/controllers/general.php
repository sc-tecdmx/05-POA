<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class general extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$models = array();
		$this->load->model($models);
	}


}
