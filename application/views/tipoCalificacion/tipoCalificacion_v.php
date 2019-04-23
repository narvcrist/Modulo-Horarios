<div id="accordion">
  <h3>Ingrese Una Calificacion</h3>
  
        <form id="ftipoCalificacion">
            <div id="cabecera">
            <table width="99%" id="ttipoCalificacion" class="formDialog">    
			
					<tr>
					    <th>
							Matricula(*)
						</th>
                        <td colspan=6>
						<?php echo $combo_matricula; ?>
						</td>
					</tr>
					<tr>
					
						<th>
							Fecha Inicio(*)
						</th>
						<td> 
						<input type="text" style="width:100px;" name="TIPCAL_FECHAINICIO" id="TIPCAL_FECHAINICIO" value="<?php echo !empty($sol->TIPCAL_FECHAINICIO) ? prepCampoMostrar($sol->TIPCAL_FECHAINICIO) : null ;?>" /> 
							</td>
						<th>
							Fecha Fin(*)
						</th>
						<td>       
						<input type="text" style="width:100px;" name="TIPCAL_FECHAFIN" id="TIPCAL_FECHAFIN" value="<?php echo !empty($sol->TIPCAL_FECHAFIN) ? prepCampoMostrar($sol->TIPCAL_FECHAFIN) : null ;?>" /> 
						</td>
						<th>
							Porcentaje
						</th>
						<td>
						<input type="number" min="0" max="100" style="width:100px;" name="TIPCAL_PORCENTAJE" id="TIPCAL_PORCENTAJE" value="<?php echo !empty($sol->TIPCAL_PORCENTAJE) ? prepCampoMostrar($sol->TIPCAL_PORCENTAJE) : 0 ;?>" /> 
						</td>
					</tr>
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Calificacion</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="TIPCAL_SECUENCIAL" id="TIPCAL_SECUENCIAL" value="<?php echo !empty($sol->TIPCAL_SECUENCIAL) ? prepCampoMostrar($sol->TIPCAL_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
