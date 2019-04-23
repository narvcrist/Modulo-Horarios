<?php
class Aspirante extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('maspirante');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("aspirante/js/index_asp_js",$datos);
            $this->load->view("aspirante/index_asp_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->maspirante->getdatosItems();
        }
        	
	//funcion para cear una nueva aspirante
	public function nuevaAspirante(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("aspirante/js/aspirante_js",$datos);
            $this->load->view("aspirante/aspirante_v",$datos);            
        }
        
        //funcion para ver la informacion de una aspirante
        function verAspirante($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->maspirante->dataAspirante($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("aspirante/aspirante_v",$datos);
                            $this->load->view("aspirante/js/aspirante_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una aspirante para continuar.");
            }
        }
              
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {


            
            $datos=null;	
		} else {
            $datos=null;      
        }
       return($datos);
     }
	
    
	//Administra las fonciones de nuevo y editar en una aspirante
    function admAspirante($accion){
        switch($accion){
            case 'n':
                echo $this->maspirante->agrAspirante();
                break;
            case 'e':
                echo $this->maspirante->editAspirante();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un aspirante	
    function anulartoda(){
         $ASP_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update ASPIRANTE set ASP_ESTADO=1 where ASP_SECUENCIAL=$ASP_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Aspirante ".$ASP_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>