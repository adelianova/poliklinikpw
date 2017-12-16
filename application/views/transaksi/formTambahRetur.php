	<form id="form_tambah_retur" method="post" novalidate>
				<input type='hidden' name='edit' id='edit' value=''/>
				<table width='350px' class='dialog-form' >

					<tr>
						<td>
							<input name='id_dtl_retur' id='id_dtl_retur' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" >	
						</td>
					</tr>
					<tr>
						<td>
							<input name='id_retur' id='id_retur' type="hidden" readonly='true' 
							class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $id_retur;?>"/>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama Obat</td>
						<td>
						<select name='id_dtl_stock' id='id_dtl_stock' required="true" class="easyui-combogrid" style="width:93%" data-options="
			                    panelWidth: 300,
			                    idField: 'id_dtl_stock',
			                    url:'<?php echo base_url();?>index.php/retur/getDtlStock',
			                    method: 'get',
			                    valueField:'id_dtl_stock',
                                textField:'nama',
			                    columns: [[
				                        {field:'id_dtl_stock',title:'ID DETAIL STOCK',width:100,hidden:'true'},
				                        {field:'nama',title:'Nama Obat',width:148},
				                        {field:'tgl_expired',title:'Tanggal Expired',width:100},
				                       	{field:'sisa',title:'Sisa',width:50},
				                        {field:'satuan',title:'Satuan',width:100,align:'left'},
				                       	
                    			]],
                    			onSelect: function(index, row){
						        			$('#satuan1').val(row.satuan);
										},
			                ">
			            </select>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Quantity</td>
						<td >
							<input name='qty' id='qty' class='easyui-validatebox textbox' required="true" onkeyup="#" type="number" style="padding:3px;width:40%"/>
							<input name='satuan1' id='satuan1' class='easyui-validatebox textbox' readonly="true" onkeyup="#" type="text" style="padding:3px;width:46%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Keterangan</td>
						<td >
							<input name='keterangan' id='keterangan' class='easyui-validatebox textbox' required="true" type="text" style="padding:3px;width:90%"/>
						</td>
					</tr>
					
					
			</table>
			<div id="dialog-buttons">
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" type="submit" name="button" value="OK" id="button" onclick="simpanTambahRetur()">Simpan</a>
					</div>
		</form>
<script language="javascript">
	
	function simpanTambahRetur(){
		$.messager.progress({
                title:'',
                msg:'Simpan Retur Obat...',
				text:''
         });
			
		$('#form_tambah_retur').form('submit',{
			url: '<?php echo site_url('retur/simpanTambahRetur/'.$id_retur); ?>',
			onSubmit: function(){ 
				var isValid = $(this).form('validate');
				if (!isValid){
					$.messager.progress('close');
					return $(this).form('validate');
				}
			},
			success: function(result){
				$.messager.progress('close');
				var result = eval('('+result+')');
					if(result.error){
						$.messager.alert('INFO',result.msg,'info');
					}else{
						$('#dialog-m_tambah').dialog('close');
						$('#datagrid-m_detail').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
					}
			}
		});
	}
</script> 
