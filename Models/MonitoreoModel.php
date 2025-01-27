<?php 

	/**
	 * Permite realizar la peticion de la informacion de los vehículos
	 */
	class MonitoreoModel extends Pgsql
	{
		
		public function __construct()
		{
			parent::__construct();
		}

		// Consulta que se encarga de consultar la informacion de los vehiculos 
		public function cargar_informacion()
		{

			$query_select = "SELECT public.star_monitoreo(".$_SESSION[id].")";
			
			$query_res = $this->select_all($query_select);
			
			return $query_res;
		}
	}

 ?>