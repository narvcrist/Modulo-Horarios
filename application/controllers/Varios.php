<?php
class Varios extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('mvarios');
    }
    
     function ruta($urlEncoded){
        $this->load->model('maprobar'); 
        $function = explode("--",base64_decode($urlEncoded));
  	echo $this->$function[0]->$function[1]($function[2],$function[3],$function[4]);
      }
	  
	//Funcion para obtener los subgrupos en base a los grupos
   function get_provincia(){
        $LOC_PAIS=$this->input->post('pais');
		if(!empty($LOC_PAIS) and $LOC_PAIS<>null){
        $output = "";
        $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=2 
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_PAIS
										order by LOC_DESCRIPCION");
        $results = $query->result();
        $output .='<option value="">Provincia...</option>';
        foreach ($results as $result):
                $output .="<option value="."'".$result->LOC_SECUENCIAL."'".">".prepCampoMostrar($result->LOC_DESCRIPCION)."</option>";
        endforeach;
        echo $output;
		}else{
			$output = "";
			$output .='<option value="">Provincia...</option>';
			echo $output;
		}
   }
   
   //Funcion para obtener los subgrupos en base a los grupos
   function get_ciudad(){
        $LOC_PROVINCIA=$this->input->post('ciudad');
		if(!empty($LOC_PROVINCIA) and $LOC_PROVINCIA<>null){
        $output = "";
        $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=3 
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_PROVINCIA
										order by LOC_DESCRIPCION");
        $results = $query->result();
        $output .='<option value="">Ciudad...</option>';
        foreach ($results as $result):
                $output .="<option value="."'".$result->LOC_SECUENCIAL."'".">".prepCampoMostrar($result->LOC_DESCRIPCION)."</option>";
        endforeach;
        echo $output;
		}else{
			$output = "";
			$output .='<option value="">Ciudad...</option>';
			echo $output;
		}
   } 

//Funcion para obtener los subgrupos en base a los grupos
   function get_sector(){
        $LOC_CIUDAD=$this->input->post('sector');
		if(!empty($LOC_CIUDAD) and $LOC_CIUDAD<>null){
        $output = "";
        $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=4 
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_CIUDAD
										order by LOC_DESCRIPCION");
        $results = $query->result();
        $output .='<option value="">Sector...</option>';
        foreach ($results as $result):
                $output .="<option value="."'".$result->LOC_SECUENCIAL."'".">".prepCampoMostrar($result->LOC_DESCRIPCION)."</option>";
        endforeach;
        echo $output;
		}else{
			$output = "";
			$output .='<option value="">Sector...</option>';
			echo $output;
		}
   }    
   //Funcion para obtener los subgrupos en base a los grupos
function get_porcentaje(){
    $MATRICULA=$this->input->post('MATRICULA');
    $TOTAL=$this->input->post('TOTAL');
    if(!empty($MATRICULA) and !empty($TOTAL)){    
        $sqlAPORTEVALIDA="select (SELECT TIPCAL_PORCENTAJE 
                                    FROM TIPOCALIFICACION 
                                    WHERE TIPCAL_SEC_MATRICULA=APO_SEC_MATRICULA) TIPOCALIFICACION
                        from aportes WHERE APO_SEC_MATRICULA={$MATRICULA}";
        $totRequerido=$this->db->query($sqlAPORTEVALIDA)->row()->TIPOCALIFICACION;
        echo $totRequerido;
    }else{        
        echo "a";
    }
}
   
}
