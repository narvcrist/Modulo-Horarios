<div id="accordion">
  <h3>Ingrese Una Junta</h3>
  
        <form id="fjunta">
            <div id="cabecera">
            <table width="99%" id="tjunta" class="formDialog">   
        <tr>
						<th>
							<h5>Pais Junta</h5>
						</th>
						<td>
							<?php echo $combo_pais_junta; ?> 
						</td>
						<th>
							<h5> Provincia Junta</h5>
						</th>
						<td>
							<?php echo $combo_provincia_junta; ?> 
						</td>
						<th>
							<h5>Ciudad Junta</h5>
						</th>
						<td>
							<?php echo $combo_ciudad_junta; ?> 
						</td>
					</tr>
    	<tr>
						<th>
							Nombre(*)
						</th>
						<td>
                            <input type="text" maxlength="100" style="width:150px;" name="JUN_NOMBRE" id="JUN_NOMBRE" value="<?php echo !empty($sol->JUN_NOMBRE) ? prepCampoMostrar($sol->JUN_NOMBRE) : null ; ?>"  />
						</td>
		</tr>									
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Junta</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="JUN_SECUENCIAL" id="JUN_SECUENCIAL" value="<?php echo !empty($sol->JUN_SECUENCIAL) ? prepCampoMostrar($sol->JUN_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
