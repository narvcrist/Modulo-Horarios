<div id="accordion">
  <h3>Ingrese Un Aporte</h3>
  
        <form id="faporte">
            <div id="cabecera">
            <table width="99%" id="taporte" class="formDialog">    
			
					<tr>
						<th>
							Matricula
						</th>
                        <td colspan=6>
							<?php echo $combo_matricula; ?>	
						</td>
					</tr>
					<tr>										
						<th>
							Persona(*)
						</th>
						<td>
							<?php echo $combo_persona; ?>
						</td>
						
						<th>
							Tipo de Calificacion(*)
                        </th>
                        <td>
						<?php echo $combo_tipocalificacion; ?>
						</td>
                    </tr>
                    <tr>
						<th>
							NOTA 1(*)
						</th>
                        <td>
                            <input type="number" maxlength="99" style="width:90px;" name="APO_NOTA1" id="APO_NOTA1" value="<?php echo !empty($sol->APO_NOTA1) ? prepCampoMostrar($sol->APO_NOTA1) : 0 ; ?>"  />
						</td>
					   
						<th>
							NOTA 2(*)
						</th>
						<td>
                            <input type="number" maxlength="99" style="width:90px;" name="APO_NOTA2" id="APO_NOTA2" value="<?php echo !empty($sol->APO_NOTA2) ? prepCampoMostrar($sol->APO_NOTA2) : 0; ?>"  />
						</td>
						<th>
							NOTA 3(*)
                        </th>
                        <td>
                            <input type="number" maxlength="99" style="width:90px;" name="APO_NOTA3" id="APO_NOTA3" value="<?php echo !empty($sol->APO_NOTA3) ? prepCampoMostrar($sol->APO_NOTA3) : 0 ; ?>"  />
						</td>				
					</tr>
					<tr>
						<th>
							NOTA 4(*)
                        </th>
                        <td>
                            <input type="number" maxlength="99" style="width:90px;" name="APO_NOTA4" id="APO_NOTA4" value="<?php echo !empty($sol->APO_NOTA4) ? prepCampoMostrar($sol->APO_NOTA4) : 0 ; ?>"  />
						</td>
						<th>
							Fecha Limite
						</th>
                        <td>
						<input type="text" style="width:150px;" name="APO_FECHALIMITE" id="APO_FECHALIMITE" value="<?php echo !empty($sol->APO_FECHALIMITE) ? prepCampoMostrar($sol->APO_FECHALIMITE) : null ; ?>" />
						</td>
					</tr>
							
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Aporte</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="APO_SECUENCIAL" id="APO_SECUENCIAL" value="<?php echo !empty($sol->APO_SECUENCIAL) ? prepCampoMostrar($sol->APO_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
