<?php
class Perxlic extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mperxlic');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("perxlic/js/index_perxlics_js",$datos);
            $this->load->view("perxlic/index_perxlics_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->mperxlic->getdatosItems();
        }
        	
	//funcion para cear una nueva persona para la licencia
	public function nuevaPerxlic(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("perxlic/js/perxlic_js",$datos);
            $this->load->view("perxlic/perxlic_v",$datos);            
        }
        
        //funcion para ver la informacion de una persona para la licencia
        function verPerxlic($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mperxlic->dataPerxlic($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("perxlic/perxlic_v",$datos);
                            $this->load->view("perxlic/js/perxlic_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una persona para continuar.");
            }
        }
              
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {
            $datos['combo_licencia']=$this->mvarios->cmb_licencia(null," style='width:80%;' id='PERXLIC_SEC_LICENCIA'");
            $datos['combo_persona']=$this->mvarios->cmb_persona(null," style='width:60%;' id='PERXLIC_SEC_PERSONA'");
			//$datos=null;		
		} else {
			$PERXLIC_SEC_LICENCIA=$sol->PERXLIC_SEC_LICENCIA;			
			$datos['combo_licencia'] = $this->mvarios->cmb_licencia($PERXLIC_SEC_LICENCIA,"style='width:80%;' id='PERXLIC_SEC_LICENCIA'");

            $PERXLIC_SEC_PERSONA=$sol->PERXLIC_SEC_PERSONA;			
			$datos['combo_persona'] = $this->mvarios->cmb_persona($PERXLIC_SEC_PERSONA,"style='width:60%;' id='PERXLIC_SEC_PERSONA'");

        }
        return($datos);
     }
	 
	//Administra las fonciones de nuevo y editar en una persona para la licencia
    function admPerxlic($accion){
        switch($accion){
            case 'n':
                echo $this->mperxlic->agrPerxlic();
                break;
            case 'e':
                echo $this->mperxlic->editPerxlic();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un persona para la licencia	
    function anulartoda(){
         $PERXLIC_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update PERSONAXLICENCIA set PERXLIC_ESTADO=1 where PERXLIC_SECUENCIAL=$PERXLIC_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Licencia ".$PERXLIC_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>