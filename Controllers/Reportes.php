
<?php

// Permite acceder al controlador de REPORTES
    class Reportes extends Controllers
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

        public function reportes()
        {
            
            $data['page_tag'] = "Reportes | STAR SEGUIMIENTO";
            $data['page_title'] = "Reportes";
            $data['page_name'] = "reportes | STAR SEGUIMIENTO";
            $data['data_functions_js'] = "function_reportes.js";
            $data['app'] = "app.js";
			$data['styles'] = "reportes.css";
           
            $this->views->getView($this, "reportes", $data);
        }

        // Metodo para obtener las placas
        public  function ver_placas()
        {
           $htmlOptions = "";
           $arrData = $this->model->selectPlacas();
           if(count($arrData) > 0){
                $htmlOptions ='<option value="0" select>'."Seleccionar placa".'</option>';
                for($i = 0; $i < count($arrData); $i++){
                    $htmlOptions .='<option value="'.$arrData[$i]['id_movil'].'">'.$arrData[$i]['placa'].'</option>';
                }
            }
            echo $htmlOptions;
            die();

        }

        // Metodo que me permite obtener la informacion del resumen de velocidad
        public function resumen_excesos()
        {
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59";
                $velocidad = $_POST['exc-velocidad'];

                try{
                    // Obtener datos
                    $arrData = $this->model->resumen($movil, $fechaInicial, $fechaFinal, $velocidad);
                    
                   if(empty($arrData)){
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    }else{
                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => $arrData
                        ];
                    }

                    // Respuesta en formato JSON
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }catch(Exception $e){
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);

                }
            }
        }

        // Metodo que permite obtener informacion de la velocdad a consultar
        public function consultar_velocidad()
        {
            
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59"; 
                $velocidad = $_POST['exc-velocidad'];

                try {
                    // Obtener los datos desde el modelo
                    $arrData = $this->model->reporte_velocidad($movil, $fechaInicial, $fechaFinal, $velocidad);

                    if (empty($arrData)) {
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    } else {

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
        }

        // Metodo que permite obtener informacion sobre las horas de operacion
        public function consultar_horas_operacion()
        {
            
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59"; 

                try {
                    // Obtener los datos desde el modelo
                    $arrData = $this->model->horas_operacion($movil, $fechaInicial, $fechaFinal);
            
                    if (empty($arrData)) {
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    } else {

                         // Requiero realizar algunas operaciones teniendo en cuenta los datos obtenidos
                        
                        // 3) Promedio dejarlo en un valor entero
                        // 4) Maximo dejarlo en un valor entero
                        foreach ($arrData as &$data) {
                        // 1) Horometro debo convertirlo en Horas y Minutos
                            $segundos = $data['horometro'] * 60; // Convertir minutos a segundos
                            // Convertir los segundos a formato horas:minutos
                            $horas = floor($segundos / 3600); // Dividir entre 3600 para obtener las horas
                            $minutos = floor(($segundos % 3600) / 60); // El resto dividido entre 60 da los minutos restantes                        
                            // Formatear como horas:minutos (e.g., "11:00")
                            $data['tiempo'] = sprintf('%02d:%02d', $horas, $minutos);

                        // 2) Odometro debo convertirlo en Kilometros
                            $data['odometro'] = number_format($data['odometro'] / 1000, 1, '.', ''); // Convertir a kilometros y formatear a 2 decimales
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
        }

        // Metodo que permite obtener informacion del resumen de temperatura
        public function resumen_temperatura()
        {
            
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59";

                try{
                    // Obtener datos
                    $arrData = $this->model->resumenTem($movil, $fechaInicial, $fechaFinal);
                    
                    if(empty($arrData)){
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    }else{
                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => $arrData
                        ];
                    }

                    // Respuesta en formato JSON
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }catch(Exception $e){
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
                    
            }
        }

        // Metodo que permite obtener la informacion del historico de temperatura
        public function historico_temperatura()
        {
            if( $_POST ){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59";

                try{
                    // Obtener datos
                    $arrData = $this->model->reporteTem($movil, $fechaInicial, $fechaFinal);

                    if(empty($arrData)){
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    }else{
                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => $arrData
                        ];
                    }

                    // Respuesta en formato JSON
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }catch(Exception $e){
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
            }
        }


        // Metodo que permite obtener la informacion de los cargues de combustible
        public function consultar_cargue_combustible()
        {
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59";

                try{
                    // Solicitud de modelo 
                    $arrData = $this->model->consultar_combustible($movil, $fechaInicial, $fechaFinal);
                    if(empty($arrData)){
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    } else {
                        // Variables
                        $combustibleAnterior = null;
                        $combustibleCargaTotal = 0;
                        $fechaFinCarga = null;
                        $llenados = [];

                        // Validación de la información
                        foreach($arrData as $data){
                            // Obtener valores
                            $fecha = $data['fecha']; // Obtener valor de fecha
                            $combustible = floatval($data['doubcombustible']); // Obtener información del sensor 

                            if($combustibleAnterior !== null) {
                                // Validamos la diferencia de combustible anterior con el actual 
                                if(($combustible - $combustibleAnterior) > 2.5) {
                                    $combustibleCargaTotal += ($combustible - $combustibleAnterior);
                                    $fechaFinCarga = $fecha;
                                } elseif(($combustible - $combustibleAnterior) <= 0) {
                                    if($combustibleCargaTotal > 0) {
                                        $llenados[] = [
                                            'fechaInicio' => $fechaFinCarga,
                                            'fechaFin' => $fecha,
                                            'cantidad' => $combustibleCargaTotal
                                        ];
                                    }
                                    $combustibleCargaTotal = 0;
                                }
                            }
                            $combustibleAnterior = $combustible;
                        }

                        // Agregar el último llenado si existe
                        if($combustibleCargaTotal > 0) {
                            $llenados[] = [
                                'fechaInicio' => $fechaFinCarga,
                                'fechaFin' => end($arrData)['fecha'],
                                'cantidad' => $combustibleCargaTotal
                            ];
                        }

                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => $llenados
                        ];
                    }

                    // Respuesta en formato JSON
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                } catch(Exception $e){
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
            }
        }

        // Metodo que permite obtener la informacion de los consumos de combustible
        public function consultar_consumo_combustible()
        {
            if($_POST){
                $movil = $_POST['select-placa'];
                $fechaInicial = $_POST['fechaInicial']." 00:00:00";
                $fechaFinal = $_POST['fechaFinal']." 23:59:59";

                try{
                    // Hacer el llamado a los metodos que permitiran obtener la informacion para consumo
                    $arrDataConsumo = $this->model->consumo_combustible($movil, $fechaInicial, $fechaFinal);
                    $arrDataDesplazamiento = $this->model->desplazamiento_consumo($movil, $fechaInicial, $fechaFinal);

                    if( empty($arrDataConsumo) && empty($arrDataDesplazamiento) ){
                        $response = [
                            'status' => false,
                            'msg' => 'No se encontraron datos.'
                        ];
                    }else{
                        $resultadosFiltrados = [];
                        $totalAcumuladoPorDia = [];
                        // $filaAnterior = reset($arrDataConsumo);
                        $filaAnterior = $arrDataConsumo;

                        foreach ($arrDataConsumo as $data) {
                            $diferencia = ($data['doubcombustible'] - $filaAnterior['doubcombustible']);
                            $fechaActual = date('Y-m-d', strtotime($data['fecha']));

                            // Verificar si la diferencia es positiva y mayor a 4
                            if ($diferencia > 2.5) {
                                // Agregar la fila al array de resultados filtrados
                                $resultadosFiltrados[] = $data;
                                $totalAcumuladoPorDia[$fechaActual] += $diferencia;

                            }else if($diferencia < 0 ){
                                $resultadosFiltradosMenor[] = $data;
                            }


                            // Acumular la diferencia al total acumulado por día
                            if (!isset($totalAcumuladoPorDia[$fechaActual])) {
                                $totalAcumuladoPorDia[$fechaActual] = 0;
                            }

                            // Actualizar la fila y la fecha anterior con la fila y la fecha actual
                            $filaAnterior = $data;
                            $fechaAnterior = $fechaActual;

                            // if ($diferencia > 2.5) {
                            //     $resultadosFiltrados[] = $data;

                            //     if (!isset($totalAcumuladoPorDia[$fechaActual])) {
                            //         $totalAcumuladoPorDia[$fechaActual] = 0;
                            //     }
                            //     $totalAcumuladoPorDia[$fechaActual] += $diferencia;
                            // }

                            // $filaAnterior = $data;
                        }

                        $response = [
                            'status' => true,
                            'msg' => 'Datos obtenidos correctamente.',
                            'data' => [
                                'totalAcumuladoPorDia' => $totalAcumuladoPorDia,
                                'resultadosFiltrados' => $resultadosFiltrados,
                            ],
                        ];
                    }
                    echo json_encode($response, JSON_UNESCAPED_UNICODE);
                }catch( Exception $e ){
                    echo json_encode([
                        'status' => false,
                        'msg' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage(),
                    ], JSON_UNESCAPED_UNICODE);
                }
            }
        }

    }


?>