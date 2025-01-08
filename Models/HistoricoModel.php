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