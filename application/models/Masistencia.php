    <?php
class Masistencia extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='AST_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
           /* if (!empty($numero)){
                  $datos->econdicion .=" AND AST_SECUENCIAL=$numero";              
				  */
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"AST_SECUENCIAL",
											"(SELECT CONCAT(CONCAT(CONCAT(CONCAT((CASE (SELECT COUNT(ASP_NOMBRE) FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
										WHEN 0 THEN 'SIN ASIGNACION'
										ELSE
										(SELECT ASP_NOMBRE FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
										END),'-'),
										(SELECT MAT_NOMBRE FROM MATERIA WHERE MAT_SECUENCIAL=MATR_SEC_MATERIA)),'-'),
										(SELECT CONCAT(CONCAT(CONCAT(JOR_NOMBRE,'('),JOR_PARALELO),')') JOR_DESCRIPCION FROM JORNADA 
										WHERE JOR_SECUENCIAL=MATR_SEC_JORNADA)) ASP_MAT_JOR
										FROM MATRICULA WHERE MATR_SECUENCIAL=AST_SEC_MATRICULA) AST_SEC_MATRICULA",
                                            "(SELECT CONCAT(CONCAT(PER_APELLIDOS,' '), PER_NOMBRES)
                                            FROM PERSONA 
                                            WHERE PER_SECUENCIAL = AST_SEC_PERSONA)
                                            AST_SEC_PERSONA",
											"AST_FECHAINGRESO",
											"AST_FECHASALIDA",
											"AST_RESPONSABLE",
											"AST_ESTADO");
			  $datos->campos = array( "ROWNUM",
                                      "AST_SECUENCIAL",
                                      "AST_SEC_MATRICULA",
                                      "AST_SEC_PERSONA",
                                      "AST_FECHAINGRESO",
                                      "AST_FECHASALIDA",
                                      "AST_RESPONSABLE",
                                      "AST_ESTADO");
			  $datos->tabla="ASISTENCIA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataAsistencia($numero){
	   $sql="select
            AST_SECUENCIAL,
            AST_SEC_MATRICULA,
            AST_SEC_PERSONA,
            AST_FECHAINGRESO,
            AST_FECHASALIDA,
            AST_RESPONSABLE,
            AST_ESTADO
          FROM ASISTENCIA WHERE AST_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
				      AST_SECUENCIAL,
                      AST_SEC_MATRICULA,
                      AST_SEC_PERSONA,
                      AST_FECHAINGRESO,
                      AST_FECHASALIDA,
                      AST_RESPONSABLE,
                      AST_ESTADO
                      FROM ASISTENCIA WHERE AST_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
						
          return $sol;
		}

	//funcion para crear un nuevo reporte o cabecera
    function agrAsistencia(){
			$sql="select to_char(SYSDATE,'DD/MM/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
           
            $AST_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
			//VARIABLES DE INGRESO
            $AST_SEC_MATRICULA=$this->input->post('matricula');
            $AST_SEC_PERSONA=$this->input->post('persona');						
			$FECHAINGRESO =prepCampoAlmacenar($this->input->post('AST_FECHAINGRESO'));	
            $AST_FECHAINGRESO="TO_DATE('".$FECHAINGRESO."','DD/MM/YYYY HH24:MI:SS')";
            $FECHASALIDA =prepCampoAlmacenar($this->input->post('AST_FECHASALIDA'));	
			$AST_FECHASALIDA="TO_DATE('".$FECHASALIDA."','DD/MM/YYYY HH24:MI:SS')";				
			
			if (!empty($FECHA_INICIO) and !empty($FECHA_FIN)){
				$AST_FECHAINICIO ="TO_DATE('$FECHA_INICIO 00:00:00', 'dd/mm/yy HH24:MI:SS')";
				$AST_FECHAFIN ="TO_DATE('$FECHA_FIN 23:59:59', 'dd/mm/yy HH24:MI:SS')";              
			}else{
				$AST_FECHAINICIO =null;
				$AST_FECHAFIN = null;
			}

            $sqlASISTENCIAVALIDA="select count(*) NUM_ASISTENCIA from asistencia
            WHERE ast_sec_persona='{$AST_SEC_PERSONA }'
            and ast_sec_matricula='{$AST_SEC_MATRICULA}'
            and AST_ESTADO=0";
			$NUM_ASISTENCIA =$this->db->query($sqlASISTENCIAVALIDA)->row()->NUM_ASISTENCIA ;
			if($NUM_ASISTENCIA ==0){

				$sql="INSERT INTO ASISTENCIA (
					  AST_SEC_MATRICULA,
                      AST_SEC_PERSONA,
                      AST_FECHAINGRESO,
                      AST_FECHASALIDA,
                      AST_RESPONSABLE,
                      AST_ESTADO) VALUES(
                            $AST_SEC_MATRICULA,
                            $AST_SEC_PERSONA,
                            $AST_FECHAINGRESO,
                            $AST_FECHASALIDA,
                            '$AST_RESPONSABLE',
						    0)";
        $this->db->query($sql);
        //print_r($sql);
        $AST_SECUENCIAL=$this->db->query("select max(AST_SECUENCIAL) SECUENCIAL from ASISTENCIA")->row()->SECUENCIAL;
        echo json_encode(array("cod"=>$AST_SECUENCIAL,"numero"=>$AST_SECUENCIAL,"mensaje"=>"Asistencia: ".$AST_SECUENCIAL.", insertado con éxito"));    
    }else{     
        echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El asistencia Ya Existe...!!!"));
    }
        
}
    
	//funcion para editar un registro selccionado
    function editAsistencia(){
			$AST_SECUENCIAL=$this->input->post('AST_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$AST_SEC_MATRICULA=$this->input->post('matricula');
            $AST_SEC_PERSONA=$this->input->post('persona');
			$FECHAINGRESO =prepCampoAlmacenar($this->input->post('AST_FECHAINGRESO'));			
            $AST_FECHAINGRESO="TO_DATE('".$FECHAINGRESO."','DD/MM/YYYY HH24:MI:SS')";
            $FECHASALIDA =prepCampoAlmacenar($this->input->post('AST_FECHASALIDA'));
            $AST_FECHASALIDA="TO_DATE('".$FECHASALIDA."','DD/MM/YYYY HH24:MI:SS')";		
            
				$sql="UPDATE ASISTENCIA SET
							AST_SEC_MATRICULA=$AST_SEC_MATRICULA,
                            AST_SEC_PERSONA=$AST_SEC_PERSONA,
							AST_FECHAINGRESO=$AST_FECHAINGRESO,
							AST_FECHASALIDA=$AST_FECHASALIDA
							WHERE AST_SECUENCIAL=$AST_SECUENCIAL";
		 $this->db->query($sql);

		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$AST_SECUENCIAL,"mensaje"=>"Asistencia: ".$AST_SECUENCIAL.", editado con éxito"));            

   }    
}
?>