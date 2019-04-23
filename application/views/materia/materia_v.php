<div id="accordion">
  <h3>Ingrese Una Materia</h3>
  
        <form id="fmateria">
            <div id="cabecera">
            <table width="99%" id="tmateria" class="formDialog">    
			
					<tr>
					    <th>
							Nombre Materia(*)
						</th>
                        <td>
						<?php echo $combo_materia; ?>
						</td>
					   
						<th>
							Nivel(*)
						</th>
						<td>
							<?php echo $combo_nivel; ?> 
						</td>
						
						<th>
							Fecha Inicio(*)
                        </th>
                        <td>
							<input type="text" style="width:100px;" name="MAT_HORA_INICIO" id="MAT_HORA_INICIO" value="<?php echo !empty($sol->MAT_HORA_INICIO) ? prepCampoMostrar($sol->MAT_HORA_INICIO) : null ;?>" /> 
                        </td>
						<th>
							Fecha Fin(*)
                        </th>
                        <td>
							<input type="text" style="width:100px;" name="MAT_HORA_FIN" id="MAT_HORA_FIN" value="<?php echo !empty($sol->MAT_HORA_FIN) ? prepCampoMostrar($sol->MAT_HORA_FIN) : null ;?>" /> 
                        </td>
                    </tr>
					<tr>
						<th>
							Carga Horaria(*)
                        </th>
                        <td>
							<input type="number" min="0" max="999" style="width:100px;" name="MAT_NUM_CARGAHORARIA" id="MAT_NUM_CARGAHORARIA" value="<?php echo !empty($sol->MAT_NUM_CARGAHORARIA) ? prepCampoMostrar($sol->MAT_NUM_CARGAHORARIA) : 0 ;?>" /> 
                        </td>
					   
						<th>
							Observacion
						</th>
						<td>
                            <input type="text" maxlength="99" style="width:100px;" name="MAT_OBSERVACION" id="MAT_OBSERVACION" value="<?php echo !empty($sol->MAT_OBSERVACION) ? prepCampoMostrar($sol->MAT_OBSERVACION) : null ; ?>"  />
						</td>
					</tr>
					
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Materia</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="MAT_SECUENCIAL" id="MAT_SECUENCIAL" value="<?php echo !empty($sol->MAT_SECUENCIAL) ? prepCampoMostrar($sol->MAT_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
