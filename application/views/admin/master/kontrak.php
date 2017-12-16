	
<table id="datagrid-m_kontrak" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/kontrak/getListKontrak';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false">
			<thead>
				<tr>
					<th field="id_kontrak" width="50" hidden="true">ID KONTRAK</th>
					<th field="kode_dokter" width="100" sortable="true">KODE DOKTER</th>
					<th field="nama_dokter" width="100" sortable="true">NAMA DOKTER</th>
					<th field="nomor" width="100" sortable="true">NOMOR</th>
					<th field="mulai_kontrak" width="100" sortable="true">MULAI KONTRAK</th>
					<th field="selesai_kontrak" width="100" sortable="true">SELESAI KONTRAK</th>
					<th field="keterangan" width="150" sortable="true">KETERANGAN</th>
					
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addKontrak()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editKontrak()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeKontrak()">Remove</a>&nbsp;
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakKontrak()"  style="color: #fff">CETAK PDF</a>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="skontrak" class="easyui-searchbox" style="width:250px" 
				searcher="carikontrak" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama_dokter'>NAMA DOKTER</div>
					<div name='mulai_kontrak'>MULAI KONTRAK</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_kontrak" class="easyui-dialog" style="width:410px; height:300px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanKontrak();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_kontrak').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function carikontrak(value,name){
		
		$('#datagrid-m_kontrak').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addKontrak(){
		
			
		$('#dialog-m_kontrak').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/kontrak/formKontrak',
			title:'Tambah Kontrak',
			onLoad:function(){
				$('#form_kontrak').form('clear');
				
				
				$('#form_kontrak #edit').val('');

						

			}
			});
		

	}
	
	function editKontrak(){
		
        var row = $('#datagrid-m_kontrak').datagrid('getSelected');

		if(row){
		
		$('#dialog-m_kontrak').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/kontrak/formKontrak',
			title:'Edit Kontrak Dokter',
			onLoad:function(){
				
				
				$('#form_kontrak').form('clear');
				$('#form_kontrak #edit').val('1');
				$('#form_kontrak').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanKontrak(){
		$.messager.progress({
                title:'',
                msg:'Simpan Kontrak Dokter...',
				text:''
         });
			
		$('#form_kontrak').form('submit',{
			url: '<?php echo site_url('kontrak/simpanKontrak'); ?>',
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
						$('#dialog-m_kontrak').dialog('close');
						$('#datagrid-m_kontrak').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
	
    function removeKontrak(){
		var row = $('#datagrid-m_kontrak').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(r){
				if (r){
					$.post('<?php echo site_url('kontrak/hapusKontrak'); ?>',{id_kontrak:row.id_kontrak},function(result){
						if (!result.error){
							$('#datagrid-m_kontrak').datagrid('reload');
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
	function cetakKontrak(){
        PopupCenter("http://localhost/poliklinik1/index.php/kontrak/cetakKontrak","DATA SURAT KONTRAK DOKTER","800","400");
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