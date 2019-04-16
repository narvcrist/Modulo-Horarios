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
	
	//combo para obtener sectOres
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
//combo para obtener 0
function cmb_persona($PER_SECUENCIAL = null, $attr = null){		
	$sql = "select PER_SECUENCIAL,PER_APELLIDOS,PER_NOMBRES,PER_CEDULA 
			from PERSONA 
			where PER_ESTADO=0 
			order by PER_APELLIDOS ASC";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "Persona...";
		foreach ($results as $result) {
			$output[$result['PER_SECUENCIAL']] = utf8_encode($result['PER_APELLIDOS'])." ".utf8_encode($result['PER_NOMBRES'])." -- ".utf8_encode($result['PER_CEDULA']);
		}
		return form_dropdown('persona', $output, $PER_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee Personas. <input type='hidden' name='persona' value='' />");
	}
}

//combo para obtener Matriculas
function cmb_matricula($MATR_SECUENCIAL = null, $attr = null){
		
	$sql = "SELECT MATR_SECUENCIAL,(CASE (SELECT COUNT(ASP_NOMBRE) FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
					WHEN 0 THEN 'SIN ASIGNACION'
					ELSE
			(SELECT ASP_NOMBRE FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
					END) ASPIRANTE,
			(SELECT MAT_NOMBRE FROM MATERIA WHERE MAT_SECUENCIAL=MATR_SEC_MATERIA) MATERIA,
			(SELECT CONCAT(CONCAT(CONCAT(JOR_NOMBRE,'('),JOR_PARALELO),')') JOR_DESCRIPCION FROM JORNADA WHERE JOR_SECUENCIAL=MATR_SEC_JORNADA) JORNADA
			FROM MATRICULA";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "Matricula...";
		foreach ($results as $result) {
          	$output[$result['MATR_SECUENCIAL']] = utf8_encode($result['ASPIRANTE'])."  ".utf8_encode($result['MATERIA'])." -- ".utf8_encode($result['JORNADA']);
		}
		return form_dropdown('matricula', $output, $MATR_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee Matricula. <input type='hidden' name='matricula' value='' />");
	}
} 
//combo para obtener Tipo calificacion
function cmb_tipocalificacion($TIPCAL_SECUENCIAL = null, $attr = null){		
	$sql = "select TIPCAL_SECUENCIAL,TIPCAL_PORCENTAJE 
			from TIPOCALIFICACION 
			where TIPCAL_ESTADO=0";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "TipoCalificacion...";
		foreach ($results as $result) {
			$output[$result['TIPCAL_SECUENCIAL']] = utf8_encode($result['TIPCAL_PORCENTAJE']);
		}
		return form_dropdown('tipocalificacion', $output, $TIPCAL_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee Calificaciones. <input type='hidden' name='tipocalificacion' value='' />");
	}
}
//combo para obtener juntas
function cmb_junta($JUN_SECUENCIAL = null, $attr = null){
		
	$sql = "select JUN_SECUENCIAL,JUN_NOMBRE 
			from JUNTA 
			WHERE JUN_ESTADO=0 
			ORDER BY JUN_NOMBRE ASC";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "Junta...";
		foreach ($results as $result) {
			$output[$result['JUN_SECUENCIAL']] = utf8_encode($result['JUN_NOMBRE']);
		}
		return form_dropdown('junta', $output, $JUN_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee Juntas. <input type='hidden' name='junta' value='' />");
	}
}	
//combo para obtener licencias
function cmb_licencia($LIC_SECUENCIAL = null, $attr = null){
		
	$sql = "select LIC_SECUENCIAL,LIC_NOMBRE 
			from LICENCIA 
			WHERE LIC_ESTADO=0
			ORDER BY LIC_NOMBRE ASC";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "Licencia...";
		foreach ($results as $result) {
			$output[$result['LIC_SECUENCIAL']] = utf8_encode($result['LIC_NOMBRE']);
		}
		return form_dropdown('licencia', $output, $LIC_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee licencias. <input type='hidden' name='licencia' value='' />");
	}
}
//combo para obtener Aspirantes
function cmb_aspirante($ASP_SECUENCIAL = null, $attr = null){
		
	$sql = "select ASP_SECUENCIAL,ASP_NOMBRE,ASP_NUM_TIEMPODURACION
			from ASPIRANTE
			WHERE ASP_ESTADO=0 
			ORDER BY ASP_NOMBRE ASC";
	$results = $this->db->query($sql)->result_array();
	$output = array();
	if (count($results) > 0) {
		$output[null] = "Aspirante...";
		foreach ($results as $result) {
			$output[$result['ASP_SECUENCIAL']] = utf8_encode($result['ASP_NOMBRE'])." - ".utf8_encode($result['ASP_NUM_TIEMPODURACION']);
		}
		return form_dropdown('aspirante', $output, $ASP_SECUENCIAL, $attr);
   } else {
		return alerta("No Posee Aspitantes. <input type='hidden' name='aspirante' value='' />");
	}
}

}
?>
