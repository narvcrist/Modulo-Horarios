<?php
class Cronograma extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mcronograma');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
           $this->load->view("cronograma/js/index_cro_js",$datos);
           $this->load->view("cronograma/index_cro_v",$datos);
      }
        
        function getdatosItems(){
            echo  $this->mcronograma->getdatosItems();
        }
        	
	//funcion para cear un nuevo Cronograma
	public function nuevoCronograma(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
            $this->load->view("cronograma/cronograma_v",$datos);
            $this->load->view("cronograma/js/cronograma_js",$datos);
        }
        
        //funcion para ver la informacion del Cronograma
        function verCronograma($accion=null){
            $numero= $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mcronograma->dataCronograma($numero);
                      $USER=$this->session->userdata('US_CODIGO');
					
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("cronograma/cronograma_v",$datos);
                            $this->load->view("cronograma/js/cronograma_js",$datos);
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
            //Caso para nuevo cronograma
            $datos['combo_materia']=$this->mvarios->cmb_materia(null,null," style='width:100px;' id='CRO_SEC_MATERIA'");
			$datos['combo_aspirante']=$this->mvarios->cmb_aspirante(null,null," style='width:500px;' id='CRO_SEC_ASPIRANTE'");				
			$datos['combo_descripcion']=$this->cmb_descripcion(null,null," style='width:500px;' id='CRO_DESCRIPCION'");					
            $datos['combo_observaciones']=$this->cmb_observaciones(null,null," style='width:500px;' id='CRO_OBSERVACIONES'");
            $datos['combo_responsable']=$this->cmb_responsable(null,null," style='width:500px;' id='CRO_RESPONSABLE'");
            //Datos lugar  de estudio
            $datos['combo_pais_estudios']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_ESTUDIOS'");
			$datos['combo_provincia_estudios']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_ESTUDIOS'");
            
          
        } else {
            //Caso para la edición de un Cronograma
            $materia=$sol->CRO_SEC_MATERIA;
            $datos['combo_materia']=$this->mvarios->cmb_materia($materia,$sol->CRO_SEC_MATERIA," style='width:500px;' id='CRO_SEC_MATERIA'");
            $aspirante=$sol->CRO_SEC_ASPIRANTE;
            $datos['combo_aspirante']=$this->mvarios->cmb_aspirante($aspirante,$sol->CRO_SEC_ASPIRANTE," style='width:500px;' id='CRO_SEC_ASPIRANTE'");
            $descripcion=$sol->CRO_DESCRIPCION;
            $datos['combo_descripcion']=$this->cmb_descripcion($descripcion,$sol->CRO_DESCRIPCION," style='width:500px;' id='CRO_DESCRIPCION'");
         
		}  



        return($datos);
     }
	 
	 //Combo para materia
    function  cmb_materia($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Ingrese Matricula";
       
        return form_dropdown('materia', $output, $tipo, $attr);
    }
      //Combo para aspirante
    function  cmb_aspirante($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Ingrese Aspirante";
       
        return form_dropdown('aspirante', $output, $tipo, $attr);
    }
     //Combo para descripcion
     function  cmb_descripcion($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Descripción";
       
        return form_dropdown('descripcion', $output, $tipo, $attr);
    }
  

        //Combo para responsable
       function  cmb_responsable($tipo = null, $attr = null) {
            $output = array();
            $output[null] = "Responsable";
           
            return form_dropdown('responsable', $output, $tipo, $attr);
        }
        
        //Combo para responsable
       function  cmb_observaciones($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Observaciones";
       
        return form_dropdown('observaciones', $output, $tipo, $attr);
    }
	//Administra las foncuiones de nuevo y editar un Cronograma  
    function admCronograma($accion){
        switch($accion){
            case 'n':
                echo $this->mcronograma->agrCronograma();
                break;
            case 'e':
                echo $this->mcronograma->editCronograma();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un cronograma
    function anulartoda(){
         $CRO_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update CRONOGRAMA set CRO_ESTADO=1 where CRO_SECUENCIAL=$CRO_SECUENCIAL";  
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Cronograma ".$CRO_SECUENCIAL." Eliminado correctamente"))); 
		}
}
?>