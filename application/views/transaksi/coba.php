<div id="cc" class="easyui-layout" style="width:420px;height:400px;">
    <div data-options="region:'north',title:'',split:true" style="height:100px;">
    	<form id="form_resep" method="post" novalidate>
				<input type='hidden'  name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='id_resep' id='id_resep' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['id_resep'];?>"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Pasien</td>
						<td>
						<input name='id_periksa' id='id_periksa' required="true" class="easyui-combogrid" style="padding:3px;width:96%" data-options="
			                    panelWidth: 250,
			                    idField: 'id_periksa',
			                    url:'<?php echo base_url();?>index.php/resep/getIDPeriksa',
			                    method: 'get',
			                    valueField:'id_periksa',
                                textField:'nama',
			                    columns: [[
				                        {field:'id_periksa',title:'ID',width:50,hidden:'true'},
				                        {field:'kode_pasien',title:'Kode Pasien',width:100},
				                        {field:'nama',title:'Nama',width:140,align:'left'},
				                        {field:'nama_dokter',title:'Nama Dokter',width:140,align:'left'},
                    			]],
                    			onSelect: function(index, row){
				        			$('#nama_dokter').val(row.nama_dokter);
								}
                    		">
			            </input>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama Dokter</td>
						<td>
						<input name='nama_dokter' id='nama_dokter' readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%"/>
						</td>
					</tr>
				</table>	
		</form>
    </div>
    <div id="panelGridResep" data-options="region:'center',title:''" style="padding:0px;">
    	<div id="dialog-m_tambah" class="easyui-dialog" style="width:410px; height:250px; padding: 10px 20px" closed="true" iconCls="icon-user"></div>
			<table id="datagrid-m_ini" toolbar="#tb" iconCls="icon-save" class="easyui-datagrid scrollbarx" style="width:100%;height:200px;" data-options="url:'<?php echo base_url().'index.php/resep/kodeResep/';?>'
			">
			    <thead>

			    <!--<?php echo ltrim($data['id_resep']);?>-->
			        <tr>
			            <th field="KODE_OBAT" width="100">Kode Obat</th>
			            <th field="NAMA" width="100">Nama Obat</th>
			            <th field="QTY" width="100" align="right">Quantity</th>
			            <th field="DOSIS" width="100" align="right">Dosis</th>
			            <th field="ID_DETAIL_RESEP" width="100" align="right" hidden="true">ID</th>
			        </tr>
			    </thead>
			    <tbody>
				</tbody>
			</table>
			<div id="tb">
			    <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addTambah()">Tambah</a>&nbsp;
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editTambah()">Edit</a>&nbsp;
	        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeTambah()">Remove</a>&nbsp;
			</div>
	</div>
</div>

<script type="text/javascript">
	$('#panelGridResep').hide();
</script>