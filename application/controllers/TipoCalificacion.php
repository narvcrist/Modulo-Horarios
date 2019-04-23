<?php
class TipoCalificacion extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mtipoCalificacion');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("tipoCalificacion/js/index_tipcal_js",$datos);
            $this->load->view("tipoCalificacion/index_tipcal_v",$datos);
            
        }
        
        function getdatosItems(){
            echo  $this->mtipoCalificacion->getdatosItems();
        }
        	
	//funcion para cear una nueva calificacion
	public function nuevaTipoCalificacion(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("tipoCalificacion/js/tipoCalificacion_js",$datos);
            $this->load->view("tipoCalificacion/tipoCalificacion_v",$datos);            
        }

        //funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {   
            $datos['combo_matricula']=$this->mvarios->cmb_matricula(null," style='width:800px;' id='TIPCAL_SEC_MATRICULA'");
 
            //$datos=null;
		} else {
            $TIPCAL_SEC_MATRICULA=$sol->TIPCAL_SEC_MATRICULA;
            $datos['combo_matricula']=$this->mvarios->cmb_matricula($TIPCAL_SEC_MATRICULA," style='width:800px;' id='TIPCAL_SEC_MATRICULA'");
            //$datos=null;
        }
       return($datos);
     }
    
        
        //funcion para ver la informacion de una calificacion
        function verTipoCalificacion($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mtipoCalificacion->dataTipoCalificacion($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("tipoCalificacion/tipoCalificacion_v",$datos);
                            $this->load->view("tipoCalificacion/js/tipoCalificacion_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una calificacion para continuar.");
            }
        } 
              
	
	//Administra las funciones de nuevo y editar en una calificacion
    function admTipoCalificacion($accion){
        switch($accion){
            case 'n':
                echo $this->mtipoCalificacion->agrTipoCalificacion();
                break;
            case 'e':
                echo $this->mtipoCalificacion->editTipoCalificacion();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un	
    function anulartoda(){
         $TIPCAL_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update TIPOCALIFICACION set TIPCAL_ESTADO=1 where TIPCAL_SECUENCIAL=$TIPCAL_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("TipoCalificacion ".$TIPCAL_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}


?>

