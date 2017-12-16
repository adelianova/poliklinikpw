	<form id="form_dokter" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='kode_dokter' id='kode_dokter' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['kode_dokter'];?>"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama</td>
						<td >
							<input name='nama_dokter' id='nama_dokter' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Alamat</td>
						<td >
							<textarea cols='40' rows='3' name='alamat_dokter' id='alamat_dokter' 
							style='padding:3px;width:90%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Telp</td>
						<td >
							<input name='telp' id='telp' type="number" class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr><tr>
						<td class='label_form'>Email</td>
						<td >
							<input name='email' id='email' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Spesialisasi</td>
						<td >
							<input name='spesialisasi' id='spesialisasi' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Keterangan</td>
						<td >
							<textarea cols='40' rows='3' name='keterangan' id='keterangan' 
							style='padding:3px;width:90%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					
			</table>
		</form>
	
	