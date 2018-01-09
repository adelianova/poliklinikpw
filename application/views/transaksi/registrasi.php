	
<table id="datagrid-m_registrasi" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/registrasi/getListRegistrasi';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="kode_registrasi" width="100" hidden="true" sortable="true">KODE REGISTRASI</th>
					<th field="kode_pasien" width="100" hidden="true" sortable="true">KODE PASIEN</th>	
					<th field="nama" width="100" sortable="true">NAMA PASIEN</th>
					<th field="tgl_registrasi" width="100" sortable="true">TANGGAL</th>
					<th field="keluhan" width="100" sortable="true">KELUHAN</th>
					<th field="id_status_registrasi" width="150" sortable="true">STATUS</th>
					<th field="antrian" width="100" sortable="true">ANTRIAN</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addRegistrasi()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editRegistrasi()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeRegistrasi()">Remove</a>&nbsp;
			</div>
			<div style="display:inline;padding-top:-10px;">
				<tr>
					<td >
					<input name='tgl_awal' id='tgl_awal' class='easyui-datebox' prompt="Dari tanggal" style="padding:3px;width:35%"/>	
					</td>
					<td >
					<input name='tgl_akhir' id='tgl_akhir' class='easyui-datebox' prompt="Sampai tanggal" style="padding:3px;width:35%"/>	
					</td>
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="tampilkan();">Tampilkan Data</a>
				</tr>
				</tr>
			</div>
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakRegistrasi()"  style="color: #fff">CETAK PDF</a>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="sregistrasi" class="easyui-searchbox" style="width:250px" 
				searcher="cariregistrasi" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA PASIEN</div>
					<div name='keluhan'>KELUHAN</div>
					<div name='antrian'>NO ANTRIAN</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_registrasi" class="easyui-dialog" style="width:470px; height:200px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanRegistrasi();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_registrasi').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function cariregistrasi(value,name){
		
		$('#datagrid-m_registrasi').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addRegistrasi(){
		
			
		$('#dialog-m_registrasi').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/registrasi/formRegistrasi',
			title:'Tambah Registrasi',
			onLoad:function(){
				$('#form_registrasi').form('clear');
				$('#form_registrasi #edit').val('');

						

			}
			});
		

	}
	
	function editRegistrasi(){
		
        var row = $('#datagrid-m_registrasi').datagrid('getSelected');

		if(row){
		
		$('#dialog-m_registrasi').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/registrasi/formRegistrasi/edit',
			title:'Edit Registrasi',
			onLoad:function(){
				
				
				$('#form_registrasi').form('clear');
				$('#form_registrasi #edit').val('1');
				$('#form_registrasi').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanRegistrasi(){
		$.messager.progress({
                title:'',
                msg:'Simpan Registrasi...',
				text:''
         });
			
		$('#form_registrasi').form('submit',{
			url: '<?php echo site_url('registrasi/simpanRegistrasi'); ?>',
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
						$('#dialog-m_registrasi').dialog('close');
						$('#datagrid-m_registrasi').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
	
    function removeRegistrasi(){
		var row = $('#datagrid-m_registrasi').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini ?',function(r){
				if (r){
					$.post('<?php echo site_url('registrasi/hapusRegistrasi'); ?>',{kode_registrasi:row.kode_registrasi},function(result){
						if (!result.error){
							$('#datagrid-m_registrasi').datagrid('reload');
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
   function tampilkan() {
		var tgl_awal = $('#tgl_awal').datebox('getValue');
		var tgl_akhir = $('#tgl_akhir').datebox('getValue');

		$('#datagrid-m_registrasi').datagrid('load',{"tgl_awal" : tgl_awal, "tgl_akhir" : tgl_akhir});
	}
	function cetakRegistrasi(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter("http://localhost/poliklinikpw1/index.php/registrasi/cetakRegistrasi/"+tgl_awal+"/"+tgl_akhir,"Data Registrasi","800","400");
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
