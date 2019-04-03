<div id="accordion">
  <h3>Ingrese Una Persona</h3>
  
        <form id="fpersona">
            <div id="cabecera">
            <table width="99%" id="tpersona" class="formDialog">    
			
					<tr>
					    <th>
							Cedula(*)
						</th>
                        <td>
                            <input type="text" maxlength="15" style="width:100px;" name="PER_CEDULA" id="PER_CEDULA" value="<?php echo !empty($sol->PER_CEDULA) ? prepCampoMostrar($sol->PER_CEDULA) : null ; ?>"  />
						</td>
					   
						<th>
							Correo(*)
						</th>
						<td>
                            <input type="text" maxlength="100" style="width:150px;" name="PER_EMAIL" id="PER_EMAIL" value="<?php echo !empty($sol->PER_EMAIL) ? prepCampoMostrar($sol->PER_EMAIL) : null ; ?>"  />
						</td>
						
						<th>
							Estado Civil(*)
                        </th>
                        <td>
                          <?php echo $combo_civil; ?>  
                        </td>
                    </tr>
                    <tr>
						<th>
							Apellidos(*)
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="PER_APELLIDOS" id="PER_APELLIDOS" value="<?php echo !empty($sol->PER_APELLIDOS) ? prepCampoMostrar($sol->PER_APELLIDOS) : null ; ?>"  />
						</td>
					   
						<th>
							Nombres(*)
						</th>
						<td>
                            <input type="text" maxlength="99" style="width:100px;" name="PER_NOMBRES" id="PER_NOMBRES" value="<?php echo !empty($sol->PER_NOMBRES) ? prepCampoMostrar($sol->PER_NOMBRES) : null ; ?>"  />
						</td>
						<th>
							Genero(*)
                        </th>
                        <td>
                          <?php echo $combo_genero; ?>  
                        </td>				
					</tr>
					<tr>
						<th>
							Convencional
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="PER_CONVENCIONAL" id="PER_CONVENCIONAL" value="<?php echo !empty($sol->PER_CONVENCIONAL) ? prepCampoMostrar($sol->PER_CONVENCIONAL) : null ; ?>"  />
						</td>
					   
						<th>
							Celular
						</th>
						<td>
                            <input type="text" maxlength="99" style="width:100px;" name="PER_CELULAR" id="PER_CELULAR" value="<?php echo !empty($sol->PER_CELULAR) ? prepCampoMostrar($sol->PER_CELULAR) : null ; ?>"  />
						</td>
						<th>
							Junta
						</th>
                        <td>
                            <input type="number" min="0" max="999" style="width:100px;" name="PER_SEC_JUNTA" id="PER_SEC_JUNTA" value="<?php echo !empty($sol->PER_SEC_JUNTA) ? prepCampoMostrar($sol->PER_SEC_JUNTA) : 0 ;?>" />
						</td>
					</tr>
					<tr>
						<th>
							Alergias
                        </th>
                        <td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="PER_ALERGIAS" name="PER_ALERGIAS"> <?php echo (!empty($sol->PER_ALERGIAS))?prepCampoMostrar($sol->PER_ALERGIAS):null; ?>  </TEXTAREA> 
						</td>
					</tr>
					<tr>
						<th>
							Nombres Referencia(*)
						</th>
                        <td colspan=3>
                            <input type="text" maxlength="199" style="width:100px;" name="PER_NOMBRE_REFERENCIA" id="PER_NOMBRE_REFERENCIA" value="<?php echo !empty($sol->PER_NOMBRE_REFERENCIA) ? prepCampoMostrar($sol->PER_NOMBRE_REFERENCIA) : null ; ?>"  />
						</td>
					   
						<th>
							Teléfono Referencia
						</th>
						<td>
                            <input type="text" maxlength="19" style="width:100px;" name="PER_TELEFONO_REFERENCIA" id="PER_TELEFONO_REFERENCIA" value="<?php echo !empty($sol->PER_TELEFONO_REFERENCIA) ? prepCampoMostrar($sol->PER_TELEFONO_REFERENCIA) : null ; ?>"  />
						</td>
					</tr>
					<tr>
						<th>
							TÍtulo
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="PER_TITULO" id="PER_TITULO" value="<?php echo !empty($sol->PER_TITULO) ? prepCampoMostrar($sol->PER_TITULO) : null ; ?>"  />
						</td>
					   
						<th>
							Nivel Conducción
						</th>
						<td>
							<input type="number" min="0" max="999" style="width:100px;" name="PER_NIVEL_CONDUCCION" id="PER_NIVEL_CONDUCCION" value="<?php echo !empty($sol->PER_NIVEL_CONDUCCION) ? prepCampoMostrar($sol->PER_NIVEL_CONDUCCION) : 0 ;?>" />
						</td>
						<th>
							Tipo de Sangre
                        </th>
                        <td>
                          <?php echo $combo_tipoSangre; ?>  
                        </td>
					</tr>
					<th>
							<h5>Pais Estudios</h5>
						</th>
						<td>
							<?php echo $combo_pais_estudios; ?> 
						</td>
						<th>
							<h5> Provincia Estudios</h5>
						</th>
						<td>
							<?php echo $combo_provincia_estudios; ?> 
						</td>
						<th>
							<h5>Ciudad Estudios</h5>
						</th>
						<td>
							<?php echo $combo_ciudad_estudios; ?> 
						</td>
					<tr>
						<th>
							Dirección Estudios
                        </th>
                        <td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="PER_DIRECCION_ESTUDIO" name="PER_DIRECCION_ESTUDIO"> <?php echo (!empty($sol->PER_DIRECCION_ESTUDIO))?prepCampoMostrar($sol->PER_DIRECCION_ESTUDIO):null; ?>  </TEXTAREA> 
						</td>
					</tr>
					<tr>
						<th>
							Pais Residencia
						</th>
                        <td>
							<?php echo $combo_pais_residencia; ?> 
						</td>
						<th>
							<h5> Provincia Residencia</h5>
						</th>
						<td>
							<?php echo $combo_provincia_residencia; ?> 
						</td>
						<th>
							<h5>Ciudad Residencia</h5>
						</th>
						<td>
							<?php echo $combo_ciudad_residencia; ?> 
						</td>
						<tr>
						<th>
							Dirección Residencia
                        </th>
                        <td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="PER_DIRECCION_RSIDENCIA" name="PER_DIRECCION_RESIDENCIA"> <?php echo (!empty($sol->PER_DIRECCION_RESIDENCIA))?prepCampoMostrar($sol->PER_DIRECCION_RESIDENCIA):null; ?>  </TEXTAREA> 
						</td>
					</tr>
					<tr>
						<th>
							País Nacimiento
						</th>
						<td>
							<?php echo $combo_pais_nacimiento; ?> 
						</td>
						<th>
							<h5> Provincia Nacimiento</h5>
						</th>
						<td>
							<?php echo $combo_provincia_nacimiento; ?> 
						</td>
						<th>
							<h5>Ciudad Nacimiento</h5>
						</th>
						<td>
							<?php echo $combo_ciudad_nacimiento; ?> 
						</td>
						<tr>
						<th>
							Dirección Nacimiento
                        </th>
                        <td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="PER_DIRECCION_NACIMIENTO" name="PER_DIRECCION_NACIMIENTO"> <?php echo (!empty($sol->PER_DIRECCION_NACIMIENTO))?prepCampoMostrar($sol->PER_DIRECCION_NACIMIENTO):null; ?>  </TEXTAREA> 
						</td>
					</tr>
					<tr>
						<th>
							País Trabajo
						</th>
                        <td>
							<?php echo $combo_pais_trabajo; ?> 
						</td>
						<th>
							<h5> Provincia Trabajo</h5>
						</th>
						<td>
							<?php echo $combo_provincia_trabajo; ?> 
						</td>
						<th>
							<h5>Ciudad Trabajo</h5>
						</th>
						<td>
							<?php echo $combo_ciudad_trabajo; ?> 
						</td>
						<tr>
						<th>
							Dirección Trabajo
                        </th>
                        <td colspan=6>
                            <TEXTAREA maxlength="499" style="width:400px;" rows="1" cols="30" id="PER_DIRECCION_TRABAJO" name="PER_DIRECCION_TRABAJO"> <?php echo (!empty($sol->PER_DIRECCION_TRABAJO))?prepCampoMostrar($sol->PER_DIRECCION_TRABAJO):null; ?>  </TEXTAREA> 
						</td>
					</tr>
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Persona</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="PER_SECUENCIAL" id="PER_SECUENCIAL" value="<?php echo !empty($sol->PER_SECUENCIAL) ? prepCampoMostrar($sol->PER_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
