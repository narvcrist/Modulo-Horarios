
<div id="accordion">
	<h3>Ingrese Una matricula</h3>
	
			<form id="fmatricula">
				<div id="cabecera">
				<table width="99%" id="tmatricula" class="formDialog">    
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
							Jornada(*)
							</th>
							<td>
						
							<?php echo $combo_jornada; ?>							</td>
							</tr>
							<th>
								Persona(*)
							</th>
							<td>
						
							<?php echo $combo_persona; ?> 
							</td>

							<th>
								Fecha Inicio(*)
							</th>
							<td> 
							<input type="text" style="width:100px;" name="MATR_FECHAINGRESO" id="MATR_FECHAINGRESO" value="<?php echo !empty($sol->MATR_FECHAINGRESO) ? prepCampoMostrar($sol->MATR_FECHAINGRESO) : null ;?>" /> 
								</td>
						</tr>
						</tr>
							<?php if($accion=='n'|$accion=='e') : ?>                    
								
								<td align="center" colspan="6" class="noclass">
									<button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Matricula</button>
								</td>
						
							<?php endif; ?>
							
					</table>
				</div>
				<input type="hidden"  name="MATR_SECUENCIAL" id="MATR_SECUENCIAL" value="<?php echo !empty($sol->MATR_SECUENCIAL) ? prepCampoMostrar($sol->MATR_SECUENCIAL) : 0 ; ?>"  />
			</form>
	</div>
