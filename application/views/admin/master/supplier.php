	
<table id="datagrid-m_suplier" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/supplier/getListSupplier';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="id_suplier" width="50" sortable="true" hidden="true">ID SUPLIER</th>
					<th field="nama" width="100" sortable="true">NAMA</th>
					<th field="alamat" width="100" sortable="true">ALAMAT</th>
					<th field="telp" width="100" sortable="true">TELP</th>
					<th field="email" width="100" sortable="true">EMAIL</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addSuplier()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editSuplier()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeSupplier()">Remove</a>&nbsp;
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakSupplier()"  style="color: #fff">CETAK PDF</a>
			</div>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="ssuplier" class="easyui-searchbox" style="width:250px" 
				searcher="carisuplier" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_suplier" class="easyui-dialog" style="width:410px; height:250px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanSuplier();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_suplier').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function carisuplier(value,name){
		
		$('#datagrid-m_suplier').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addSuplier(){
		
			
		$('#dialog-m_suplier').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/supplier/formSupplier',
			title:'Tambah Suplier',
			onLoad:function(){
				$('#form_suplier').form('clear');
				
				
				$('#form_suplier #edit').val('');

						

			}
			});
		

	}
	
	function editSuplier(){
		
        var row = $('#datagrid-m_suplier').datagrid('getSelected');

		if(row){
		
		$('#dialog-m_suplier').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/supplier/formSupplier',
			title:'Edit Suplier',
			onLoad:function(){
				
				
				$('#form_suplier').form('clear');
				$('#form_suplier #edit').val('1');
				$('#form_suplier').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanSuplier(){
		$.messager.progress({
                title:'',
                msg:'Simpan Master Suplier...',
				text:''
         });
			
		$('#form_suplier').form('submit',{
			url: '<?php echo site_url('supplier/simpanSuplier'); ?>',
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
						$('#dialog-m_suplier').dialog('close');
						$('#datagrid-m_suplier').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
    function removeSupplier(){
		var row = $('#datagrid-m_suplier').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(r){
				if (r){
					$.post('<?php echo site_url('supplier/hapusSupplier'); ?>',{id_suplier:row.id_suplier},function(result){
						if (!result.error){
							$('#datagrid-m_suplier').datagrid('reload');
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
	function cetakSupplier(){
        PopupCenter("http://localhost/poliklinikpw1/index.php/supplier/cetakSupplier","DATA SUPPLIER","800","400");
    }
	function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
</script>