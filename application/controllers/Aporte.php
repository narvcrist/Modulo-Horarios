<?php
class Aporte extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('maporte');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("aporte/js/index_apor_js",$datos);
            $this->load->view("aporte/index_apor_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->maporte->getdatosItems();
        }	
	//funcion para cear un nuevo aporte
	public function nuevoAporte(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
            $this->load->view("aporte/aporte_v",$datos);
            $this->load->view("aporte/js/aporte_js",$datos);
        }
        //funcion para ver la informacion de un aporte
        function verAporte($accion=null){
            $numero= $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->maporte->dataAporte($numero);
                      $USER=$this->session->userdata('US_CODIGO');
					  $nombreuser=$this->db->query("SELECT US_NOMBRES FROM ISTCRE_APLICACIONES.USUARIO WHERE US_CODIGO='$USER'")->row();
                      if ($accion=='v'|$accion=='e'|$accion=='x'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("aporte/aporte_v",$datos);
                            $this->load->view("aporte/js/aporte_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar un aporte para continuar.");
            }
        }           
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {
            	$datos['combo_persona']=$this->mvarios->cmb_persona(null,"style='width:130px;' id='APO_SEC_PERSONA'");			
            	$datos['combo_matricula']=$this->mvarios->cmb_matricula(null,"style='width:500px;' id='APO_SEC_MATRICULA'");			
                //$datos = null;
            
        } else {
            $APO_SEC_PERSONA=$sol->APO_SEC_PERSONA;
            $datos['combo_persona']=$this->mvarios->cmb_persona($APO_SEC_PERSONA,"style='width:130px;' id='APO_SEC_PERSONA'");			
            $APO_SEC_MATRICULA=$sol->APO_SEC_MATRICULA;
            $datos['combo_matricula']=$this->mvarios->cmb_matricula($APO_SEC_MATRICULA,"style='width:500px;' id='APO_SEC_MATRICULA'");
            //$datos = null;    
        }
        return($datos);
     }
	//Administra las foncuiones de nuevo y editar en un aporte
    function admAporte($accion){
        switch($accion){
            case 'n':
                echo $this->maporte->agrAporte();
                break;
            case 'e':
                echo $this->maporte->editAporte();
                break;
        }        
    }
	//Cambia de estado a pasivo a un persona	
    function anulartoda(){
         $APO_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update APORTES set APO_ESTADO=1 where APO_SECUENCIAL=$APO_SECUENCIAL";  
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Aporte ".$APO_SECUENCIAL." Eliminado correctamente"))); 
		} 
}
?>