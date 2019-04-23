<div id="accordion">
  <h3>Ingrese Una Asistencia</h3>

        <form id="fasistencia">
            <div id="cabecera">
            <table width="99%" id="tasistencia" class="formDialog">    
					<tr>
					<th>
							Matricula(*)
						</th>
                        <td>
					

						<?php echo $combo_matricula; ?>
												</td>
						<th>
							SECUENCIAL PERSONA (*)
						</th>
                        <td>
					
						<?php echo $combo_persona; ?>
						</td>
					    <th>
							Fecha Ingreso(*)
						</th>
                        <td>
						<input type="text" style="width:100px;" name="AST_FECHAINGRESO" id="AST_FECHAINGRESO" value="<?php echo !empty($sol->AST_FECHAINGRESO) ? prepCampoMostrar($sol->AST_FECHAINGRESO) : null ;?>" /> 		
						</td>
						<th>
							Fecha Salida(*)
						</th>
						<td> 
						<input type="text" style="width:100px;" name="AST_FECHASALIDA" id="AST_FECHASALIDA" value="<?php echo !empty($sol->AST_FECHASALIDA) ? prepCampoMostrar($sol->AST_FECHASALIDA) : null ;?>" /> 
							</td>
					</tr>
					<?php if($accion=='n'|$accion=='e') : ?>                    
                                <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Asistencia</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="AST_SECUENCIAL" id="AST_SECUENCIAL" value="<?php echo !empty($sol->AST_SECUENCIAL) ? prepCampoMostrar($sol->AST_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
