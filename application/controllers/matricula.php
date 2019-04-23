<?php
class Matricula extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mmatricula');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("matricula/js/index_matr_js",$datos);
            $this->load->view("matricula/index_matr_v",$datos);
            
        }
        
        function getdatosItems(){
            echo  $this->mmatricula->getdatosItems();
        }
        	
	//funcion para cear una nueva matricula
	public function nuevaMatricula(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("matricula/js/matricula_js",$datos);
            $this->load->view("matricula/matricula_v",$datos);            
        }

            //funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
            function datos($sol,$accion){
                if ($accion=='n') {   

                    
               $datos['combo_persona']=$this->mvarios->cmb_persona(null," style='width:100px;' id='MATR_SEC_PERSONA'");
               $datos['combo_aspirante']=$this->mvarios->cmb_aspirante(null," style='width:100px;' id='MATR_SEC_ASPIRANTE'");
               $datos['combo_materia']=$this->mvarios->cmb_materia(null," style='width:100px;' id='MATR_SEC_MATERIA'");
               $datos['combo_jornada']=$this->mvarios->cmb_jornada(null," style='width:100px;' id='MATR_SEC_JORNADA'");

                 //  $datos=null;
                } else {
                    $MATR_SEC_PERSONA=$sol->MATR_SEC_PERSONA;
                    $datos['combo_persona']=$this->mvarios->cmb_persona($MATR_SEC_PERSONA," style='width:100px;' id='MATR_SEC_PERSONA'");
                   
                    $MATR_SEC_ASPIRANTE=$sol->MATR_SEC_ASPIRANTE;
                    $datos['combo_aspirante']=$this->mvarios->cmb_aspirante($MATR_SEC_ASPIRANTE," style='width:100px;' id='MATR_SEC_ASPIRANTE'");
                   
                    $MATR_SEC_MATERIA=$sol->MATR_SEC_MATERIA;
                    $datos['combo_materia']=$this->mvarios->cmb_materia($MATR_SEC_MATERIA," style='width:100px;' id='MATR_SEC_MATERIA'");
                    
                    $MATR_SEC_JORNADA=$sol->MATR_SEC_JORNADA;
                    $datos['combo_jornada']=$this->mvarios->cmb_jornada($MATR_SEC_JORNADA," style='width:100px;' id='MATR_SEC_JORNADA'");
                   
                    //$datos=null;
                  
                }
               return($datos);
             }
               
        //funcion para ver la informacion de una matricula
        function verMatricula($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mmatricula->dataMatricula($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("matricula/matricula_v",$datos);
                            $this->load->view("matricula/js/matricula_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una matricula para continuar.");
            }
        } 
                  	
	//Administra las funciones de nuevo y editar en una matricula
    function admMatricula($accion){
        switch($accion){
            case 'n':
                echo $this->mmatricula->agrMatricula();
                break;
            case 'e':
                echo $this->mmatricula->editMatricula();
                break;
        }        
    }
    
    
	//Cambia de estado a pasivo a un	
    function anulartoda(){
         $MATR_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update MATRICULA set MATR_ESTADO=1 where MATR_SECUENCIAL=$MATR_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Matricula".$MATR_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>