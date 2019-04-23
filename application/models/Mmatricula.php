<?php
class Mmatricula extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='MATR_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
           /* if (!empty($numero)){
                  $datos->econdicion .=" AND AST_SECUENCIAL=$numero";              
				  */
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
                                            "MATR_SECUENCIAL",
                                            "(SELECT MAT_NOMBRE
                                            FROM MATERIA
                                            WHERE MAT_SECUENCIAL = MATR_SEC_MATERIA)
                                            MATR_SEC_MATERIA",
                                            "(SELECT CONCAT(CONCAT(ASP_NOMBRE,' '), ASP_NUM_TIEMPODURACION)
                                            FROM ASPIRANTE 
                                            WHERE ASP_SECUENCIAL = MATR_SEC_ASPIRANTE)
                                            MATR_SEC_ASPIRANTE",
                                            "(SELECT JOR_NOMBRE
                                            FROM JORNADA
                                            WHERE JOR_SECUENCIAL = MATR_SEC_JORNADA)
                                            MATR_SEC_JORNADA",
                                            "(SELECT CONCAT(CONCAT(PER_APELLIDOS,' '), PER_NOMBRES)
                                            FROM PERSONA 
                                            WHERE PER_SECUENCIAL = MATR_SEC_PERSONA)
                                            MATR_SEC_PERSONA",
                                            "MATR_FECHAINGRESO",
                                            "MATR_RESPONSABLE",
                                            "MATR_ESTADO");
			  $datos->campos = array( "ROWNUM",
                                            "MATR_SECUENCIAL",
                                            "MATR_SEC_MATERIA",
                                            "MATR_SEC_ASPIRANTE",
                                            "MATR_SEC_JORNADA",
                                            "MATR_SEC_PERSONA",
                                            "MATR_FECHAINGRESO",
                                            "MATR_RESPONSABLE",
                                            "MATR_ESTADO");
			  $datos->tabla="MATRICULA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataMatricula($numero){
       $sql="select
                    MATR_SECUENCIAL,
                    MATR_SEC_MATERIA,
                    MATR_SEC_ASPIRANTE,
                    MATR_SEC_JORNADA,
                    MATR_SEC_PERSONA,
                    MATR_FECHAINGRESO,
                    MATR_RESPONSABLE,
                    MATR_ESTADO
          FROM MATRICULA WHERE MATR_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
                        MATR_SECUENCIAL,
                        MATR_SEC_MATERIA,
                        MATR_SEC_ASPIRANTE,
                        MATR_SEC_JORNADA,
                        MATR_SEC_PERSONA,
                        MATR_FECHAINGRESO,
                        MATR_RESPONSABLE,
                        MATR_ESTADO
                      FROM MATRICULA WHERE MATR_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
						
          return $sol;
		}

	//funcion para crear un nuevo reporte o cabecera
    function agrMatricula(){
			$sql="select to_char(SYSDATE,'DD/MM/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
           
            $MATR_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
            //VARIABLES DE INGRESO
            
            $MATR_SEC_MATERIA=$this->input->post('materia');
            $MATR_SEC_ASPIRANTE=$this->input->post('aspirante');
            $MATR_SEC_JORNADA=$this->input->post('jornada');
            $MATR_SEC_PERSONA=$this->input->post('persona');						
			$FECHAINGRESO =prepCampoAlmacenar($this->input->post('MATR_FECHAINGRESO'));	
            $MATR_FECHAINGRESO="TO_DATE('".$FECHAINGRESO."','DD/MM/YYYY HH24:MI:SS')";
         
            $sqlMATRICULAVALIDA="select count(*) NUM_MATRICULA from MATRICULA WHERE MATR_SEC_MATERIA='{$MATR_SEC_MATERIA }' and MATR_ESTADO=0";
			$NUM_MATRICULA =$this->db->query($sqlMATRICULAVALIDA)->row()->NUM_MATRICULA ;
			if($NUM_MATRICULA ==0){

				$sql="INSERT INTO MATRICULA (
                        MATR_SEC_MATERIA,
                        MATR_SEC_ASPIRANTE,
                        MATR_SEC_JORNADA,
                        MATR_SEC_PERSONA,
                        MATR_FECHAINGRESO,
                        MATR_RESPONSABLE,
                        MATR_ESTADO) VALUES(
                        $MATR_SEC_MATERIA,
                        $MATR_SEC_ASPIRANTE,
                        $MATR_SEC_JORNADA,
                        $MATR_SEC_PERSONA,
                        $MATR_FECHAINGRESO,
                        '$MATR_RESPONSABLE',  
						    0)";
              $this->db->query($sql);
              //print_r($sql);
              $MATR_SECUENCIAL=$this->db->query("select max(MATR_SECUENCIAL) SECUENCIAL from MATRICULA")->row()->SECUENCIAL;
              echo json_encode(array("cod"=>$MATR_SECUENCIAL,"numero"=>$MATR_SECUENCIAL,"mensaje"=>"Matricula: ".$MATR_SECUENCIAL.", insertado con éxito"));    
          }else{
              echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Matricula Ya Existe...!!!"));
          }
              
  }
	//funcion para editar un registro selccionado
    function editMatricula(){
            $MATR_SECUENCIAL=$this->input->post('MATR_SECUENCIAL');
            
			
			//VARIABLES DE INGRESO
            $MATR_SEC_MATERIA=$this->input->post('materia');
            $MATR_SEC_ASPIRANTE=$this->input->post('aspirante');
            $MATR_SEC_JORNADA=$this->input->post('jornada');
            $MATR_SEC_PERSONA=$this->input->post('persona');						
			$FECHAINGRESO =prepCampoAlmacenar($this->input->post('MATR_FECHAINGRESO'));	
            $MATR_FECHAINGRESO="TO_DATE('".$FECHAINGRESO."','DD/MM/YYYY HH24:MI:SS')";
           
				$sql="UPDATE MATRICULA SET

                                MATR_SEC_MATERIA=$MATR_SEC_MATERIA,
                                MATR_SEC_ASPIRANTE=$MATR_SEC_ASPIRANTE,
                                MATR_SEC_JORNADA=$MATR_SEC_JORNADA,
                                MATR_SEC_PERSONA=$MATR_SEC_PERSONA,
                                MATR_FECHAINGRESO=$MATR_FECHAINGRESO
							WHERE MATR_SECUENCIAL=$MATR_SECUENCIAL";
		 $this->db->query($sql);

		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$MATR_SECUENCIAL,"mensaje"=>"Matricula: ".$MATR_SECUENCIAL.", editado con éxito"));            

        }
}
?>