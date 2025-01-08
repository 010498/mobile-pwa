<?php 

	/**
	 * Clase que se encarga de cargar las vistas de los controladores del proyecto
	 */
	class Controllers
	{
		
		function __construct()
		{
			$this->views = new Views();
			$this->loadModel();
		}

		public function loadModel()
		{
			$model = get_class($this)."Model";
			$routClass = "Models/".$model.".php";
			if(file_exists($routClass))
			{
				require_once($routClass);
				$this->model = new $model();
			}
		}
	}

?>