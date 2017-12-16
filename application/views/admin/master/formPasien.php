	<form id="form_pasien" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='kode_pasien' id='kode_pasien' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value=""/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>NIP</td>
						<td >
							<input name='nip' id='nip' required="true" class='easyui-validatebox textbox'   style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama</td>
						<td >
							<input name='nama' id='nama' class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Bagian</td>
						<td >
							<input name='bagian' id='bagian' class='easyui-validatebox textbox'   style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Alamat</td>
						<td >
							<textarea cols='40' rows='3' name='alamat' id='alamat' 
							style='padding:3px;width:90%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Telp</td>
						<td >
							<input name='telp' id='telp' type="number" class='easyui-validatebox textbox' required="true"  style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Email</td>
						<td >
							<input name='email' id='email' class='easyui-validatebox textbox'   style="padding:3px;width:90%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Gender</td>
						<td >
						    <select required="true" class="easyui-combobox" name='gender' id='gender' style="width:93%;">
						        <option value="F">Female</option>
						        <option value="M">Male</option>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Alergi</td>
						<td >
							<input name='alergi' id='alergi' class='easyui-validatebox textbox'   style="padding:3px;width:90%"/>
						</td>
					</tr>
					
					<tr>
							<td class='label_form'>Tanggal Lahir</td>
							<td >
								<input name='tgl_lahir' id='tgl_lahir' class='easyui-datebox' style="padding:3px;width:93%"/>	
							</td>
						</tr>
                    <tr>
						<td class='label_form'>Status Pasien</td>
                        <td>
							<input name='id_status_pasien' id='id_status_pasien' class='easyui-combobox' required="true"  style="padding:3px;width:93%" data-options="
                                        url:'<?php echo base_url();?>index.php/pasien/getStatus',
                                        valueField:'id_status_pasien',
                                        textField:'status_pasien'
                                        
                                        "/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Penanggung Jawab</td>
						<td>
						<select name='penanggung_jawab' id='penanggung_jawab' class="easyui-combobox" style="width:94%" data-options="
			                    url:'<?php echo base_url();?>index.php/pasien/getPenanggung',
			                    valueField:'nip',
                                textField:'full_name',
			                ">
			            </select>
						</td>
					</tr>
                        
			</table>
		</form>
	
	