<?php
class Mperxlic extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='PERXLIC_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
        
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"PERXLIC_SECUENCIAL",
											"(select LIC_NOMBRE from LICENCIA where LIC_SECUENCIAL=PERXLIC_SEC_LICENCIA) PERXLIC_SEC_LICENCIA",
											"(select CONCAT(CONCAT(PER_APELLIDOS,' '), PER_NOMBRES) from PERSONA where PER_SECUENCIAL=PERXLIC_SEC_PERSONA)PERXLIC_SEC_PERSONA",
											"PERXLIC_ESTADO");
			  $datos->campos = array( "ROWNUM",
										"PERXLIC_SECUENCIAL",
										"PERXLIC_SEC_LICENCIA",
										"PERXLIC_SEC_PERSONA",
										"PERXLIC_ESTADO");
			  $datos->tabla="PERSONAXLICENCIA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataPerxlic($numero){
       $sql="select
                PERXLIC_SECUENCIAL,
                PERXLIC_SEC_LICENCIA,
                PERXLIC_SEC_PERSONA,
                PERXLIC_ESTADO  
          FROM PERSONAXLICENCIA WHERE PERXLIC_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
                        PERXLIC_SECUENCIAL,
                        PERXLIC_SEC_LICENCIA,
                        PERXLIC_SEC_PERSONA,
                        PERXLIC_ESTADO  
          FROM PERSONAXLICENCIA WHERE PERXLIC_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrPerxlic(){	
			//VARIABLES DE INGRESO
            $PERXLIC_SEC_LICENCIA=$this->input->post('licencia');
            $PERXLIC_SEC_PERSONA=$this->input->post('persona');	

            //validación...
			$sqlREPETICION="select count(*) NUM_PERSONAXLICENCIA 
                from personaxlicencia
                where upper(perxlic_sec_persona)=upper('{$PERXLIC_SEC_PERSONA}') 
                and perxlic_estado=0";
            $NUM_PERSONAXLICENCIA=$this->db->query($sqlREPETICION)->row()->NUM_PERSONAXLICENCIA;

        if($NUM_PERSONAXLICENCIA==0){
				$sql="INSERT INTO PERSONAXLICENCIA (
							PERXLIC_SEC_LICENCIA,
                            PERXLIC_SEC_PERSONA,
                            PERXLIC_ESTADO) VALUES 
							('$PERXLIC_SEC_LICENCIA',
                            '$PERXLIC_SEC_PERSONA',
							0)";
            $this->db->query($sql);
            //print_r($sql);
			$PERXLIC_SECUENCIAL=$this->db->query("select max(PERXLIC_SECUENCIAL) SECUENCIAL from PERSONAXLICENCIA")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$PERXLIC_SECUENCIAL,"numero"=>$PERXLIC_SECUENCIAL,"mensaje"=>"Licencia: ".$PERXLIC_SECUENCIAL.", insertado con éxito"));    
    }else {
		echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Licencia Ya Se Encuentra ingresado...!!!"));
	}
 }
    
	//funcion para editar un registro selccionado
    function editPerxlic(){
			$PERXLIC_SECUENCIAL=$this->input->post('PERXLIC_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$PERXLIC_SEC_LICENCIA=$this->input->post('licencia');
            $PERXLIC_SEC_PERSONA=$this->input->post('persona');					

			
				$sql="UPDATE PERSONAXLICENCIA SET
							PERXLIC_SEC_LICENCIA='$PERXLIC_SEC_LICENCIA',
							PERXLIC_SEC_PERSONA='$PERXLIC_SEC_PERSONA'
                 WHERE PERXLIC_SECUENCIAL=$PERXLIC_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$PERXLIC_SECUENCIAL,"mensaje"=>"Licencia: ".$PERXLIC_SECUENCIAL.", editado con éxito"));            
    }

}
?>