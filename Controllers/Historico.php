<?php 


    class Historico extends Controllers
    {
        public function __construct() {

           parent::__construct();
           session_start();
           if (!isset($_SESSION['login'])) {
                header('Location: ' . base_url() . 'home');
                exit;
            }
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

        // Permite cargar el resumen del desplazamiento 
        public function cargar_resumen()
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

                try{
                    // Informacion del desplazamiento
                    $arrDataDesplazamiento = $this->model->consultar_resumen_desplazamiento($movil, $fechaInicial, $fechaFinal);

                    if( empty($arrDataDesplazamiento) ){
                        echo json_encode([
                            'status' => false,
                            'msg' => 'Faltan parámetros requeridos.',
                        ], JSON_UNESCAPED_UNICODE);
                        die();

                    }else{
                        $desplazamiento = 0;
                        // Obtener informacion 
                        foreach($arrDataDesplazamiento as $data){
                            $valores = explode(',', trim($data['star_consolidado_km3'], '()'));
                            $desplazamiento += $valores[4];
                        }
                    }

                    // Informacion del tiempo
                    $arrDataTiempo = $this->model->consultar_resumen_tiempo( $movil, $fechaInicial, $fechaFinal );
                    if( empty($arrDataTiempo )){
                        echo json_encode([
                            'status' => false,
                            'msg' => 'Faltan parámetros requeridos.',
                        ], JSON_UNESCAPED_UNICODE);
                        die();
                    }else{

                        // Obtener Informacion de tiempo
                        $tiempoRalenti = 0;
                        $tiempoOperacion = 0;

                        foreach( $arrDataTiempo as $data ){
                            // Convertir informacion sobre la horas de ralenti
                            $tiempoRalenti = $data['horas_ralenti'];
                            $segundos = $tiempoRalenti * 60; // Convertir minutos a segundos
                            $horas = floor($segundos / 3600); // Dividir entre 3600 para obtener las horas
                            $minutos = floor(($segundos % 3600) / 60); // El resto dividido entre 60 da los minutos restantes                        
                            $data['tiempo'] = sprintf('%02d:%02d', $horas, $minutos); // Formatear como horas:minutos (e.g., "11:00")
                            $tiempoRalenti = $data['tiempo'];

                            // Convertir informacion sobre la hora de operacion
                            $tiempoOperacion = $data['horas_operacion']; //Obtener valores
                            $segundosOperacion = $tiempoOperacion*60;
                            $horasOperacion = floor($segundosOperacion / 3600);
                            $minutosOperacion = floor(($segundosOperacion % 3600) / 60);
                            $data['tiempoOperacion'] = sprintf('%02d:%02d', $horasOperacion, $minutosOperacion);
                            $tiempoOperacion = $data['tiempoOperacion'];                       

                        }
                    }

                    // Informacion queda salida
                    $response = [
                        'status' => true,
                        'msg' => 'Datos obtenidos correctamente.',
                        'data' => [
                            'desplazamiento' => $desplazamiento,
                            'ralenti' => $tiempoRalenti,
                            'operacion' => $tiempoOperacion
                        ]
                    ];

                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }catch( Exception $e ){
                    // Manejo de errores en caso de excepción
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
            }
        }


    }
?>