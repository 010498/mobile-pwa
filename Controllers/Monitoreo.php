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
			$data['page_tag'] = "Monitoreo | STAR SEGUIMIENTO";
			$data['page_title'] = "Página Principal";
			$data['page_name'] = "Monitoreo | STAR SEGUIMIENTO";
			$data['data_functions_js'] = "function_monitoreo.js";
			$data['app'] = "app.js";
			$data['styles'] = "monitoreo.css";
			$this->views->getView($this,"Monitoreo",$data);
		}

		// Funcion que permite cargar la informacion de los vehiculos de acuerdo al usuario
		
		public function informacion()
		{
			try {
				// Cargar la información desde el modelo
				$arrData = $this->model->cargar_informacion($_SESSION['id']);
				
				// Validar si hay datos en el arreglo
				if (!empty($arrData)) {
					$data = [];
					foreach ($arrData as $item) {
						$response = $item['star_monitoreo'];
						// $response = explode(',', trim($response, '()'));
						$response = str_getcsv(trim($response, '()'));
						
						$data[] = [
							'id_movil' => $response[0],
							'placa' => trim($response[1], '"'),
							'fecha' => trim($response[2], '"'),
							'latitud' => (float)$response[3],
							'longitud' => (float)$response[4],
							'velocidad' => (int)$response[5],
							'dispositivo' => (int)$response[6],
							'posicion' => trim($response[7], '"'),
							'odometro' => (int)$response[8],
							'velmax' => (int)$response[9],
							'ignicion' => trim($response[10]) === 't' ? 'ON' : 'OFF'
						];
					}
					
					echo json_encode($data, JSON_UNESCAPED_UNICODE);
				} else {
					echo json_encode([], JSON_UNESCAPED_UNICODE);
				}
			} catch (Exception $e) {
				echo json_encode([
					'status' => false,
					'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
				], JSON_UNESCAPED_UNICODE);
			}
		}
	}

?>