<?php 
	
	/**
	 * Clase que se encarga cargar las funcionales del login
	 */
	class Home extends Controllers
	{
		
		public	function __construct()
		{
			session_start();
			if(isset($_SESSION['login'])){
				header('Location: '.base_url().'monitoreo');
			}
			parent::__construct();
		}

		public function home()
		{
			$data['page_tag'] = "Login | Starseguimiento";
			$data['page_title'] = "Página Principal";
			$data['page_name'] = "Login | Starseguimiento";
			$data['data_functions_js'] = "function_login.js";
			$data['app'] = "app.js";
			$this->views->getView($this,"Home",$data);
		}


		public function login()
		{
			
			
			if($_POST){
				if(empty($_POST['user-info']) || empty($_POST['pass-info'])){
					$arrResponse = array('status' => false, 'msg' => "Error de datos");
				}else{
					$strUsuario = strtoupper(strClean($_POST['user-info']));
					$strPassword = strtoupper(strClean($_POST['pass-info']));
					$register = $this->model->inisession($strUsuario, $strPassword);
					
					
					if(empty($register)){

						$arrResponse = array('status' => false, 'msg' => 'ERROR USUARIO O CONTRASEÑA');

					}else{
						$arrData = $register[0];
						// echo $arrData['estado'];
						if($arrData['estado'] == 1){
							$_SESSION['id'] 	= $arrData['id_cliente'];
		  		            $_SESSION['nombre'] = $arrData['nombre'];
		  		            $_SESSION['estado'] = $arrData['estado'];
		                  	$_SESSION['login']  = true;

		                  	$arrResponse = array('status' => true, 'msg' => "Bienvenido");

		                }else{

		                	$arrResponse = array('status' => false, 'msg' => 'USUARIO NO DISPONIBLE');
		                }
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}

?>