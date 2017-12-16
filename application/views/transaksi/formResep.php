<div id="cc" class="easyui-layout" style="width:420px;height:400px;">
    <div data-options="region:'north',title:'',split:true" style="height:80px;">
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
			                    panelWidth: 300,
			                    idField: 'id_periksa',
			                    url:'<?php echo base_url();?>index.php/resep/getIDPeriksa',
			                    method: 'get',
			                    valueField:'id_periksa',
                                textField:'nama',
			                    columns: [[
				                        {field:'id_periksa',title:'ID',width:50,hidden:'true'},
				                        {field:'kode_pasien',title:'Kode Pasien',width:80},
				                        {field:'nama',title:'Nama',width:220,align:'left'},
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
							class='easyui-validatebox textbox' style="padding:3px;width:91%"/>
						</td>
					</tr>
				</table>	
		</form>
    </div>
    <div id="panelGridResep" data-options="region:'center',title:''" style="width: 418px;height: 200px;">
    	<div id="dialog-m_tambah" class="easyui-dialog" style="width:410px; height:250px; padding: 10px 20px;border:0" closed="true" iconCls="icon-user"></div>
			<table id="datagrid-m_ini" toolbar="#tb" iconCls="icon-save" class="easyui-datagrid scrollbarx" style="width:100%;height:200px;" data-options="url:'<?php echo base_url().'index.php/resep/kodeResep/';?>'
			">
			    <thead>

			    <!--<?php echo ltrim($data['id_resep']);?>-->
			        <tr>
			            <th field="KODE_OBAT" width="80">Kode Obat</th>
			            <th field="NAMA" width="130">Nama Obat</th>
			            <th field="QTY" width="50" align="right">Quantity</th>
			            <th field="SATUAN" width="60" align="right">SATUAN</th>
			            <th field="DOSIS" width="80" align="right">Dosis</th>
			            <th field="ID_DETAIL_RESEP" width="80" align="right" hidden="true">ID</th>
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
		/*$(field="ID_DETAIL_RESEP").each(function(){
			$(this).hide()
			console.log(this);
		})*/

		/*$("#id_periksa").combogrid({
			
		})
*/
function addTambah(){
	var id_resep = $('#datagrid-m_resep').datagrid('getSelected');
		$('#dialog-m_tambah').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/resep/formTambah/'+id_resep.id_resep,
			title:'Tambah Obat',
			onLoad:function(){
				$('#form_tambah').form('clear');
				$('#form_tambah #edit').val('');
			},
			onClose: function(){
				
			 $('#dialog-m_ini').datagrid('reload');
			}
			});
		}
	function editTambah(){
	        var id_detail_resep = $('#datagrid-m_ini').datagrid('getSelected');
	        console.log(id_detail_resep);
			if(id_detail_resep){
			$('#dialog-m_tambah').dialog({ 
			    closed: false, 
				cache: false, 
				modal: true, 
				href:base_url+'index.php/resep/formTambah/'+id_detail_resep.ID_DETAIL_RESEP,
				title:'Edit Resep Obat',
				onLoad:function(){
					$('#form_tambah').form('clear');
					$('#form_tambah #edit').val('1');
					$('#form_tambah').form('load',id_detail_resep);
					}
				});
			}else{
				$.messager.alert('INFO','Pilih satu record dulu','info');
			}
	}
	function editResep(){
		
        var row = $('#datagrid-m_resep').datagrid('getSelected');
        console.log(row);
		if(row){
		
		$('#dialog-m_resep').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/resep/formResep',
			title:'Edit Resep',
			onLoad:function(){
				
				
				$('#form_resep').form('clear');
				$('#form_resep #edit').val('1');
				$('#form_resep').form('load',row);	
				$('#datagrid-m_ini').datagrid('load',{id_resep:row.id_resep});
				
								
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}


function removeTambah(){
		var row = $('#datagrid-m_ini').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(z){
				if (z){
					$.post('<?php echo site_url('resep/hapusTambah'); ?>',{id_detail_resep:row.ID_DETAIL_RESEP},function(result){
						console.log(result)
						if (!result.error){
							$('#datagrid-m_ini').datagrid('reload');
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
function getDokter(index,row) {
		    console.log (row.id_periksa);
	        var ed = $("#nama_dokter").combogrid("getEditor", 
	        {index:editIndex,field:"nama_dokter"});
	        $(ed.target).val(row.id_periksa);
		/*onSelect: function(index,row){
        			console.log(index);
            		console.log(row.id_periksa);
					$('#nama_dokter').combogrid('grid').datagrid('load',{
					id_periksa:row.id_periksa
					})
				}*/
}
</script>




	
	