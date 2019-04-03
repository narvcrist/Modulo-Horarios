<div id="accordion">
  <h3>Ingrese un horario</h3>
  
        <form id="fhorario">
            <div id="cabecera">
            <table width="99%" id="thorario" class="formDialog">    
			
					<tr> 
						<th>
							Hora Inicio(*)
						</th>
						<td>
						<input type="text" style="width:100px;" name="HOR_HORA_INICIO" id="HOR_HORA_INICIO" value="<?php echo !empty($sol->HOR_HORA_INICIO) ? prepCampoMostrar($sol->HOR_HORA_INICIO) : null ;?>" /> 
						</td>
						<th>
							Hora fin(*)
                        </th>
                        <td>
						<input type="text" style="width:100px;" name="HOR_HORA_FIN" id="HOR_HORA_FIN" value="<?php echo !empty($sol->HOR_HORA_FIN) ? prepCampoMostrar($sol->HOR_HORA_FIN) : null ;?>" />  
                        </td>
                    </tr>
                    <tr>
						<th>
							Dia(*)
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="HOR_DIA" id="HOR_DIA" value="<?php echo !empty($sol->HOR_DIA) ? prepCampoMostrar($sol->HOR_DIA) : null ; ?>"  />
						</td>
						<th>
							Persona
						</th>
						<td>
                            <input type="text" maxlength="99" style="width:100px;" name="HOR_SEC_PERSONA" id="HOR_SEC_PERSONA" value="<?php echo !empty($sol->HOR_SEC_PERSONA) ? prepCampoMostrar($sol->HOR_SEC_PERSONA) : null ; ?>"  />
						</td>
						<th>
							Matricula
						</th>
                        <td>
                            <input type="number" min="0" max="999" style="width:100px;" name="HOR_SEC_MATRICULA" id="HOR_SEC_MATRICULA" value="<?php echo !empty($sol->HOR_SEC_MATRICULA) ? prepCampoMostrar($sol->HOR_SEC_MATRICULA) : 0 ;?>" />
						</td>				
					</tr>
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Horario</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="HOR_SECUENCIAL" id="HOR_SECUENCIAL" value="<?php echo !empty($sol->HOR_SECUENCIAL) ? prepCampoMostrar($sol->HOR_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
