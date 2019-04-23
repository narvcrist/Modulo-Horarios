<div id="accordion">
  <h3>Cronograma</h3>
  
        <form id="fcronograma">
            <div id="cabecera">
            <table width="99%" id="tcronograma" class="formDialog">    
			
					<tr>
					    <th>
							Materia(*)
						</th>
                        <td>
						<?php echo $combo_materia; ?> 						
						</td>
					   
						<th>
							Aspirante(*)
						</th>
						<td>
						<?php echo $combo_aspirante; ?>  
						</td>
						
						<th>
							Descripción(*)
                        </th>
						<td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="CRO_DESCRIPCION" name="CRO_DESCRIPCION"> <?php echo (!empty($sol->CRO_DESCRIPCION))?prepCampoMostrar($sol->CRO_DESCRIPCION):null; ?>  </TEXTAREA> 
						</td>
                    </tr>
                    <tr>
						<th>
							Fecha de Inicio(*)
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="CRO_FECHAINICIO" id="CRO_FECHAINICIO" value="<?php echo !empty($sol->CRO_FECHAINICIO) ? prepCampoMostrar($sol->CRO_FECHAINICIO) : null ; ?>"  />
						</td>
						<th>
							Fecha de Finalización(*)
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="CRO_FECHAFIN" id="CRO_FECHAFIN" value="<?php echo !empty($sol->CRO_FECHAFIN) ? prepCampoMostrar($sol->CRO_FECHAFIN) : null ; ?>"  />
						</td>
					   			
					</tr>
					<tr>
						<th>
							Observaciones
						</th>
						<td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="CRO_OBSERVACIONES" name="CRO_OBSERVACIONES"> <?php echo (!empty($sol->CRO_OBSERVACIONES))?prepCampoMostrar($sol->CRO_OBSERVACIONES):null; ?>  </TEXTAREA> 
						</td>
					   
					</tr>

					<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Cronograma</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="CRO_SECUENCIAL" id="CRO_SECUENCIAL" value="<?php echo !empty($sol->CRO_SECUENCIAL) ? prepCampoMostrar($sol->CRO_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>