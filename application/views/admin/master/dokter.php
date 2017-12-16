	
<table id="datagrid-m_dokter" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/dokter/getListDokter';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="kode_dokter" width="100" sortable="true">KODE</th>
					<th field="nama_dokter" width="100" sortable="true">NAMA</th>
					<th field="alamat_dokter" width="100" sortable="true">ALAMAT</th>
					<th field="telp" width="100" sortable="true">TELP</th>
					<th field="email" width="100" hidden="true"></th>		
					<th field="spesialisasi" width="100" sortable="true">SPESIALISASI</th>
					<th field="keterangan" width="150" sortable="true">KETERANGAN</th>
					
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addDokter()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editDokter()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeDokter()">Remove</a>&nbsp;
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakLaporan()"  style="color: #fff">CETAK PDF</a>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="sdokter" class="easyui-searchbox" style="width:250px" 
				searcher="caridokter" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama_dokter'>NAMA</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_dokter" class="easyui-dialog" style="width:410px; height:350px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanDokter();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_dokter').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function caridokter(value,nama){
		
		$('#datagrid-m_dokter').datagrid('load', { "searchKey": nama, "searchValue": value });
	}
	
	function addDokter(){
		
			
		$('#dialog-m_dokter').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/dokter/formDokter',
			title:'Tambah Dokter',
			onLoad:function(){
				$('#form_dokter').form('clear');
				
				
				$('#form_dokter #edit').val('');

						

			}
			});
		

	}
	
	function editDokter(){
		
        var row = $('#datagrid-m_dokter').datagrid('getSelected');

		if(row){
		
		$('#dialog-m_dokter').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/dokter/formDokter',
			title:'Edit Dokter',
			onLoad:function(){
				
				
				$('#form_dokter').form('clear');
				$('#form_dokter #edit').val('1');
				$('#form_dokter').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanDokter(){
		$.messager.progress({
                title:'',
                msg:'Simpan Master Dokter...',
				text:''
         });
			
		$('#form_dokter').form('submit',{
			url: '<?php echo site_url('dokter/simpanDokter'); ?>',
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
						$('#dialog-m_dokter').dialog('close');
						$('#datagrid-m_dokter').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
	
    function removeDokter(){
		var row = $('#datagrid-m_dokter').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(r){
				if (r){
					$.post('<?php echo site_url('dokter/hapusDokter'); ?>',{kode_dokter:row.kode_dokter},function(result){
						if (!result.error){
							$('#datagrid-m_dokter').datagrid('reload');
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
	function cetakLaporan(){
        PopupCenter("http://localhost/poliklinik1/index.php/dokter/cetakDokter","DATA DOKTER","800","400");
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