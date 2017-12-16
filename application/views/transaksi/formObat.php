<div id="cc" class="easyui-layout" style="width:500px;height:400px;">
    <div data-options="region:'north',title:'',split:true" style="height:130px;">
		<form id="form_obat" method="post" novalidate>
					<input type='hidden' name='edit' id='edit' value=''/>
					<table width='350px' class='dialog-form' >
						<tr>
							<td >
								<input name='id_stock' id='id_stock' type="hidden" readonly='true' 
								class='easyui-validatebox textbox' style="padding:3px;width:90%" value="<?php echo $data['id_stock'];?>"/>	
							</td>
						</tr>
						<tr>
							<td class='label_form'>Transaksi</td>
							<td>
							<select name='id_transaksi' id='id_transaksi' required="true" class="easyui-combogrid" style="padding:3px;width:90%" data-options="
				                    panelWidth: 200,
				                    idField: 'ID_TRANSAKSI',
				                    url:'<?php echo base_url();?>index.php/transaksi/getListIDTransaksi',
				                    method: 'get',
				                    valueField:'ID_TRANSAKSI',
	                                textField:'TRANSAKSI',
				                    columns: [[
					                        {field:'ID_TRANSAKSI',hidden:'true',title:'ID Transaksi',width:50},
					                        {field:'TRANSAKSI',title:'Transaksi',width:200},
	                    			]]
				                ">
				            </select>
							</td>
						</tr>
						<tr>
							<td class='label_form'>Supplier</td>
							<td>
							<select name='id_suplier' id='id_suplier' required="true" class="easyui-combobox" style="padding:3px;width:90%" data-options="
				                    url:'<?php echo base_url();?>index.php/transaksi/getIDSuplier',
				                    valueField:'ID_SUPLIER',
	                                textField:'NAMA',
				                ">
				            </select>
							</td>
						</tr>

						
						<tr>
							<td class='label_form'>Tanggal</td>
							<td >
								<input name='tgl' id='tgl' class='easyui-datebox' style="padding:3px;width:90%"/>	
							</td>
						</tr>
						<tr>
							<td >
								<input name='no_faktur' id='no_faktur' class='easyui-validatebox textbox' type="hidden" style="padding:3px;width:90%"  value="<?php echo $no_faktur['no_faktur'];?>"/>
							</td>
						</tr>
						<tr>
							<td class='label_form'>Keterangan</td>
							<td >
								<input name='keterangan' id='keterangan' class='easyui-validatebox textbox' type="text" style="padding:3px;width:86.7%"/>
							</td>
						</tr>
				</table>
		</form>
	</div>
   	<div id="panelGridStok" data-options="region:'center',title:''" style="padding:0px;">
			<div id="dialog-m_tambah" class="easyui-dialog" style="width:480px; height:300px; padding: 10px 20px" 
					closed="true" iconCls="icon-user">
					</div>
			<table id="datagrid-m_detail" title="Stok Obat" iconCls="icon-save" class="easyui-datagrid scrollbarx" 
					style="width:480px; height: 300px;" 
					data-options="
					url:'<?php echo base_url().'index.php/transaksi/getListDetail';?>',
					toolbar:'#toolbar2',rownumbers:true,border:true,
					striped:true,fit:true,fitColumns:true,
					singleSelect:true">
						<thead>
							<tr>
								<th field="id_dtl_stock" width="120" sortable="true" hidden="true">ID DETAIL STOCK</th>
								<th field="id_stock" width="70" sortable="true" hidden="true">ID STOCK</th>
								<th field="nama" width="120" sortable="true">OBAT</th>
								<th field="qty" width="60" sortable="true">JUMLAH</th>
								<th field="satuan" width="60" sortable="true">SATUAN</th>
								<th field="harga_satuan" width="60" sortable="true">HARGA SATUAN</th>
								<th field="tgl_expired" width="110" sortable="true">TGL EXPIRED</th>
							</tr>
						</thead>
					</table>
					<div id="toolbar2" style='padding:5px;height:25px'>
						<div style="display:inline;">
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onClick="iniTambah()">Tambah</a>&nbsp;
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editTambah()">Edit</a>&nbsp;
			        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeTambah()">Remove</a>&nbsp;
							 
					</div>
	</div>	
	
<script type="text/javascript">
		$(field="ID_DTL_STOCK").each(function(){
			$(this).hide()
			console.log(this);
		})
function iniTambah(){
	var id_stock = $('#datagrid-m_transaksi').datagrid('getSelected');
		$('#dialog-m_tambah').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/transaksi/formTambahObat/'+id_stock.id_stock,
			title:'Tambah Stok Obat',
			onLoad:function(){
				$('#form_tambah_obat').form('clear');
				$('#form_tambah_obat #edit').val('');
			},
			onClose: function(){
				
			 $('#dialog-m_detail').datagrid('close');
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
			href:base_url+'index.php/transaksi/formTambahObat',
			title:'Edit Obat',
			onLoad:function(){
				$('#form_tambah_obat').form('clear');
				$('#form_tambah_obat #edit').val('1');
				$('#form_tambah_obat').form('load',row);	
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
	}
	function editTransaksi(){
		
        var row = $('#datagrid-m_transaksi').datagrid('getSelected');
        console.log(row);
		if(row){
		
		$('#dialog-m_transaksi').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/transaksi/formObat',
			title:'Edit Obat',
			onLoad:function(){
				
				
				$('#form_obat').form('clear');
				$('#form_obat #edit').val('1');
				$('#form_obat').form('load',row);	
				$('#datagrid-m_detail').datagrid('load',{id_stock:row.id_stock});
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}

/*
function removeTambah(){
		var row = $('#datagrid-m_detail').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(z){
				if (z){
					$.post('<?php echo site_url('transaksi/removeTambah'); ?>',{id_dtl_stock:row.ID_DTL_STOCK},function(result){
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
	}*/
function removeTambah(){
		var row = $('#datagrid-m_detail').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(z){
				if (z){
					$.post('<?php echo site_url('transaksi/removeTambah'); ?>',{id_dtl_stock:row.id_dtl_stock},function(result){
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


	