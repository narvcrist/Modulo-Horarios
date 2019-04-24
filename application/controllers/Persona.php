<?php
class Persona extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mpersona');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("persona/js/index_pers_js",$datos);
            $this->load->view("persona/index_pers_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->mpersona->getdatosItems();
        }
        	
	//funcion para cear una nueva persona
	public function nuevaPersona(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("persona/js/persona_js",$datos);
            $this->load->view("persona/persona_v",$datos);            
        }
        
        //funcion para ver la informacion de una persona
        function verPersona($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mpersona->dataPersona($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("persona/persona_v",$datos);
                            $this->load->view("persona/js/persona_js",$datos);
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
			//Caso para nueva persona
            $datos['combo_genero']=$this->cmb_genero(null,null," style='width:100px;' id='PER_GENERO'");
            $datos['combo_civil']=$this->cmb_civil(null,null," style='width:100px;' id='PER_ESTADO_CIVIL'");
            $datos['combo_tipoSangre']=$this->cmb_tipoSangre(null,null," style='width:100px;' id='PER_TIPO_SANGRE'");
			
			//DATOS LUGAR DE ESTUDIO
			$datos['combo_pais_estudios']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_ESTUDIOS'");
			$datos['combo_provincia_estudios']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_ESTUDIOS'");
			$datos['combo_ciudad_estudios']=$this->cmb_ciudad_estudios(null,null," style='width:150px;' id='LOC_CIUDAD_ESTUDIOS'");
			//DATOS LUGAR DE RESIDENCIA
			$datos['combo_pais_residencia']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_RESIDENCIA'");
			$datos['combo_provincia_residencia']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_RESIDENCIA'");
			$datos['combo_ciudad_residencia']=$this->cmb_ciudad_residencia(null,null," style='width:150px;' id='LOC_CIUDAD_RESIDENCIA'");
			//DATOS LUGAR DE NACIMIENTO
			$datos['combo_pais_nacimiento']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_NACIMIENTO'");
			$datos['combo_provincia_nacimiento']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_NACIMIENTO'");
			$datos['combo_ciudad_nacimiento']=$this->cmb_ciudad_nacimiento(null,null," style='width:150px;' id='LOC_CIUDAD_NACIMIENTO'");
			//DATOS LUGAR DE TRABAJO
			$datos['combo_pais_trabajo']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_TRABAJO'");
			$datos['combo_provincia_trabajo']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_TRABAJO'");
			$datos['combo_ciudad_trabajo']=$this->cmb_ciudad_trabajo(null,null," style='width:150px;' id='LOC_CIUDAD_TRABAJO'");
			
			$datos['combo_junta']=$this->mvarios->cmb_junta(null," style='width:100px;' id='PER_SEC_JUNTA'");
			//$datos=null;	
		} else {
			//Caso para la edición de una persona
            $genero=$sol->PER_GENERO;
			$datos['combo_genero']=$this->cmb_genero($genero,$sol->PER_GENERO," style='width:100px;' id='PER_GENERO'");				
			$civil=$sol->PER_ESTADO_CIVIL;
			$datos['combo_civil']=$this->cmb_civil($civil,$sol->PER_ESTADO_CIVIL," style='width:100px;' id='PER_ESTADO_CIVIL'");				
			$tipoSangre=$sol->PER_TIPO_SANGRE;
			$datos['combo_tipoSangre']=$this->cmb_tipoSangre($tipoSangre,$sol->PER_TIPO_SANGRE," style='width:100px;' id='PER_TIPO_SANGRE'");
			
			//DATOS LUGAR DE ESTUDIO
			$CIUDAD_ESTUDIOS=$sol->PER_LUGAR_ESTUDIO;
			if(!empty($CIUDAD_ESTUDIOS) and $CIUDAD_ESTUDIOS<>0 and $CIUDAD_ESTUDIOS<>null){
				$LOC_CIUDAD_ESTUDIOS=$CIUDAD_ESTUDIOS;
				$LOC_PROVINCIA_ESTUDIOS=$this->provincia_estudios($LOC_CIUDAD_ESTUDIOS);
				$LOC_PAIS_ESTUDIOS=$this->pais_estudios($LOC_PROVINCIA_ESTUDIOS);
			}else{
				$LOC_CIUDAD_ESTUDIOS=null;
				$LOC_PROVINCIA_ESTUDIOS=null;
				$LOC_PAIS_ESTUDIOS=null;
			}
			$datos['combo_pais_estudios'] = $this->mvarios->cmb_pais($LOC_PAIS_ESTUDIOS,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_ESTUDIOS'");
			$datos['combo_provincia_estudios']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_ESTUDIOS,$LOC_PAIS_ESTUDIOS," style='width:150px;' id='LOC_PROVINCIA_ESTUDIOS'");
			$datos['combo_ciudad_estudios']=$this->cmb_ciudad_estudios($LOC_CIUDAD_ESTUDIOS,$LOC_PROVINCIA_ESTUDIOS," style='width:150px;' id='LOC_CIUDAD_ESTUDIOS'");			
			//DATOS LUGAR DE RESIDENCIA
			$CIUDAD_RESIDENCIA=$sol->PER_LUGAR_RESIDENCIA;		
			if(!empty($CIUDAD_RESIDENCIA) and $CIUDAD_RESIDENCIA<>0 and $CIUDAD_RESIDENCIA<>null){
				$LOC_CIUDAD_RESIDENCIA=$CIUDAD_RESIDENCIA;
				$LOC_PROVINCIA_RESIDENCIA=$this->provincia_residencia($LOC_CIUDAD_RESIDENCIA);
				$LOC_PAIS_RESIDENCIA=$this->pais_residencia($LOC_PROVINCIA_RESIDENCIA);	
			}else{
				$LOC_CIUDAD_RESIDENCIA=null;
				$LOC_PROVINCIA_RESIDENCIA=null;
				$LOC_PAIS_RESIDENCIA=null;
			}
			$datos['combo_pais_residencia'] = $this->mvarios->cmb_pais($LOC_PAIS_RESIDENCIA,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_RESIDENCIA'");
			$datos['combo_provincia_residencia']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_RESIDENCIA,$LOC_PAIS_RESIDENCIA," style='width:150px;' id='LOC_PROVINCIA_RESIDENCIA'");
			$datos['combo_ciudad_residencia']=$this->cmb_ciudad_residencia($LOC_CIUDAD_RESIDENCIA,$LOC_PROVINCIA_RESIDENCIA," style='width:150px;' id='LOC_CIUDAD_RESIDENCIA'");
			//DATOS LUGAR DE NACIMIENTO
			$CIUDAD_NACIMIENTO=$sol->PER_LUGAR_NACIMIENTO;
			if(!empty($CIUDAD_NACIMIENTO) and $CIUDAD_NACIMIENTO<>0 and $CIUDAD_NACIMIENTO<>null){
				$LOC_CIUDAD_NACIMIENTO=$CIUDAD_NACIMIENTO;
				$LOC_PROVINCIA_NACIMIENTO=$this->provincia_nacimiento($LOC_CIUDAD_NACIMIENTO);
				$LOC_PAIS_NACIMIENTO=$this->pais_nacimiento($LOC_PROVINCIA_NACIMIENTO);
			}else{
				$LOC_CIUDAD_NACIMIENTO=null;
				$LOC_PROVINCIA_NACIMIENTO=null;
				$LOC_PAIS_NACIMIENTO=null;
			}
			$datos['combo_pais_nacimiento'] = $this->mvarios->cmb_pais($LOC_PAIS_NACIMIENTO,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_NACIMIENTO'");
			$datos['combo_provincia_nacimiento']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_NACIMIENTO,$LOC_PAIS_NACIMIENTO," style='width:150px;' id='LOC_PROVINCIA_NACIMIENTO'");
			$datos['combo_ciudad_nacimiento']=$this->cmb_ciudad_nacimiento($LOC_CIUDAD_NACIMIENTO,$LOC_PROVINCIA_NACIMIENTO," style='width:150px;' id='LOC_CIUDAD_NACIMIENTO'");
			//DATOS LUGAR DE TRABAJO
			$CIUDAD_TRABAJO=$sol->PER_LUGAR_TRABAJO;			
			if(!empty($CIUDAD_TRABAJO) and $CIUDAD_TRABAJO<>0 and $CIUDAD_TRABAJO<>null){
				$LOC_CIUDAD_TRABAJO=$CIUDAD_TRABAJO;				
				$LOC_PROVINCIA_TRABAJO=$this->provincia_trabajo($LOC_CIUDAD_TRABAJO);
				$LOC_PAIS_TRABAJO=$this->pais_trabajo($LOC_PROVINCIA_TRABAJO);
			}else{
				$LOC_CIUDAD_TRABAJO=null;
				$LOC_PROVINCIA_TRABAJO=null;
				$LOC_PAIS_TRABAJO=null;
			}			
			$datos['combo_pais_trabajo'] = $this->mvarios->cmb_pais($LOC_PAIS_TRABAJO,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_TRABAJO'");
			$datos['combo_provincia_trabajo']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_TRABAJO,$LOC_PAIS_TRABAJO," style='width:150px;' id='LOC_PROVINCIA_TRABAJO'");
			$datos['combo_ciudad_trabajo']=$this->cmb_ciudad_trabajo($LOC_CIUDAD_TRABAJO,$LOC_PROVINCIA_TRABAJO," style='width:150px;' id='LOC_CIUDAD_TRABAJO'");
			
			$PER_SEC_JUNTA=$sol->PER_SEC_JUNTA;
            $datos['combo_junta']=$this->mvarios->cmb_junta($PER_SEC_JUNTA," style='width:100px;' id='PER_SEC_JUNTA'");
			//$datos=null;
        }
        return($datos);
     }
	 
	 //Combo para generos
    function  cmb_genero($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Género";
        $output['M'] = "Masculino";
        $output['F'] = "Femenino";
        return form_dropdown('genero', $output, $tipo, $attr);
    }
	
	//Combo para estado civil
    function  cmb_civil($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Estado Civil";
        $output['S'] = "Soltero";
        $output['U'] = "Unión de Hecho";
        $output['C'] = "Casado";
        $output['D'] = "Divorciado";
        $output['V'] = "Viudo";
        return form_dropdown('civil', $output, $tipo, $attr);
    }
	
	//Combo para tipo de sangre
    function  cmb_tipoSangre($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Tipo de Sangre";
        $output['AP'] = "A+";
        $output['AN'] = "A-";
        $output['BP'] = "B+";
        $output['BN'] = "B-";
        $output['OP'] = "O+";
        $output['ON'] = "O-";
        $output['ABP'] = "AB+";
        $output['ABN'] = "AB-";
        return form_dropdown('tipoSangre', $output, $tipo, $attr);
    }			
	
		
	//FUNCIONES PARA LUGAR ESTUDIOS
	function cmb_ciudad_estudios($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad_estudios', $output, $LOC_SECUENCIAL, $attr);
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
                return form_dropdown('ciudad_estudios', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_estudios' value='' />");
            }
		}
	}
	
	//Funcion para pais
	function pais_estudios($provincia){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia
	function provincia_estudios($ciudad){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
	
	//FUNCIONES PARA LUGAR RESIDENCIA	
	function cmb_ciudad_residencia($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad_residencia', $output, $LOC_SECUENCIAL, $attr);
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
                return form_dropdown('ciudad_residencia', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_residencia' value='' />");
            }
		}
	}
	
	//Funcion para pais
	function pais_residencia($provincia){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia
	function provincia_residencia($ciudad){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
	
	//FUNCIONES PARA LUGAR NACIMIENTO	
	function cmb_ciudad_nacimiento($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad_nacimiento', $output, $LOC_SECUENCIAL, $attr);
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
                return form_dropdown('ciudad_nacimiento', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_nacimiento' value='' />");
            }
		}
	}
	
	//Funcion para pais
	function pais_nacimiento($provincia){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia
	function provincia_nacimiento($ciudad){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
	
	//FUNCIONES PARA LUGAR TRABAJO	
	function cmb_ciudad_trabajo($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad_trabajo', $output, $LOC_SECUENCIAL, $attr);
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
                return form_dropdown('ciudad_trabajo', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_trabajo' value='' />");
            }
		}
	}
	
	//Funcion para pais
	function pais_trabajo($provincia){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia
	function provincia_trabajo($ciudad){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
	
	    
	//Administra las fonciones de nuevo y editar en una persona
    function admPersona($accion){
        switch($accion){
            case 'n':
                echo $this->mpersona->agrPersona();
                break;
            case 'e':
                echo $this->mpersona->editPersona();
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