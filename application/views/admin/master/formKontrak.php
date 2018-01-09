	<form id="form_kontrak" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td >
							<input name='id_kontrak' id='id_kontrak' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['id_kontrak'];?>"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama Dokter</td>
						<td>
						<select name='kode_dokter' id='kode_dokter' required="true" class="easyui-combobox" style="padding:3px;width:90%" data-options="
			                    url:'<?php echo base_url();?>index.php/kontrak/getKodeDokter',
			                    valueField:'kode_dokter',
                                textField:'nama_dokter',
			                ">
			            </select>
						</td>
					</tr>
					<tr>
							<td class='label_form'>Nomor Kontrak</td>
							<td>
							<input name='nomor' id='nomor'  required="true"  
							class='easyui-validatebox textbox' style="padding:3px;width:87%" />	
							</td>
					</tr>
					<tr>

						<td class='label_form'>Mulai Kontrak</td>
						<td >
							<input name='mulai_kontrak' id='mulai_kontrak' class='easyui-datebox' style="padding:3px;width:90%"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Selesai Kontrak</td>
						<td >
							<input name='selesai_kontrak' id='selesai_kontrak' class='easyui-datebox' style="padding:3px;width:90%"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Keterangan</td>
						<td >
							<textarea cols='40' rows='3' name='keterangan' id='keterangan' 
							style='padding:3px;width:86.7%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					
			</table>
		</form>
	
	