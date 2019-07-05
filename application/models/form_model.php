<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*/

class Form_model extends CI_Model
{
	/**
	 * empresa
	 *
	 * @var string
	 **/
	public $empresa;

	/**
	 * encuesta
	 *
	 * @var string
	 **/
	public $encuesta;

	/**
	 * agrupado_por
	 *
	 * @var string
	 **/
	public $agrupado_por;

	/**
	 * periodo
	 *
	 * @var string
	 **/
	public $periodo;

	public function __construct()
	{
		parent::__construct();
	}

}
