	<form id="form_registrasi" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<div style="float: left; width: 200px;height: 80%;">
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='kode_registrasi' id='kode_registrasi' readonly='true' 
							class='easyui-validatebox textbox' style='padding:3px;width:90%' type="hidden" value='<?php echo $data['kode_registrasi'];?>'/>	
						</td>
					</tr>
					<tr>
						<td>
							<input name='tgl_registrasi' id='tgl_registrasi' readonly='true' class='easyui-validatebox textbox' type="hidden" style='padding:3px;width:90%'/>	
						</td>
					</tr> 

					<tr>
						<td class='label_form'>Pasien</td>
						<td>
						<select name='kode_pasien' id='kode_pasien' required="true" class="easyui-combogrid" style="padding:3px;width:98%" data-options="
			                    panelWidth: 220,
			                    idField: 'kode_pasien',
			                    url:'<?php echo base_url();?>index.php/registrasi/getIDPasien',
			                    method: 'post',
			                    valueField:'kode_pasien',
                                textField:'nama',
                                mode:'remote',
                                fitColumns:'true',
			                    columns: [[
				                        {field:'kode_pasien',title:'Kode Pasien',width:70,hidden:'true'},
				                        {field:'nip',title:'NIP',width:80},
				                        {field:'nama',title:'Nama',width:120,align:'left'},
                    			]]
			                ">
			            </select>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Keluhan</td>
						<td >
							<input name='keluhan' id='keluhan' type="text" class='easyui-validatebox textbox' required="true"  style="padding:3px;width:95%"/>
						</td>
					</tr>
                   
                    <tr>
						<td class='label_form'>Status Registrasi</td>
                        <td>
							<input name='id_status_registrasi' id='id_status_registrasi' class='easyui-combobox' required="true"  style="padding:3px;width:230px" data-options="
                                        url:'<?php echo base_url();?>index.php/registrasi/getStatus',
                                        valueField:id_status_registrasi,
                                        textField:'id_status_registrasi',
                                        onLoadSuccess : function(){
						                                        $(this).combobox('select','Antri');
						                                        }
                                        "/>
						</td>
					</tr>
			</table>
		</div>
		<div>
			<div id="ini" style="float: right;">
			<input readonly="true" type="number" name="antrian" id="antrian" class="standalone2" style="
					padding: 10px;
				    font-family: inherit;
				    margin-top: 11px;
				    margin-left: 100px;
				    width: 25px;
				    color: white;
				    height: 27px;
				    background-color: skyblue;
				    font-size: 20px;
				    border-radius: 10px 10px 10px 10px;
				    -moz-border-radius: 10px 10px 10px 10px;
				    -webkit-border-radius: 10px 10px 10px 10px;
				    border-color: #2c6dd6;
				    padding-left: 23px;" 
				    value="<?php
				    	if($status=="new"){
				    		echo $antrian;
				    	} else{
				    		echo "";
				    	}
				      ?>">

				</div>
			</div>
		</form>	
