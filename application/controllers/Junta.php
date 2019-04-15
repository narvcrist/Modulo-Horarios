<?php
class Junta extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mjunta');
        $this->load->model('mvarios');
    }
    
        function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("junta/js/index_juns_js",$datos);
            $this->load->view("junta/index_juns_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->mjunta->getdatosItems();
        }
        	
	//funcion para cear una nueva junta
	public function nuevaJunta(){     
        $datos=$this->datos(null,'n');
        $datos['accion'] = 'n';
        $this->load->view("junta/js/junta_js",$datos);
        $this->load->view("junta/junta_v",$datos);               
    }
    
    
    //funcion para ver la informacion de una junta
    function verJunta($accion=null){
        $numero = $this->input->post('NUMERO');
        if(!empty($numero)){
            $sol = $this->mjunta->dataJunta($numero);
            $USER=$this->session->userdata('US_CODIGO');
            if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                $datos=$this->datos($sol,$accion);
                $datos['sol']=$sol;
                $datos['accion'] = $accion;
                $this->load->view("junta/junta_v",$datos);
                $this->load->view("junta/js/junta_js",$datos);
            } else {
                echo alerta("La acción no es reconocida");
            }
        }else{
            echo alerta("No se puede mostrar el formulario, debe seleccionar una junta para continuar.");
        }
    }
    
	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	function datos($sol,$accion){
        if ($accion=='n') {
            //Caso para nueva junta
            $datos['combo_pais_junta']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_JUNTA'");
			$datos['combo_provincia_junta']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_JUNTA'");
            $datos['combo_ciudad_junta']=$this->cmb_ciudad_junta(null,null," style='width:150px;' id='LOC_CIUDAD_JUNTA'");
            
		} else {
            
            //DATOS LUGAR DE JUNTA
			$LOC_CIUDAD_JUNTA=$sol->JUN_SEC_LOCALIZACION;
			$LOC_PROVINCIA_JUNTA=$this->provincia_junta($LOC_CIUDAD_JUNTA);
			$LOC_PAIS_JUNTA=$this->pais_junta($LOC_PROVINCIA_JUNTA);			
			$datos['combo_pais_junta'] = $this->mvarios->cmb_pais($LOC_PAIS_JUNTA,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_JUNTA'");
			$datos['combo_provincia_junta']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_JUNTA,$LOC_PAIS_JUNTA," style='width:150px;' id='LOC_PROVINCIA_JUNTA'");
			$datos['combo_ciudad_junta']=$this->cmb_ciudad_junta($LOC_CIUDAD_JUNTA,$LOC_PROVINCIA_JUNTA," style='width:150px;' id='LOC_CIUDAD_JUNTA'");          
        }
        return($datos);
    }
    
    //FUNCIONES PARA LUGAR JUNTA	
    function cmb_ciudad_junta($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad_junta', $output, $LOC_SECUENCIAL, $attr);
        } else {
            $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=3 
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_PROVINCIA
										order by LOC_DESCRIPCION");
            $results = $query->result_array();
            $output = array();
            if ($query->num_rows() > 0) {
                foreach ($results as $result) {
                    $output[null] = "Ciudad...";
                    $output[$result['LOC_SECUENCIAL']] = utf8_encode($result['LOC_DESCRIPCION']);
                }
                return form_dropdown('ciudad_junta', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_junta' value='' />");
            }
		}
	}
	
	//Funcion para pais-junta
	function pais_junta($provincia){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia-junta
	function provincia_junta($ciudad){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
    
	//Administra las fonciones de nuevo y editar en una JUNTA
    function admJunta($accion){
        switch($accion){
            case 'n':
                echo $this->mjunta->agrJunta();
                break;
            case 'e':
                echo $this->mjunta->editJunta();
                break;
        }        
    }

    //Cambia de estado a pasivo a un persona	
    function anulartoda(){
        $PER_SECUENCIAL=$this->input->post('NUMERO');
        $SQL="update PERSONA set PER_ESTADO=1 where PER_SECUENCIAL=$PER_SECUENCIAL"; 
        $this->db->query($SQL);
        echo json_encode(array("cod"=>1,"mensaje"=>highlight("Persona ".$PER_SECUENCIAL." Eliminado, correctamente"))); 
	} 
}
?>