<?php

    class HistoricoModel extends Pgsql
    {
        public $movil;
        public $fechaInicial;
        public $fechaFinal;

        public function __construct() {

           parent::__construct();
           session_start();

        }

        // Funcion que permite cargar placas
        public function placas()
        {
            $query = "SELECT id_movil, placa FROM public.moviles WHERE  id_cliente = ".$_SESSION[id]." AND estado != 0 ORDER BY placa ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Permite cargar la informacion del desplazamiento
        public function consultar_resumen_desplazamiento(int $movil, string $fechaInicial, $fechaFinal)
        {
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;
            
            $query = "SELECT star_consolidado_km3($this->movil, '".$this->fechaInicial."', '".$this->fechaFinal."')";
            
            $response = $this->select_all($query);
            return $response;
        }

        // Permite consultar la informacion de las horas de operacion
        public function consultar_resumen_tiempo(int $movil, string $fechaInicial, $fechaFinal)
        {
            // Consulta que permite obtener la informacion de las horas de operacion 
            $movil = $this->movil;
            $fechaInicial = $this->fechaInicial;
            $fechaFinal = $this->fechaFinal;

            $query = "SELECT MAX(CASE WHEN ignicion = 1 AND velocidad = 0 THEN horometro END) - MIN(CASE WHEN ignicion = 1 AND velocidad = 0 THEN horometro END) AS horas_ralenti,
                             MAX(CASE WHEN ignicion = 1 AND velocidad > 1 THEN horometro END) - MIN(CASE WHEN ignicion = 1 AND velocidad > 1 THEN horometro END) AS horas_operacion 
                      FROM public.posiciones 
                      WHERE id_movil = $this->movil
                      AND fecha_gps BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."'  ";
           
            $response = $this->select_all($query);
            return $response;
        }

        // Funcion que permite generar el recorrido del vehiculo 
        public function generar_historico(int $movil, string $fechaInicial, string $fechaFinal)
        {
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            $query = "SELECT id_posicion, fecha_gps, posicion, latitud, longitud, velocidad, ignicion, direccion, e.evento
                        FROM public.posiciones p
                        INNER JOIN eventos e ON id_evento = p.evento
                        WHERE id_movil = {$this->movil}
                        AND fecha_gps BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' 
                        AND latitud <> '0.0'
                        ORDER BY fecha_gps ASC";
            //echo $query;
            $response = $this->select_all($query);
            return $response;
        }


    }
?>