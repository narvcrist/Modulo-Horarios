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
            //Caso para nueva persona
            //$datos['combo_genero']=$this->cmb_genero(null,null," style='width:100px;' id='PER_GENERO'");
			//$datos['combo_civil']=$this->cmb_civil(null,null," style='width:500px;' id='PER_ESTADO_CIVIL'");				
            $datos = null;
            
        } else {
            //Caso para la edición de una persona
            //$genero=$sol->PER_GENERO;
            //$datos['combo_genero']=$this->cmb_genero($genero,$sol->PER_GENERO," style='width:500px;' id='PER_GENERO'");
            //$civil=$sol->PER_ESTADO_CIVIL;
            //$datos['combo_civil']=$this->cmb_civil($civil,$sol->PER_ESTADO_CIVIL," style='width:500px;' id='PER_ESTADO_CIVIL'");
            //$tipoSangre=$sol->PER_TIPO_SANGRE;
			//$datos['combo_tipoSangre']=$this->cmb_tipoSangre($tipoSangre,$sol->PER_TIPO_SANGRE," style='width:500px;' id='PER_TIPO_SANGRE'");				
            //Datos lugar de estudio
            $datos = null;
           
        }
        return($datos);
     }
	 
	 //Combo para generos
    //function  cmb_genero($tipo = null, $attr = null) {
        //$output = array();
        //$output[null] = "Seleccionar Genero";
        //$output['M'] = "Masculino";
        //$output['F'] = "Femenino";
        //return form_dropdown('genero', $output, $tipo, $attr);
    //}
    //Combo para estado civil
    //function  cmb_civil($tipo = null, $attr = null) {
        //$output = array();
        //$output[null] = "Seleccionar estado civil";
        //$output['S'] = "Soltero";
        //$output['C'] = "Casado";
       // $output['V'] = "Viudo";
       //$output['D'] = "Divorciado";
        //$output['U'] = "Union de Hechos";
        //return form_dropdown('civil', $output, $tipo, $attr);
    //}
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