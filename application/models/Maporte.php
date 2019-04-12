<?php
class Maporte extends CI_Model {
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='APO_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');    
              /*if (!empty($numero)){
                  $datos->econdicion .=" AND APO_SECUENCIAL=$numero";              
			  }*/
              $datos->campoId = "ROWNUM";
			  	 $datos->camposelect = array("ROWNUM",
										"APO_SECUENCIAL",
										"APO_FECHAINGRESO",
										"APO_SEC_MATRICULA",
										"(SELECT CONCAT(CONCAT(PER_NOMBRES,' '),PER_APELLIDOS) FROM PERSONA WHERE PER_SECUENCIAL=APO_SEC_PERSONA)
										 APO_SEC_PERSONA",
										"APO_SEC_TIPOCALIFICACION",
										"APO_NOTA1",
										"APO_NOTA2",
										"APO_NOTA3",
										"APO_NOTA4",
										"to_char(APO_FECHALIMITE, 'DD-MM-YYY HH24:MI:SS')APO_FECHALIMITE",
										"APO_RESPONSABLE_CREA",
										"APO_RESPONSABLE_EDITA",
										"APO_ESTADO"		   
										);
			  	 $datos->campos = array( "ROWNUM",
										"APO_SECUENCIAL",
										"APO_FECHAINGRESO",
										"APO_SEC_MATRICULA",
										"APO_SEC_PERSONA",
										"APO_SEC_TIPOCALIFICACION",
										"APO_NOTA1",
										"APO_NOTA2",
										"APO_NOTA3",
										"APO_NOTA4",
										"APO_FECHALIMITE",
										"APO_RESPONSABLE_CREA",
										"APO_RESPONSABLE_EDITA",
										"APO_ESTADO"
				  						);
			  $datos->tabla="APORTES";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataAporte($numero){
       			$sql="select
							APO_SECUENCIAL,
							APO_FECHAINGRESO,
							APO_SEC_MATRICULA,
							APO_SEC_PERSONA,
							APO_SEC_TIPOCALIFICACION,
							APO_NOTA1,
							APO_NOTA2,
							APO_NOTA3,
							APO_NOTA4,
							to_char(APO_FECHALIMITE, 'DD-MM-YYY HH24:MI:SS')APO_FECHALIMITE,
							APO_RESPONSABLE_CREA,
							APO_RESPONSABLE_EDITA,
							APO_ESTADO
          FROM APORTES WHERE APO_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
							APO_SECUENCIAL,
							APO_FECHAINGRESO,
							APO_SEC_MATRICULA,
							APO_SEC_PERSONA,
							APO_SEC_TIPOCALIFICACION,
							APO_NOTA1,
							APO_NOTA2,
							APO_NOTA3,
							APO_NOTA4,
							APO_FECHALIMITE,
							APO_RESPONSABLE_CREA,
							APO_RESPONSABLE_EDITA,
							APO_ESTADO
                          FROM APORTE WHERE APO_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
	//funcion para crear un nuevo reporte o cabecera
    function agrAporte(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
            $APO_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			//VARIABLES DE INGRESO			
			$APO_SEC_MATRICULA=$this->input->post('APO_SEC_MATRICULA');			
			$APO_SEC_PERSONA=$this->input->post('persona');			
			$APO_SEC_TIPOCALIFICACION=$this->input->post('APO_SEC_TIPOCALIFICACION');			
			$APO_NOTA1=$this->input->post('APO_NOTA1');			
			$APO_NOTA2=$this->input->post('APO_NOTA2');			
			$APO_NOTA3=$this->input->post('APO_NOTA3');			
			$APO_NOTA4=$this->input->post('APO_NOTA4');			
			$FECHALIMITE=prepCampoAlmacenar($this->input->post('APO_FECHALIMITE'));	
			$APO_FECHALIMITE="TO_DATE('".$FECHALIMITE."','DD/MM/YYYY HH24:MI:SS')";		
			$APO_RESPONSABLE_CREA=$this->session->userdata('US_CODIGO');
			$APO_RESPONSABLE_EDITA=$this->session->userdata('US_CODIGO');

			//VARIABLES DE RUTAS
			//$PER_ASIST_RUTA=NULL;
			//$PER_ASIST_RUTAANT=NULL;
			//$PER_DOCUM_RUTA=NULL;
			//$PER_DOCUM_RUTAANT=NULL;
			
				$sql="INSERT INTO APORTES (
							APO_FECHAINGRESO,
							APO_SEC_MATRICULA,
							APO_SEC_PERSONA,
							APO_SEC_TIPOCALIFICACION,
							APO_NOTA1,
							APO_NOTA2,
							APO_NOTA3,
							APO_NOTA4,
							APO_FECHALIMITE,
							APO_RESPONSABLE_CREA,
							APO_RESPONSABLE_EDITA,
							APO_ESTADO) VALUES (
							$APO_FECHAINGRESO,
							$APO_SEC_MATRICULA,
							$APO_SEC_PERSONA,
							$APO_SEC_TIPOCALIFICACION,
							$APO_NOTA1,
							$APO_NOTA2,
							$APO_NOTA3,
							$APO_NOTA4,
							$APO_FECHALIMITE,
							'$APO_RESPONSABLE_CREA',
							'$APO_RESPONSABLE_EDITA',
								0)";
            $this->db->query($sql);
            //print_r($sql);
			$APO_SECUENCIAL=$this->db->query("select max(APO_SECUENCIAL) SECUENCIAL from APORTES")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$APO_SECUENCIAL,"numero"=>$APO_SECUENCIAL,"mensaje"=>"Aportes: ".$APO_SECUENCIAL.", insertado con éxito"));    
    }
	//funcion para editar un registro selccionado
    function editAporte(){
			$APO_SECUENCIAL=$this->input->post('APO_SECUENCIAL');
			//VARIABLES DE INGRESO
			$APO_SEC_MATRICULA=$this->input->post('APO_SEC_MATRICULA');			
			$APO_SEC_PERSONA=$this->input->post('persona');			
			$APO_SEC_TIPOCALIFICACION=$this->input->post('APO_SEC_TIPOCALIFICACION');			
			$APO_NOTA1=$this->input->post('APO_NOTA1');			
			$APO_NOTA2=$this->input->post('APO_NOTA2');			
			$APO_NOTA3=$this->input->post('APO_NOTA3');			
			$APO_NOTA4=$this->input->post('APO_NOTA4');			
			$FECHALIMITE=prepCampoAlmacenar($this->input->post('APO_FECHALIMITE'));	
			$APO_FECHALIMITE="TO_DATE('".$FECHALIMITE."','DD/MM/YYYY HH24:MI:SS')";
			$APO_RESPONSABLE_EDITA=$this->session->userdata('US_CODIGO');				
			//VARIABLES DE RUTAS
			//$PER_ASIST_RUTA=NULL;
			//$PER_ASIST_RUTAANT=NULL;
			//$PER_DOCUM_RUTA=NULL;
			//$PER_DOCUM_RUTAANT=NULL;
				$sql="UPDATE APORTES SET
							APO_SEC_MATRICULA=$APO_SEC_MATRICULA,
							APO_SEC_PERSONA=$APO_SEC_PERSONA,
							APO_SEC_TIPOCALIFICACION=$APO_SEC_TIPOCALIFICACION,
							APO_NOTA1=$APO_NOTA1,
							APO_NOTA2=$APO_NOTA2,
							APO_NOTA3=$APO_NOTA3,
							APO_NOTA4=$APO_NOTA4,
							APO_FECHALIMITE=$APO_FECHALIMITE,
							APO_RESPONSABLE_EDITA='$APO_RESPONSABLE_EDITA'
                 WHERE APO_SECUENCIAL=$APO_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$APO_SECUENCIAL,"mensaje"=>"Aporte: ".$APO_SECUENCIAL.", editado con éxito"));            
	}
}
?>