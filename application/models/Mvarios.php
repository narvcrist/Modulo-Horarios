<?php
class Mvarios extends CI_Model {
	
//Funcion para eliminar carpetas con su contenido	
	function eliminarDir($carpeta){
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
			{
			echo $archivos_carpeta; 
				if (is_dir($archivos_carpeta)){
					eliminarDir($archivos_carpeta);
				}else{
					unlink($archivos_carpeta);
				}
			} 
		rmdir($carpeta);
		}

	//combo para obtener usuarios
    function cmb_usuario($US_SECUENCIAL = null,$accion=null, $attr = null){
		if($accion=='n'){
				$sql = "select US_SECUENCIAL, US_CODIGO from usuario WHERE US_ESTADO=0 and us_secuencial not in (select FD_USUARIO from fondos where fd_estado=0)";
			}else{
				$sql = "select US_SECUENCIAL, US_CODIGO from usuario WHERE US_ESTADO=0";
			}        
		$results = $this->db->query($sql)->result_array();
        $output = array();
        if (count($results) > 0) {
            $output[null] = "Usuario...";
            foreach ($results as $result) {
                $output[$result['US_SECUENCIAL']] = $result['US_SECUENCIAL']."-".utf8_encode($result['US_CODIGO']);
            }
            return form_dropdown('usuario', $output, $US_SECUENCIAL, $attr);
       } else {
            return alerta("No Existen Usuarios... <input type='hidden' name='usuario' value='' />");
        }
    }

	//combo para obtener paises
    function cmb_pais($LOC_SECUENCIAL = null, $attr = null){
		
        $sql = "select LOC_SECUENCIAL, LOC_DESCRIPCION 
				FROM ISTCRE_APLICACIONES.LOCALIZACION 
				WHERE LOC_NIVEL=1 
				AND LOC_ESTADO=0 
				order by LOC_DESCRIPCION";
        $results = $this->db->query($sql)->result_array();
        $output = array();
        if (count($results) > 0) {
            $output[null] = "País...";
            foreach ($results as $result) {
                $output[$result['LOC_SECUENCIAL']] = utf8_encode($result['LOC_DESCRIPCION']);
            }
            return form_dropdown('pais', $output, $LOC_SECUENCIAL, $attr);
       } else {
            return alerta("No Posee Paises. <input type='hidden' name='pais' value='' />");
        }
    }
	
	//combo para obtener las provincias
	function cmb_provincia($LOC_SECUENCIAL = null, $LOC_PAIS = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PAIS == null)) {
            $output[null] = "Provincia...";
            return form_dropdown('provincia', $output, $LOC_SECUENCIAL, $attr);
        } else {
            $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=2 
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_PAIS
										order by LOC_DESCRIPCION");
            $results = $query->result_array();
            $output = array();
            if ($query->num_rows() > 0) {
                foreach ($results as $result) {
                    $output[null] = "Provincia...";
                    $output[$result['LOC_SECUENCIAL']] = utf8_encode($result['LOC_DESCRIPCION']);
                }
                return form_dropdown('provincia', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Provincias. <input type='hidden' name='provincia' value='' />");
            }
		}
	}
	
	//combo para obtener las ciudades
	function cmb_ciudad($LOC_SECUENCIAL = null, $LOC_PROVINCIA = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_PROVINCIA == null)) {
            $output[null] = "Ciudad...";
            return form_dropdown('ciudad', $output, $LOC_SECUENCIAL, $attr);
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
                return form_dropdown('ciudad', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Ciudades. <input type='hidden' name='ciudad' value='' />");
            }
		}
	}
	
	//combo para obtener sectpres
	function cmb_sector($LOC_SECUENCIAL = null, $LOC_CIUDAD = null,$attr = null){
        if (($LOC_SECUENCIAL == null) and ($LOC_CIUDAD == null)) {
            $output[null] = "Sector...";
            return form_dropdown('sector', $output, $LOC_SECUENCIAL, $attr);
        } else {
            $query = $this->db->query("select LOC_SECUENCIAL, LOC_DESCRIPCION 
										FROM ISTCRE_APLICACIONES.LOCALIZACION 
										where LOC_NIVEL=4
										AND LOC_ESTADO=0 
										AND LOC_PREDECESOR=$LOC_CIUDAD
										order by LOC_DESCRIPCION");
            $results = $query->result_array();
            $output = array();
            if ($query->num_rows() > 0) {
                foreach ($results as $result) {
                    $output[null] = "Sector...";
                    $output[$result['LOC_SECUENCIAL']] = utf8_encode($result['LOC_DESCRIPCION']);
                }
                return form_dropdown('sector', $output, $LOC_SECUENCIAL, $attr);
            } else {
                return alerta("No Posee Sectores. <input type='hidden' name='sector' value='' />");
            }
		}
	}
	
	//Funcion para pais
	function pais($provincia=null){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=2 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$provincia";
		$pais=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $pais;
	}
	
	//Funcion para provincia
	function provincia($ciudad=null){
		$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION 
		where LOC_NIVEL=3 
		AND LOC_ESTADO=0 
		AND LOC_SECUENCIAL=$ciudad";
		$provincia=$this->db->query($SQL)->row()->LOC_PREDECESOR;
		return $provincia;
	}
	
	//funcion para ciudad
	function ciudad($sector=null){
			$SQL="select LOC_PREDECESOR FROM ISTCRE_APLICACIONES.LOCALIZACION  
			where LOC_NIVEL=4 
			AND LOC_ESTADO=0 
			AND LOC_SECUENCIAL=$sector";
			$ciudad=$this->db->query($SQL)->row()->LOC_PREDECESOR;
			return $ciudad;
		}
  	
function VerificarCorreo($direccion){
			$Sintaxis='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
				if(preg_match($Sintaxis,$direccion)){
					return 0;
				}else{
					return 1;
				}
		}	
	
}
?>
