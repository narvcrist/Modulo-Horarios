<?php
class Horario extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mhorario');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("horario/js/index_hor_js",$datos);
            $this->load->view("horario/index_hor_v",$datos);
        }
        
        function getdatosItems(){
           echo  $this->mhorario->getdatosItems();
        }
        	
	//funcion para cear un nuevo horario
	public function nuevoHorario(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("horario/js/horario_js",$datos);
            $this->load->view("horario/horario_v",$datos);            
        }
        
        //funcion para ver la informacion de un horario
        function verHorario($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mhorario->dataHorario($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("horario/horario_v",$datos);
                            $this->load->view("horario/js/horario_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una materia para continuar.");
            }
        }
              
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {
            $datos['combo_persona']=$this->mvarios->cmb_persona(null," style='width:100px;' id='HOR_SEC_PERSONA'");
            //$datos=null;
		} else {
            $HOR_SEC_PERSONA=$sol->HOR_SEC_PERSONA;
            $datos['combo_persona']=$this->mvarios->cmb_persona($HOR_SEC_PERSONA," style='width:100px;' id='HOR_SEC_PERSONA'");  
            //$datos=null;
        }
        return($datos);
     }
	 
	//Administra las fonciones de nuevo y editar en una persona
    function admHorario($accion){
        switch($accion){
            case 'n':
                echo $this->mhorario->agrHorario();
                break;
            case 'e':
                echo $this->mhorario->editHorario();
                break;
        }        
    }
	//Cambia de estado a pasivo a un horario
    function anulartoda(){
         $HOR_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update HORARIO set HOR_ESTADO=1 where HOR_SECUENCIAL=$HOR_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Horario ".$HOR_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>