	<form id="form_obat" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='kode_obat' id='kode_obat' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['kode_obat'];?>"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama</td>
						<td >
							<input name='nama' id='nama' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Satuan</td>
						<td >
							<input name='satuan' id='satuan' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
                    </tr>
					
			</table>
		</form>
	
	