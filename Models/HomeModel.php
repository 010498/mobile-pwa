<?php 
	
	/**
	 * Clase que permite realizar la comunicación con la base de datos 
	 */
	class HomeModel extends Pgsql
	{
		private $strusuario;
		private $strpassword;
		
		public function __construct()
		{
			parent::__construct();
		}


		// Funcion que hace el llamado a los datos del cliente 
		public function inisession(string $usuario, string $pass)
		{
			$this->strusuario = $usuario;
			$this->strpassword = $pass;

			// Consulta
			$query_select = "SELECT id_cliente, nombre, estado FROM public.clientes 
							WHERE usuario = '$this->strusuario' AND pass = '$this->strpassword'";
							
			$query_res = $this->select_all($query_select);

			return $query_res;
		}
	}

 ?>