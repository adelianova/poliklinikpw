	
<table id="datagrid-m_retur" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/retur/getListRetur';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="id_retur" width="100" sortable="true" hidden="true">ID RETUR</th>
					<th field="no_retur" width="100" sortable="true">NO RETUR</th>
					<th field="tgl" width="100" sortable="true">TANGGAL</th>
					<th field="nama" width="100" sortable="true">PETUGAS</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addRetur()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editRetur()">Tampilkan</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removeRetur()">Remove</a>&nbsp;
				 
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
			<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakRetur()"  style="color: #fff">CETAK PDF</a>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="sretur" class="easyui-searchbox" style="width:250px" 
				searcher="cariRetur" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='full_name'>NAMA PETUGAS</div>
				</div>  
			</div>
		</div>
		<div id="dialog-m_retur" class="easyui-dialog" style="width:480px; height:500px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanRetur();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_retur').dialog('close');">Batal</a>
	</div>
		
<<script>
	
	
	function cariRetur(value,name){
		
		$('#datagrid-m_retur').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addRetur(){
		$('#dialog-m_retur').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/retur/formRetur',
			title:'Tambah Transaksi Retur Obat',
			onLoad:function(){
				
				$('#form_retur').form('clear');
				$('#form_retur #edit').val('');
				$('#form_retur #petugas').combobox('setValue','<?php echo $this->session->userdata('userid');?>');
				
				$('#panelGridRetur').hide();

			}
			});
	}
	
	function editRetur(){
		
        var row = $('#datagrid-m_retur').datagrid('getSelected');
        console.log(row);
		if(row){
		
		$('#dialog-m_retur').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/retur/formRetur',
			title:'Edit Retur',
			onLoad:function(){
				
				
				$('#form_retur').form('clear');
				$('#form_retur #edit').val('1');
				$('#form_retur').form('load',row);	
				$('#datagrid-m_detail').datagrid('load',{id_retur:row.id_retur});
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanRetur(){
		$.messager.progress({
                title:'',
                msg:'Simpan Retur...',
				text:''
         });
			
		$('#form_retur').form('submit',{
			url: '<?php echo site_url('retur/simpanRetur'); ?>',
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
						$('#dialog-m_retur').dialog('close');
						$('#datagrid-m_retur').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
    function removeRetur(){
		var row = $('#datagrid-m_retur').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(r){
				if (r){
					$.post('<?php echo site_url('retur/removeRetur'); ?>',{id_retur:row.id_retur},function(result){
						if (!result.error){
							$('#datagrid-m_retur').datagrid('reload');
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

		$('#datagrid-m_retur').datagrid('load',{"tgl_awal" : tgl_awal, "tgl_akhir" : tgl_akhir});
	}
	function cetakRetur(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter("http://localhost/poliklinikpw1/index.php/retur/cetakRetur/"+tgl_awal+"/"+tgl_akhir,"DATA RETUR OBAT","800","400");
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