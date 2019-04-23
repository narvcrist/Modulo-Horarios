<?php
class Asistencia extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('masistencia');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("asistencia/js/index_ast_js",$datos);
            $this->load->view("asistencia/index_ast_v",$datos);
            
        }
        
        function getdatosItems(){
            echo  $this->masistencia->getdatosItems();
        }
        	
	//funcion para cear una nueva asistencia
	public function nuevaAsistencia(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("asistencia/js/asistencia_js",$datos);
            $this->load->view("asistencia/asistencia_v",$datos);            
        }

            //funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
            function datos($sol,$accion){
                if ($accion=='n') {   
                    $datos['combo_persona']=$this->mvarios->cmb_persona(null," style='width:100px;' id='AST_SEC_PERSONA'");
                    $datos['combo_matricula']=$this->mvarios->cmb_matricula(null," style='width:100px;' id='AST_SEC_MATRICULA'");

                    //$datos=null;
                } else {
                    $AST_SEC_PERSONA=$sol->AST_SEC_PERSONA;
                    $datos['combo_persona']=$this->mvarios->cmb_persona($AST_SEC_PERSONA," style='width:100px;' id='AST_SEC_PERSONA'");
                  
                    $AST_SEC_MATRICULA=$sol->AST_SEC_MATRICULA;
                    $datos['combo_matricula']=$this->mvarios->cmb_matricula($AST_SEC_MATRICULA," style='width:100px;' id='AST_SEC_MATRICULA'");
                    
                  
                    //$datos=null;
                }
               return($datos);
             }
            
    
        
        //funcion para ver la informacion de una asistencia
        function verAsistencia($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->masistencia->dataAsistencia($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("asistencia/asistencia_v",$datos);
                            $this->load->view("asistencia/js/asistencia_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una sistencia para continuar.");
            }
        } 
              

    	
	//Administra las funciones de nuevo y editar en una calificacion
    function admAsistencia($accion){
        switch($accion){
            case 'n':
                echo $this->masistencia->agrAsistencia();
                break;
            case 'e':
                echo $this->masistencia->editAsistencia();
                break;
        }        
    }
    
    
	//Cambia de estado a pasivo a un	
    function anulartoda(){
         $AST_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update ASISTENCIA set AST_ESTADO=1 where AST_SECUENCIAL=$AST_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Asistencia".$AST_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>