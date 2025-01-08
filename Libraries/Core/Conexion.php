<?php 
	// Creacion de la clase conexion
	class Conexion
	{
		// Declaracion de la variables
		private $conect;

		// Creacion del metodo constructor encargado de realizar la conexion a la DB
		public function __construct(){

			$conectString = "pgsql:host=".DB_HOST.";port=5432;dbname=".DB_NAME;

			try{
				$this->conect = new PDO($conectString, DB_USER,DB_PASS);
				$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//echo "Conexion Establecida";
			}catch (Exception $e){
				$this->conect="Error de conexion";
				echo "ERROR:". $e->getMessage();
			}
		}

		public function conect(){
			return $this->conect;
		}
	}

	// $connect = new Conexion;

?>