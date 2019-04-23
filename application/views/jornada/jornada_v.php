<div id="accordion">
  <h3>Ingrese Una Jornada</h3>
  
        <form id="fjornada">
            <div id="cabecera">
            <table width="99%" id="tjornada" class="formDialog">    
			
					<tr>
					    <th>
							Jornada(*)
						</th>
                        <td>
                            <?php echo $combo_jornada; ?>
                        </td>
					   
						<th>
							Paralelo(*)
						</th>
						<td>
							<?php echo $combo_paralelo; ?> 
						</td>
                    </tr>
                    <tr>	
						<th>
							Hora Inicio(*)
                        </th>
                        <td>
							<input type="text" style="width:200px;" name="JOR_HORA_INICIO" id="JOR_HORA_INICIO" value="<?php echo !empty($sol->JOR_HORA_INICIO) ? prepCampoMostrar($sol->JOR_HORA_INICIO) : null ;?>" /> 
                        </td>
						<th>
							Hora Fin(*)
                        </th>
                        <td>
							<input type="text" style="width:200px;" name="JOR_HORA_FIN" id="JOR_HORA_FIN" value="<?php echo !empty($sol->JOR_HORA_FIN) ? prepCampoMostrar($sol->JOR_HORA_FIN) : null ;?>" /> 
                        </td>
                    </tr>
					
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Jornada</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="JOR_SECUENCIAL" id="JOR_SECUENCIAL" value="<?php echo !empty($sol->JOR_SECUENCIAL) ? prepCampoMostrar($sol->JOR_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
