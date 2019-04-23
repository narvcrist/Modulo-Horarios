<?php
class Mlicencia extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='LIC_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
              
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"LIC_SECUENCIAL",
											"LIC_NOMBRE",
											"LIC_OBSERVACION",
											"LIC_ESTADO");
			  $datos->campos = array( "ROWNUM",
										"LIC_SECUENCIAL",
										"LIC_NOMBRE",
										"LIC_OBSERVACION",
										"LIC_ESTADO");
			  $datos->tabla="LICENCIA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataLicencia($numero){
       $sql="select
			LIC_SECUENCIAL,
			LIC_NOMBRE,
			LIC_OBSERVACION,
			LIC_ESTADO   
          FROM LICENCIA WHERE LIC_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
						LIC_SECUENCIAL,
						LIC_NOMBRE,
						LIC_OBSERVACION,
						LIC_ESTADO			
                        FROM LICENCIA WHERE LIC_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrLicencia(){	
			//VARIABLES DE INGRESO
			$LIC_NOMBRE=prepCampoAlmacenar($this->input->post('licencia'));
			$LIC_OBSERVACION=prepCampoAlmacenar($this->input->post('LIC_OBSERVACION'));		
				
			//validación...
			$sqlREPETICION="select count(*) NUM_LICENCIA 
				from licencia
				where upper(lic_nombre)=upper('{$LIC_NOMBRE}') 
				and lic_estado=0";
			$NUM_LICENCIA=$this->db->query($sqlREPETICION)->row()->NUM_LICENCIA;

			if($NUM_LICENCIA==0){

				$sql="INSERT INTO LICENCIA (
							LIC_NOMBRE,
							LIC_OBSERVACION,
							LIC_ESTADO) VALUES 
							('$LIC_NOMBRE',
							'$LIC_OBSERVACION',
							0)";
            $this->db->query($sql);
            //print_r($sql);
			$LIC_SECUENCIAL=$this->db->query("select max(LIC_SECUENCIAL) SECUENCIAL from LICENCIA")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$LIC_SECUENCIAL,"numero"=>$LIC_SECUENCIAL,"mensaje"=>"Licencia: ".$LIC_SECUENCIAL.", insertado con éxito"));    
    }else {
		echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Licencia Ya Se Encuentra ingresada...!!!"));
	}
 }
    
	//funcion para editar un registro selccionado
    function editLicencia(){
			$LIC_SECUENCIAL=$this->input->post('LIC_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$LIC_NOMBRE=$this->input->post('licencia');
			$LIC_OBSERVACION=prepCampoAlmacenar($this->input->post('LIC_OBSERVACION'));				

			
				$sql="UPDATE LICENCIA SET
							LIC_NOMBRE='$LIC_NOMBRE',
							LIC_OBSERVACION='$LIC_OBSERVACION'
                 WHERE LIC_SECUENCIAL=$LIC_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$LIC_SECUENCIAL,"mensaje"=>"Licencia: ".$LIC_SECUENCIAL.", editado con éxito"));            
    }

}
?>