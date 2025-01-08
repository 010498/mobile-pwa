<?php 
	
	/**
	 * Clase que se encarga del llenado de la informacion de la seccion de monitore donde se 
	 * visualizaran los vehiculos y las demas funciones 
	 */
	class Monitoreo extends Controllers
	{
		
		public function __construct()
		{
			parent::__construct();
			session_start();
			if (!isset($_SESSION['login'])) {
				header('Location: ' . base_url() . 'home');
				exit;
			}
		}

		// Funcion que carga la informacion base de monitoreo 
		public function monitoreo()
		{
			$data['page_tag'] = "Monitoreo | Starseguimiento";
			$data['page_title'] = "Página Principal";
			$data['page_name'] = "Monitoreo | Starseguimiento";
			$data['data_functions_js'] = "function_monitoreo.js";
			$data['app'] = "app.js";
			$data['styles'] = "monitoreo.css";
			$this->views->getView($this,"Monitoreo",$data);
		}

		// Funcion que permite cargar la informacion de los vehiculos de acuerdo al usuario
		public function informacion()
		{
			$arrData = $this->model->cargar_informacion($_SESSION['id']);
		
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			
		}
	}

 ?>