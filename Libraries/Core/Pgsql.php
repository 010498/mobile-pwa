<?php 

	class Pgsql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;

		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}


		// Metodo utilizada para INSERT datos
		public function insert(string $query, array $arrvalues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrvalues;
			$insert = $this->conexion->prepare($this->strquery);
			$resInsert = $insert->execute($this->arrValues);
			if($resInsert){
				$lastInsert = $this->conexion->lastInsertId();
			}else{
				$lastInsert = 0;
			}
			return $lastInsert;
		}

		// Metodo utilizado para SELECT un dato
		public function select(string $query)
		{
			$this->strquery = $query;
			$select = $this->conexion->prepare($this->strquery);
			$select->execute();
			$data = $select->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		// Metodo que permite obtener todos los datos
		public function select_all(string $query)
		{
			$this->strquery  = $query;
			$select = $this->conexion->prepare($this->strquery);
			$select->execute();
			$data = $select->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}

		// Metodo que permite ACTUALIZAR datos
		public function update(string $query, array $arrvalues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrvalues;
			$update = $this->conexion->prepare($this->strquery);
			$result = $update->execute($this->arrValues);
			return $result;
		}

		// Metodo que permite ELIMINAR datos
		public function delete(string $query)
		{
			$this->strquery = $query;
			$delete = $this->conexion->prepare($this->strquery);
			$result = $this->execute();
			return $result;
		}
	}

?>