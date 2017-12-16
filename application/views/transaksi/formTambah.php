	<form id="form_tambah" method="post" novalidate>
				
				<input type='hidden' name='edit' id='edit' value=''/>
				<input type='hidden' name='qty_asal' id='qty_asal' value=''/>
				<table width='350px' class='dialog-form' >
					<tr>
						<td>
							<input name='ID_DETAIL_RESEP' id='ID_DETAIL_RESEP' type="hidden"  value='<?php echo $dataResep['id_detail_resep'];?>'>	
						</td>
					</tr>
					<tr>
						<td class='label_form'>Nama Obat</td>
                        <td>
                        <select name='KODE_OBAT' id='KODE_OBAT' required="true" class="easyui-combogrid" style="padding:3px;width:96%" data-options="
			                    panelWidth: 250,
			                    idField: 'kode_obat',
			                    url:'<?php echo base_url();?>index.php/resep/getKodeObat',
			                    method: 'get',
			                    valueField:'kode_obat',
                                textField:'nama',
			                    columns: [[
				                        {field:'nama',title:'Nama Obat',width:150},
				                        {field:'sisa',title:'Stok',width:100,align:'left'},
				                        {field:'satuan',title:'Satuan',width:100,align:'left'},
                    			]],
                    			onSelect: function(index, row){
						        			$('#satuan1').val(row.satuan);
										},
			                ">
						</td>
					</tr>
					<tr>
						<td class='label_form'>Quantity</td>
						<td >
						<input name='QTY' id='QTY' class='easyui-validatebox textbox' required="true" onkeyup="#" type="number" style="padding:3px;width:43%"/>
							<input name='satuan1' id='satuan1' class='easyui-validatebox textbox' readonly="true" onkeyup="#" type="text" style="padding:3px;width:46%"/>
						</td>
					</tr>
					<tr>
						<td class='label_form'>Dosis</td>
						<td >
						<textarea cols='40' rows='3' name='DOSIS' id='DOSIS' 
							style='padding:3px;width:93%' class='easyui-validatebox textarea'  
							data-options="required:true"></textarea>
						</td>
					</tr>
					
			</table>

					<div id="dialog-buttons">
						<!--<input  class="easyui-linkbutton" iconCls="icon-ok" type="submit" name="button" id="button" onclick="ini()" value=" O K ">-->
						<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" type="submit" name="button" value="OK" id="button" onclick="simpanTambah()">Simpan</a>
						<!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:jQuery('#dialog-m_tambah').dialog('close');">Batal</a> -->
					</div>

<script type="text/javascript">
	function simpanTambah(){
		$.messager.progress({
                title:'',
                msg:'Simpan Resep Obat...',
				text:''
         });
			
		$('#form_tambah').form('submit',{
			url: '<?php echo site_url('resep/simpanTambah/'.$id_resep);?>',
			onSubmit: function(){ 
				var isValid = $(this).form('validate');
				if (!isValid){
					$.messager.progress('close');
					return $(this).form('validate');
				}
			},
			success: function(result){
				console.log(result);
				$.messager.progress('close');
				var result = eval('('+result+')');
					if(result.error){
						$.messager.alert('INFO',result.msg,'info');
					
					}else{
						$('#dialog-m_tambah').dialog('close');
						$('#datagrid-m_ini').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
					}
			}
		});
	}
	
	

</script>
		</form>