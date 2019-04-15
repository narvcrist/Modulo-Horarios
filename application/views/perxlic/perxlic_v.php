<div id="accordion">
  <h3>Ingrese Una Nose</h3>
  
        <form id="fperxlic">
            <div id="cabecera">
            <table width="100%" id="tperxlic" class="formDialog">    
			
					<tr>
					    <th>
							Licencia(*)
						</th>
                        <td>
						<?php echo $combo_licencia; ?>
						</td>
					   
						<th>
							Persona(*)
						</th>
                        <td>
						<?php echo $combo_persona; ?>
						</td>
						
                    </tr>
                    
					
						<?php if($accion=='n'|$accion=='e') : ?>                    
                            
                             <td align="center" colspan="6" class="noclass">
                                <button title="Verifique la información antes de guardar." id="co_grabar" type="submit" ><img src="./imagenes/guardar.png" width="17" height="17"/>Grabar Licencia</button>
                             </td>
                    
						<?php endif; ?>
						
                </table>
            </div>
            <input type="hidden"  name="PERXLIC_SECUENCIAL" id="PERXLIC_SECUENCIAL" value="<?php echo !empty($sol->PERXLIC_SECUENCIAL) ? prepCampoMostrar($sol->PERXLIC_SECUENCIAL) : 0 ; ?>"  />
        </form>
</div>
