<div id="accordion">
  <h3>Ingrese Un Aspirante</h3>
  
        <form id="faspirante">
            <div id="cabecera">
            <table width="99%" id="taspirante" class="formDialog">    
			
					<tr>
					    <th>
							Carrera
						</th>
                        <td>
                            <input type="text" maxlength="99" style="width:100px;" name="ASP_NOMBRE" id="ASP_NOMBRE" value="<?php echo !empty($sol->ASP_NOMBRE) ? prepCampoMostrar($sol->ASP_NOMBRE) : null ; ?>"  />
						</td>

                        <th>
							Tiempo de duración
						</th>
                        <td>
                            <input type="number" max="99" min="0" step="1" style="width:100px;" name="ASP_NUM_TIEMPODURACION" id="ASP_NUM_TIEMPODURACION" value="<?php echo !empty($sol->ASP_NUM_TIEMPODURACION) ? prepCampoMostrar($sol->ASP_NUM_TIEMPODURACION) : null ; ?>"  />
						</td>

					   	<th>
							Observaciones
                        </th>
                        <td>
						<input type="text" maxlength="499" style="width:100px;" name="ASP_OBSERVACIONES" id="ASP_OBSERVACIONES" value="<?php echo !empty($sol->ASP_OBSERVACIONES) ? prepCampoMostrar($sol->ASP_OBSERVACIONES) : null ; ?>"  />
                        </td>
                    </tr>
              
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Ver
                                
                                
                                ifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Aspirante</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="ASP_SECUENCIAL" id="ASP_SECUENCIAL" value="<?php echo !empty($sol->ASP_SECUENCIAL) ? prepCampoMostrar($sol->ASP_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
