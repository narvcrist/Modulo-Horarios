<div id="accordion">
  <h3>Ingrese Una Persona</h3>
  
        <form id="flicencia">
            <div id="cabecera">
            <table width="99%" id="tlicencia" class="formDialog">    
			
					<tr>
					    <th>
							Licencia(*)
						</th>
                        <td>
						<?php echo $combo_licencia; ?>
						</td>
					   
						<th>
							Observacion
						</th>
						<td>
                            <input type="text" maxlength="100" style="width:150px;" name="LIC_OBSERVACION" id="LIC_OBSERVACION" value="<?php echo !empty($sol->LIC_OBSERVACION) ? prepCampoMostrar($sol->LIC_OBSERVACION) : null ; ?>"  />
						</td>
						
                    </tr>
                    
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Licencia</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="LIC_SECUENCIAL" id="LIC_SECUENCIAL" value="<?php echo !empty($sol->LIC_SECUENCIAL) ? prepCampoMostrar($sol->LIC_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
