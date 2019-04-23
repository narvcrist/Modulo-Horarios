<?php
class Materia extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mmateria');
        $this->load->model('mvarios');
    }
    
       function index(){
            $datos['aprobador']=$this->session->userdata('US_ADMINISTRADOR');
			$datos['usuario']=$this->session->userdata('US_USUARIO');
            $this->load->view("materia/js/index_mats_js",$datos);
            $this->load->view("materia/index_mats_v",$datos);
        }
        
        function getdatosItems(){
            echo  $this->mmateria->getdatosItems();
        }
        	
	//funcion para cear una nueva materia
	public function nuevaMateria(){     
            $datos=$this->datos(null,'n');
            $datos['accion'] = 'n';
			$this->load->view("materia/js/materia_js",$datos);
            $this->load->view("materia/materia_v",$datos);            
        }
        
        //funcion para ver la informacion de una materia
        function verMateria($accion=null){
            $numero = $this->input->post('NUMERO');
            if(!empty($numero)){
                $sol = $this->mmateria->dataMateria($numero);
                      $USER=$this->session->userdata('US_CODIGO');
                      if ($accion=='v'|$accion=='e'|$accion=='x'|$accion=='a'){
                            $datos=$this->datos($sol,$accion);
                            $datos['sol']=$sol;
                            $datos['accion'] = $accion;
                            $this->load->view("materia/materia_v",$datos);
                            $this->load->view("materia/js/materia_js",$datos);
                      } else {
                            echo alerta("La acción no es reconocida");
                      }
            }else{
                echo alerta("No se puede mostrar el formulario, debe seleccionar una materia para continuar.");
            }
        }


        
        function datos($sol,$accion){
        if ($accion=='n') {
            //Caso para nueva materia
            $datos['combo_nivel']=$this->cmb_nivel(null,null," style='width:100px;' id='MAT_NIVEL'");
            $datos['combo_materia']=$this->cmb_materia(null,null," style='width:100px;' id='MAT_NOMBRE'");

        }else{
            //Caso para la edicion de una materia
            $nivel=$sol->MAT_NIVEL;
            $datos['combo_nivel']=$this->cmb_nivel($nivel,$sol->MAT_NIVEL," style='width:100px;' id='MAT_NIVEL'");	
            $materia=$sol->MAT_NOMBRE;			
            $datos['combo_materia']=$this->cmb_materia($materia,$sol->MAT_NOMBRE," style='width:100px;' id='MAT_NOMBRE'");				
        

        }
        return($datos);
    }


	//funcion para dar los valores a la cabecera tanto en nuevo, como al momento de editar
	/*function datos($sol,$accion){
        if ($accion=='n') {
			//Caso para nueva persona
            $datos['combo_genero']=$this->cmb_genero(null,null," style='width:100px;' id='PER_GENERO'");
            $datos['combo_civil']=$this->cmb_civil(null,null," style='width:100px;' id='PER_ESTADO_CIVIL'");
            $datos['combo_tipoSangre']=$this->cmb_tipoSangre(null,null," style='width:100px;' id='PER_TIPO_SANGRE'");
            
            //Datos de Lugar Estudio
            $datos['combo_pais_estudios']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_ESTUDIOS'");
			$datos['combo_provincia_estudios']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_ESTUDIOS'");
			$datos['combo_ciudad_estudios']=$this->cmb_ciudad_estudios(null,null," style='width:150px;' id='LOC_CIUDAD_ESTUDIOS'");
            
            //Datos de Lugar Nacimiento
            $datos['combo_pais_nacimiento']= $this->mvarios->cmb_pais(null," style='width:150px;' id='LOC_PAIS_NACIMIENTO'");
            $datos['combo_provincia_nacimiento']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_NACIMIENTO'");
            $datos['combo_ciudad_nacimiento']=$this->cmb_ciudad_nacimiento(null,null," style='width:150px;' id='LOC_CIUDAD_NACIMIENTO'");
            

            //Datos de Mat_Nivel
            $datos['combo_mat_nivel']= $this->mvarios->cmb_materia(null," style='width:150px;' id='MAT_NIVEL'");
           // $datos['combo_provincia_trabajo']=$this->mvarios->cmb_provincia(null,null," style='width:150px;' id='LOC_PROVINCIA_TRABAJO'");
           // $datos['combo_ciudad_trabajo']=$this->cmb_ciudad_trabajo(null,null," style='width:150px;' id='LOC_CIUDAD_TRABAJO'");
            
            //$datos=null;	
		} else {
            
			//Caso para la edición de una persona
            $genero=$sol->PER_GENERO;
			$datos['combo_genero']=$this->cmb_genero($genero,$sol->PER_GENERO," style='width:100px;' id='PER_GENERO'");				
			$civil=$sol->PER_ESTADO_CIVIL;
			$datos['combo_civil']=$this->cmb_civil($civil,$sol->PER_ESTADO_CIVIL," style='width:100px;' id='PER_ESTADO_CIVIL'");				
			$tipoSangre=$sol->PER_TIPO_SANGRE;
			$datos['combo_tipoSangre']=$this->cmb_tipoSangre($tipoSangre,$sol->PER_TIPO_SANGRE," style='width:100px;' id='PER_TIPO_SANGRE'");
            //$datos=null;
            
            //Datos Lugar de Estudio
            $LOC_CIUDAD_ESTUDIOS=$sol->PER_LUGAR_ESTUDIO;
			$LOC_PROVINCIA_ESTUDIOS=$this->provincia_estudios($LOC_CIUDAD_ESTUDIOS);
			$LOC_PAIS_ESTUDIOS=$this->pais_estudios($LOC_PROVINCIA_ESTUDIOS);			
			$datos['combo_pais_estudios'] = $this->mvarios->cmb_pais($LOC_PAIS_ESTUDIOS,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_ESTUDIOS'");
			$datos['combo_provincia_estudios']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_ESTUDIOS,$LOC_PAIS_ESTUDIOS," style='width:150px;' id='LOC_PROVINCIA_ESTUDIOS'");
            $datos['combo_ciudad_estudios']=$this->cmb_ciudad_estudios($LOC_CIUDAD_ESTUDIOS,$LOC_PROVINCIA_ESTUDIOS," style='width:150px;' id='LOC_CIUDAD_ESTUDIOS'");
            
            //Datos Lugar de Nacimiento
            $LOC_CIUDAD_NACIMIENTO=$sol->PER_LUGAR_NACIMIENTO;
			$LOC_PROVINCIA_NACIMIENTO=$this->provincia_nacimiento($LOC_CIUDAD_NACIMIENTO);
			$LOC_PAIS_NACIMIENTO=$this->pais_nacimiento($LOC_PROVINCIA_NACIMIENTO);			
			$datos['combo_pais_nacimiento'] = $this->mvarios->cmb_pais($LOC_PAIS_NACIMIENTO,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='LOC_PAIS_NACIMIENTO'");
			$datos['combo_provincia_nacimiento']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_NACIMIENTO,$LOC_PAIS_NACIMIENTO," style='width:150px;' id='LOC_PROVINCIA_NACIMIENTO'");
			$datos['combo_ciudad_nacimiento']=$this->cmb_ciudad_nacimiento($LOC_CIUDAD_NACIMIENTO,$LOC_PROVINCIA_NACIMIENTO," style='width:150px;' id='LOC_CIUDAD_NACIMIENTO'");
            

            //Datos Mat_Nivel
            $MAT_NIVEL=$sol->MAT_NIVEL;
			//$LOC_PROVINCIA_TRABAJO=$this->provincia_trabajo($LOC_CIUDAD_TRABAJO);
			//$LOC_PAIS_TRABAJO=$this->pais_trabajo($LOC_PROVINCIA_TRABAJO);			
			$datos['combo_mat_nivel'] = $this->mvarios->cmb_materia($MAT_NIVEL,"style='width:150px; height:25px;' class='selectpicker' data-style='btn-success' id='MAT_NIVEL'");
			//$datos['combo_provincia_trabajo']=$this->mvarios->cmb_provincia($LOC_PROVINCIA_TRABAJO,$LOC_PAIS_TRABAJO," style='width:150px;' id='LOC_PROVINCIA_TRABAJO'");
            //$datos['combo_ciudad_trabajo']=$this->cmb_ciudad_trabajo($LOC_CIUDAD_TRABAJO,$LOC_PROVINCIA_TRABAJO," style='width:150px;' id='LOC_CIUDAD_TRABAJO'");
        }
        return($datos);
     }*/
	 
	 /*//Combo para generos
    function  cmb_genero($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Género";
        $output['M'] = "Masculino";
        $output['F'] = "Femenino";
        return form_dropdown('genero', $output, $tipo, $attr);
    }*/
	
	//Combo para Nivel Materia
    function  cmb_nivel($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Nivel";
        $output[1] = "Primero";
        $output[2] = "Segundo";
        $output[3] = "Tercero";
        $output[4] = "Cuarto";
        $output[5] = "Quinto";
        return form_dropdown('nivel', $output, $tipo, $attr);
    }

    //Combo para Nombre Materia
    function  cmb_materia($tipo = null, $attr = null) {
        $output = array();
        $output[null] = "Seleccione Materia";
        $output['Matematicas'] = "Matematicas";
        $output['Ciencias Naturales'] = "Ciencias Naturales";
        $output['Estudios Sociales'] = "Estudios Sociales";
        $output['Quimica'] = "Quimica";
        $output['Fisica'] = "Fisica";
        $output['Lenguaje'] = "Lenguaje";
        $output['Historia'] = "Historia";
        return form_dropdown('materia', $output, $tipo, $attr);
    }
	
	/*//Combo para tipo de sangre
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
    }*/

    /*//FUNCIONES PARA LUGAR ESTUDIOS
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
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_estudios' value='' />");
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
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad_estudios' value='' />");
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
    }*/






    
	//Administra las funciones de nuevo y editar en una materia
    function admMateria($accion){
        switch($accion){
            case 'n':
                echo $this->mmateria->agrMateria();
                break;
            case 'e':
                echo $this->mmateria->editMateria();
                break;
        }        
    }
    
	//Cambia de estado a pasivo a un materia	
    function anulartoda(){
         $MAT_SECUENCIAL=$this->input->post('NUMERO');
            $SQL="update MATERIA set MAT_ESTADO=1 where MAT_SECUENCIAL=$MAT_SECUENCIAL"; 
            $this->db->query($SQL);
            echo json_encode(array("cod"=>1,"mensaje"=>highlight("Materia ".$MAT_SECUENCIAL." Eliminado, correctamente"))); 
		} 
}
?>