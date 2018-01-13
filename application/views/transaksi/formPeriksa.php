	<form id="form_periksa" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
							<td class='label_form'>Jenis Pemeriksaan</td>
								<td>
								<input name='jenis_periksa' id='id_jenis_periksa' class='easyui-combobox' required="true" style="padding:3px;width:218px" data-options="
			                                        url:'<?php echo base_url();?>index.php/periksa/getJenis',
			                                        valueField:'id_jenis_periksa',
			                                        textField:'jenis_periksa'
			                                        "/>
								</td>
							</td>
					</tr>
					<tr>
						<td class='label_form'>ID Periksa</td>
						<td>
						<select name='id_periksa' id='id_periksa' required="true" class="easyui-combogrid" style="padding:3px;width:90%" data-options="
			                    panelWidth: 220,
			                    idField: 'id_periksa',
			                    url:'<?php echo base_url();?>index.php/periksa/getIDPeriksa',
			                    method: 'get',
			                    valueField:'id_periksa',
                                textField:'nama',
			                    columns: [[
				                        {field:'id_periksa',title:'ID',width:70, hidden: 'true'},
				                        {field:'kode_pasien',title:'Kode Pasien',width:100},
				                        {field:'nama',title:'Nama',width:117,align:'left'}, 
				                        {field:'umur',title:'Umur',width:40,align:'left',hidden: 'true'},
				                        {field:'gender',title:'Gender',width:40,align:'left',hidden: 'true'},
				                        {field:'bagian',title:'Bagian',width:40,align:'left',hidden: 'true'},
				                        {field:'keluhan',title:'Keluhan',width:40,align:'left',hidden: 'true'},
				                        {field:'alergi',title:'Alergi',width:40,align:'left',hidden: 'true'},
                    			]],
                    			onSelect: function(index, row){
				        			$('#gender').val(row.gender);
				        			$('#umur').val(row.umur);
				        			$('#bagian').val(row.bagian);
				        			$('#keluhan').val(row.keluhan);
				        			$('#alergi').val(row.alergi);
				        		}
			                ">
			            </select>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Umur</td>
						<td >
						<input name='umur' id='umur' readonly='true' 
							class='easyui-validatebox textbox' style='padding:3px;width:87%' />	
					</tr>
					<tr>
						<td class='label_form'>Gender</td>
						<td >
						<input name='gender' id='gender' readonly='true' 
							class='easyui-validatebox textbox' style='padding:3px;width:87%' />	
					</tr><tr>
						<td class='label_form'>Alergi</td>
						<td >
						<input name='alergi' id='alergi' readonly='true' 
							class='easyui-validatebox textbox' style='padding:3px;width:87%' />	
					</tr>
					<tr>
						<td class='label_form'>Bagian</td>
						<td >
						<input name='bagian' id='bagian' readonly='true' 
							class='easyui-validatebox textbox' style='padding:3px;width:87%' />	
					</tr>
					<tr>
						<td class='label_form'>Keluhan</td>
						<td >
						<input name='keluhan' id='keluhan' readonly='true' class='easyui-validatebox textbox' style='padding:3px;width:87%' />	
					</tr>
					<tr>
							<td class='label_form'>Dokter</td>
								<td>
								<input name='kode_dokter' id='kode_dokter' class='easyui-combobox' readonly="true" required="true" style="padding:3px;width:218px" data-options="
			                                        url:'<?php echo base_url();?>index.php/periksa/getDokter',
			                                        valueField:'nip',
			                                        textField:'full_name'
			                                        "/>
								</td>
							</td>
					</tr>
					<tr>
						<td class='label_form'>Hasil Pemeriksaan</td>
						<td >
						<textarea cols='40' rows='3' name='diagnosa' id='diagnosa' 
							style='padding:3px;width:87%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Diagnosa</td>
						<td>
						<select name='id_penyakit' id='id_penyakit' required="true" class="easyui-combogrid" style="padding:3px;width:90%" data-options="
			                    panelWidth: 220,
			                    idField: 'id_penyakit',
			                    url:'<?php echo base_url();?>index.php/periksa/getIDPenyakit',
			                    method: 'post',
			                    valueField:'id_penyakit',
                                textField:'penyakit',
                                mode:'remote',
                                fitColumns:'true',
			                    columns: [[
				                        {field:'id_penyakit',title:'ID Penyakit',width:70,hidden:'true'},
				                        {field:'kode_penyakit',title:'Kode Penyakit',width:70},
				                        {field:'penyakit',title:'Nama Penyakit',width:120},
                    			]]
			                ">
			            </select>
						</td>
					</tr>

					<tr>
						<td class='label_form'>Status Registrasi</td>
                        <td>
							<input name='id_status_registrasi' id='id_status_registrasi' class='easyui-combobox' required="true"  style="padding:3px;width:90%" data-options="
                                        url:'<?php echo base_url();?>index.php/periksa/getStatus',
                                        valueField:'id_status_registrasi',
                                        textField:'id_status_registrasi',
                                        onLoadSuccess : function(){
						                                        $(this).combobox('select','Periksa');
						                                        }
                                        "/>
						</td>
					</tr>

		</form>
	
	