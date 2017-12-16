<div id="cc" class="easyui-layout" style="width:420px;height:400px;">
    <div data-options="region:'north',title:'',split:true" style="height:80px;">
		<form id="form_retur" method="post" novalidate>
					<input type='hidden' name='edit' id='edit' value=''/>
					<table width='350px' class='dialog-form' >
						<tr>
							<td >
								<input name='id_retur' id='id_retur' type="hidden" readonly='true' 
								class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['id_retur'];?>"/>	
							</td>
						</tr>
						<tr>
							<td >
								<input name='no_retur' id='no_retur' type="hidden" 	class='easyui-validatebox textbox' type="text" style="padding:3px;width:90%"  value="<?php echo $no_retur['no_retur'];?>"/>
							</td>
						</tr>
						<tr>
							<td class='label_form'>Tanggal</td>
							<td >
								<input name='tgl' id='tgl' class='easyui-datebox' style="padding:3px;width:270px"/>	
							</td>
						</tr>
						<tr>
							<td class='label_form'>Petugas</td>
								<td>
								<input name='petugas' id='petugas' class='easyui-combobox' required="true" style="padding:3px;width:270px" data-options="
			                                        url:'<?php echo base_url();?>index.php/retur/getPetugas',
			                                        valueField:'nip',
			                                        textField:'full_name'
			                                        "/>
								</td>
							</td>
						</tr>
				</table>
			</form>
	</div>
    <div id="panelGridRetur" data-options="region:'center',title:''" style="padding:0px;height: 300px">
				<div id="dialog-m_tambah" class="easyui-dialog" style="width:390px; height:250px; padding: 10px 20px" 
						closed="true" iconCls="icon-user">
						</div>
				<table id="datagrid-m_detail" iconCls="icon-save" class="easyui-datagrid scrollbarx" 
						style="width:418px; height: 300px;" 
						data-options="
						url:'<?php echo base_url().'index.php/retur/getListDetail';?>',
						toolbar:'#toolbar2',rownumbers:true,border:'true',
						singleSelect:true">
							<thead>
								<tr>
									<th field="id_dtl_retur" width="100" hidden="true" sortable="true">ID DETAIL RETUR</th>
									<th field="id_retur" width="70" hidden="true" sortable="true">ID RETUR</th>
									<th field="id_dtl_stock" width="100" hidden="true" sortable="true">ID DETAIL STOCK</th>
									<th field="nama" width="150" sortable="true">NAMA OBAT</th>
									<th field="qty" width="80" sortable="true">QUANTITY</th>
									<th field="satuan" width="60" sortable="true">SATUAN</th>
									<th field="keterangan" width="100" sortable="true">KETERANGAN</th>
								</tr>
							</thead>
						</table>
						<div id="toolbar2" style='padding:5px;height:25px'>
							<div style="display:inline;">
							<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onClick="iniTambah()">Tambah</a>&nbsp;
							<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editTambah()">Edit</a>&nbsp;
				        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeTambahRetur()">Remove</a>&nbsp;
								 
						</div>
	</div>
	
<script type="text/javascript">
function iniTambah(){
	var id_retur = $('#datagrid-m_retur').datagrid('getSelected');
		$('#dialog-m_tambah').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/retur/formTambahRetur/'+id_retur.id_retur,
			title:'Tambah Obat',
			onLoad:function(){
				$('#form_tambah_retur').form('clear');
				$('#form_tambah_retur #edit').val('');
			},
			onClose: function(){
				
			 $('#dialog-m_detail').datagrid('reload');
			}
			});
	}
function editTambah(){
        var row = $('#datagrid-m_detail').datagrid('getSelected');
        console.log(row);
		if(row){
		$('#dialog-m_tambah').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/retur/formTambahRetur',
			title:'Edit Obat',
			onLoad:function(){
				$('#form_tambah_retur').form('clear');
				$('#form_tambah_retur #edit').val('1');
				$('#form_tambah_retur').form('load',row);	
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
	}

function removeTambahRetur(){
		var row = $('#datagrid-m_detail').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(z){
				if (z){
					$.post('<?php echo site_url('retur/removeTambahRetur'); ?>',{id_dtl_retur:row.id_dtl_retur},function(result){
						console.log(result)
						if (!result.error){
							$('#datagrid-m_detail').datagrid('reload');
							$.messager.alert('INFO',result.msg,'info');
							} else {
							$.messager.alert('INFO',result.msg,'info');
						}
					},'json');
				}
			});
			}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
	}

</script>


	