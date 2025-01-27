<?php
    class ReportesModel extends Pgsql
    {
        public $movil;
        public $fechaInicial;
        public $fechaFinal;
        public $velocidad;

        public function __construct()
        {
            parent::__construct();
            session_start();
        }

        // Metodo para obtener las placas
        public function selectPlacas()
        {
            $query = "SELECT id_movil, placa FROM public.moviles WHERE  id_cliente = ".$_SESSION[id]." AND estado != 0 ORDER BY placa ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que me permite obtener la informacion del resumen de velocidad
        public function resumen(int $movil, string $fechaInicial, string $fechaFinal, int $velocidad)
        {
            // Declaracion y asignacion de variables
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;
            $this->velocidad = $velocidad;

            $query = "SELECT a.Placa,coalesce(b.Excesos,0)Excesos,coalesce(f.distancia,0)Distancia,coalesce(h.Velocidad,0)Velocidad,coalesce(l.Promedio,0)Promedio,a.id_movil FROM moviles a 
					left join (SELECT id_movil,count(id_movil) AS Excesos FROM posiciones WHERE fecha_gps between '".$this->fechaInicial."' AND '".$this->fechaFinal."' AND (evento in (4,32) OR velocidad >= ".$this->velocidad." ) group by id_movil)b ON a.id_movil=b.id_movil 
					left join (SELECT id_movil, (MAX(odometro)- MIN(odometro))/1000 AS distancia FROM posiciones WHERE fecha_gps between '".$this->fechaInicial."' AND '".$this->fechaFinal."' group by id_movil )f ON a.id_movil=f.id_movil 
					left join (SELECT id_movil, max(velocidad) AS Velocidad FROM posiciones WHERE fecha_gps BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' group by id_movil)h ON a.id_movil = h.id_movil
					left join (SELECT id_movil, avg(velocidad) AS Promedio FROM posiciones WHERE fecha_gps BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' AND velocidad > 3 group by id_movil)l ON a.id_movil = l.id_movil
					WHERE a.id_movil = ".$this->movil." ORDER BY a.Placa ASC ";
        
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite obtener informacion de la velocdad a consultar
        public function reporte_velocidad(int $movil, string $fechaInicial, string $fechaFinal, int $velocidad)
        {
            // Declaracion y asignacion de variables
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;
            $this->velocidad = $velocidad;

            // Consulta para obtener la informacion de la velocidad
            $query = "SELECT fecha_gps, posicion, latitud, longitud, velocidad
                        FROM public.posiciones
                        WHERE id_movil = $this->movil
                        AND latitud <> '0.0'
                        AND fecha_gps BETWEEN '$this->fechaInicial' AND '$this->fechaFinal' 
                        AND velocidad >= $this->velocidad
                        ORDER BY fecha_gps ASC";
            
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite generar el reporte de las horas de operacion
        public function horas_operacion(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asignacion de variables
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            $query = "SELECT SUBSTRING(''||date_trunc('day', posiciones.fecha_gps)||'',0,11) as fecha,MAX(horometro)-MIN(horometro)AS Horometro,MAX(odometro)-MIN(odometro) AS Odometro, AVG(velocidad), MAX(velocidad) 
                        FROM posiciones 
                        WHERE id_movil= $this->movil 
                        AND fecha_gps BETWEEN to_date('$this->fechaInicial', 'YYYY-MM-DD') AND to_date('$this->fechaFinal', 'YYYY-MM-DD')+ INTERVAL '1 day' 
                        AND horometro != 0
                        AND ignicion = 1
                        GROUP BY date_trunc('day', fecha_gps) ORDER BY date_trunc('day', fecha_gps) ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite generar el resumen de temperatura
        public function resumenTem(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asignacion de variables
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            // Generar consulta para obtener la informacion de la temperatura
            $query = "SELECT a.Placa, COALESCE(b.Maxima,'0') as maxima, COALESCE(c.Minima,'0') as minima, COALESCE(d.Promedio,0) as promedio
					FROM moviles a
					LEFT JOIN(SELECT id_movil, max(CAST(sensor1 AS float)) AS Maxima FROM temperaturas WHERE fecha BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' AND sensor1 < '50.0' AND posicion NOT LIKE 'null%' AND posicion NOT LIKE '%Buscando Satelites%' GROUP BY id_movil)b ON a.id_movil = b.id_movil
					LEFT JOIN(SELECT id_movil, min(CAST(sensor1 AS float)) AS Minima FROM temperaturas WHERE fecha BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' AND sensor1 != '0.0' AND sensor1 NOT LIKE '%-999%' AND posicion NOT LIKE 'null%'	 AND posicion NOT LIKE '%Buscando Satelites%' GROUP BY id_movil)c ON a.id_movil = c.id_movil
					LEFT JOIN(SELECT id_movil, avg(CAST(sensor1 AS float)) AS Promedio FROM temperaturas WHERE fecha BETWEEN '".$this->fechaInicial."' AND '".$this->fechaFinal."' AND sensor1 < '50.0' AND sensor1 != '0.0' AND sensor1 NOT LIKE '%-999%' AND posicion NOT LIKE 'null%' AND posicion NOT LIKE '%Buscando Satelites%' GROUP BY id_movil)d ON a.id_movil = d.id_movil
					WHERE a.id_movil = ".$this->movil." ORDER BY a.Placa ASC";
            
            $response = $this->select_all($query);
            return $response;
        }

        // Metodos que permite obtener la informacion del historico de la temperatura
        public function reporteTem(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asignacion de variables
            $this->movil = $movil;
            $this->fechaInicial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            // Consulta para obtener la informacion del historico de la temperatura
            $query = "SELECT fecha, posicion, latitud, longitud, CAST(sensor1 AS float) AS temperatura
                        FROM public.temperaturas
                        WHERE id_movil = $this->movil
                        AND fecha BETWEEN '$this->fechaInicial' AND '$this->fechaFinal'
                        AND sensor1 < '50.0'
                        AND sensor1 != '0.0'
                        AND sensor1 NOT LIKE '%-999%'
                        AND posicion NOT LIKE 'null%'
                        AND posicion NOT LIKE '%Buscando Satelites%'
                        ORDER BY fecha ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite obtner la informacion del cargue de combustible 
        public function consultar_combustible(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asigancion de valores a las variables
            $this->movil = $movil;
            $this->fechaIncial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            // Genarar consulta 
            $query = "SELECT fecha, doubcombustible, latitud, longitud FROM logs.log_combustible 
					WHERE id_movil = '".$this->movil."' 
					AND fecha BETWEEN '".$this->fechaIncial."' AND '".$this->fechaFinal."' 
					AND doubcombustible <> '0.0' 
					ORDER BY fecha ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite obtener la informacion del consumo de combustible
        public function consumo_combustible(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asigancion de valores a las variables
            $this->movil = $movil;
            $this->fechaIncial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            // Genarar consulta 
            $query = "SELECT fecha, doubcombustible, latitud, longitud FROM logs.log_combustible 
					WHERE id_movil = '".$this->movil."' 
					AND fecha BETWEEN '".$this->fechaIncial."' AND '".$this->fechaFinal."' 
					AND doubcombustible <> '0.0' 
					ORDER BY fecha ASC";
            $response = $this->select_all($query);
            return $response;
        }

        // Metodo que permite obtener la informacion adicional del consumo
        public function desplazamiento_consumo(int $movil, string $fechaInicial, string $fechaFinal)
        {
            // Declaracion y asigancion de valores a las variables
            $this->movil = $movil;
            $this->fechaIncial = $fechaInicial;
            $this->fechaFinal = $fechaFinal;

            // Generar consulta
            $query_uno = "SELECT DISTINCT ON (date_trunc('day', lg.fecha))
            date_trunc('day', lg.fecha) as fecha, doubcombustible, odometro, 
            first_value(doubcombustible) OVER (PARTITION BY date_trunc('day', lg.fecha) ORDER BY lg.fecha) as primer_registro,
            first_value(doubcombustible) OVER (PARTITION BY date_trunc('day', lg.fecha) ORDER BY lg.fecha DESC) as ultimo_registro,
			first_value(odometro) OVER (PARTITION BY date_trunc('day', lg.fecha) ORDER BY lg.fecha) as primer_valor_odometro,
			first_value(odometro) OVER (PARTITION BY date_trunc('day', lg.fecha) ORDER BY lg.fecha DESC) as ultimo_valor_odometro
          FROM logs.log_combustible lg
          WHERE id_movil = '".$this->movil."'
            AND fecha BETWEEN to_date('".$this->fechaInicial."', 'YYYY-MM-DD') AND to_date('".$this->fechaFinal."', 'YYYY-MM-DD') + INTERVAL '1 day'
            AND doubcombustible <> '0.0'
          ORDER BY date_trunc('day', lg.fecha), lg.fecha ASC";

          $response = $this->select_all($query_uno);
          return $response;
        }
    }
?>