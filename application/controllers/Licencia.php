<?php
class Licencia extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mlicencia');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("licencia/js/index_lics_js",$datos);
            $this->load->view("licencia/index_lics_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->mlicencia->getdatosItems();
        }
        	
	//funcion para cear una nueva licencia
	public function nuevaLicencia(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("licencia/js/licencia_js",$datos);
            $this->load->view("licencia/licencia_v",$datos);            
        }
        
        //funcion para ver la informacion de una licencia
        function verLicencia($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mlicencia->dataLicencia($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("licencia/licencia_v",$datos);
                            $this->load->view("licencia/js/licencia_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una licencia para continuar.");
            }
        }
              
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {
			//Caso para nueva licencia
            $datos['combo_licencia']=$this->cmb_licencia(null,null," style='width:100px;' id='LIC_NOMBRE'");
            
			//$datos=null;		
		} else {
            //Caso para la edición de una licencia
            
            $licencia=$sol->LIC_NOMBRE;
			$datos['combo_licencia']=$this->cmb_licencia($licencia,$sol->LIC_NOMBRE," style='width:100px;' id='LIC_NOMBRE'");
        }
        return($datos);
     }
	 
	 //Combo para generos
    function  cmb_licencia($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Licencia";
        $output['LICENCIA TIPO A'] = "TIPO A";
        $output['LICENCIA TIPO B'] = "TIPO B";
        $output['LICENCIA TIPO A1'] = "TIPO A1";
        $output['LICENCIA TIPO C'] = "TIPO C";
        $output['LICENCIA TIPO C1'] = "TIPO C1";
        $output['LICENCIA TIPO D'] = "TIPO D";
        $output['LICENCIA TIPO D1'] = "TIPO D1";
        $output['LICENCIA TIPO E'] = "TIPO E";
        $output['LICENCIA TIPO E1'] = "TIPO E1";
        $output['LICENCIA TIPO F'] = "TIPO F";
        $output['LICENCIA TIPO G'] = "TIPO G";
        return form_dropdown('licencia', $output, $tipo, $attr);
    }
	
	//Administra las fonciones de nuevo y editar en una licencia
    function admLicencia($accion){
        switch($accion){
            case 'n':
                echo $this->mlicencia->agrLicencia();
                break;
            case 'e':
                echo $this->mlicencia->editLicencia();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un licencia	
    function anulartoda(){
         $LIC_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update LICENCIA set LIC_ESTADO=1 where LIC_SECUENCIAL=$LIC_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Licencia ".$LIC_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>