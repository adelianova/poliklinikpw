	
<table id="datagrid-m_obat" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/obat/getListObat';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false" >
			<thead>
				<tr>
					<th field="kode_obat" width="100" sortable="true">KODE OBAT</th>
					<th field="nama" width="100" sortable="true">NAMA</th>
                    <th field="satuan" width="100" sortable="true">SATUAN</th>
                    <th field="sisa" width="100" sortable="true">STOK</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addObat()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editObat()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeObat()">Remove</a>&nbsp;
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakObat()"  style="color: #fff">CETAK PDF</a>	 
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="sobat" class="easyui-searchbox" style="width:250px" 
				searcher="cariobat" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA</div>
					<div name='sisa'>STOK</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_obat" class="easyui-dialog" style="width:410px; height:200px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanObat();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_obat').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function cariobat(value,name){
		
		$('#datagrid-m_obat').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addObat(){
		
			
		$('#dialog-m_obat').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/obat/formObat',
			title:'Tambah Obat',
			onLoad:function(){
				$('#form_obat').form('clear');
				
				
				$('#form_obat #edit').val('');

						

			}
			});
		

	}
	
	function editObat(){
		
        var row = $('#datagrid-m_obat').datagrid('getSelected');

		if(row){
		
		$('#dialog-m_obat').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/obat/formObat',
			title:'Edit Obat',
			onLoad:function(){
				
				
				$('#form_obat').form('clear');
				$('#form_obat #edit').val('1');
				$('#form_obat').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanObat(){
		$.messager.progress({
                title:'',
                msg:'Simpan Master Obat...',
				text:''
         });
			
		$('#form_obat').form('submit',{
			url: '<?php echo site_url('obat/simpanObat'); ?>',
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
						$('#dialog-m_obat').dialog('close');
						$('#datagrid-m_obat').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
	
    function removeObat(){
		var row = $('#datagrid-m_obat').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data Obat ini?',function(r){
				if (r){
					$.post('<?php echo site_url('obat/hapusObat'); ?>',{kode_obat:row.kode_obat},function(result){
						if (!result.error){
							$('#datagrid-m_obat').datagrid('reload');
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
	function cetakObat(){
        PopupCenter("http://localhost/poliklinikpw1/index.php/obat/cetakObat","DATA OBAT","800","400");
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