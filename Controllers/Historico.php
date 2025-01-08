<?php 


    class Historico extends Controllers
    {
        public function __construct() {

           parent::__construct();
        //    if (!isset($_SESSION['login'])) {
        //         header('Location: ' . base_url() . 'home');
        //         exit;
        //     }
        }

        public function historico()
		{
			$data['page_tag'] = "Historico | Starseguimiento";
			$data['page_title'] = "Página Principal";
			$data['page_name'] = "Historico | Starseguimiento";
			$data['data_functions_js'] = "function_historico.js";
			$data['app'] = "app.js";
			$data['styles'] = "historico.css";
			$this->views->getView($this,"historico",$data);
		}

        // Funcion que permite cargar las placas 
        public function ver_placas()
        {
            $htmlOptions = "";
            $arrData = $this->model->placas();
            if(count($arrData) > 0){
				$htmlOptions ='<option value="0" select>'."Seleccionar placa".'</option>';
				for($i = 0; $i < count($arrData); $i++){
					$htmlOptions .='<option value="'.$arrData[$i]['id_movil'].'">'.$arrData[$i]['placa'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
        }

        public function cargar_recorrido()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Validar datos recibidos
                $movil = isset($_POST['select-placa']) ? intval($_POST['select-placa']) : null;
                $fechaInicial = isset($_POST['fechaInicial']) ? $_POST['fechaInicial'] . ' 00:00:00' : null;
                $fechaFinal = isset($_POST['fechaFinal']) ? $_POST['fechaFinal'] . ' 23:59:59' : null;

                // Verificar que todos los datos requeridos están presentes
                if (is_null($movil) || is_null($fechaInicial) || is_null($fechaFinal)) {
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Faltan parámetros requeridos.',
                    ], JSON_UNESCAPED_UNICODE);
                    die();
                }

                try {
                    // Obtener los datos desde el modelo
                    $arrData = $this->model->generar_historico($movil, $fechaInicial, $fechaFinal);

                    if (empty($arrData)) {
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos para los parámetros especificados.'
                        ];
                    } else {
                        // Modificar el estado de ignición
                        foreach ($arrData as &$data) {
                            $data['ignicion'] = ($data['ignicion'] == 0) ? 'OFF' : 'ON';
                        }

                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => $arrData
                        ];
                    }

                    // Respuesta en formato JSON
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                } catch (Exception $e) {
                    // Manejo de errores en caso de excepción
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
            }

            die(); // Terminar la ejecución del script
        }


    }
?>