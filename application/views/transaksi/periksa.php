<table id="datagrid-m_periksa" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/periksa/getListPeriksa';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="id_periksa" width="100" sortable="true" hidden="true">ID</th>
					<th field="kode_registrasi" width="100" sortable="true" hidden="true">KODE REGISTRASI</th>
					<th field="kode_dokter" width="100" sortable="true" hidden="true">DOKTER</th>
					<th field="kode_pasien" width="100" sortable="true" hidden="true">PASIEN</th>
					<th field="nama" width="100" sortable="true">PASIEN</th>
					<th field="nama_dokter" width="100" sortable="true">DOKTER</th>
					<th field="id_penyakit" width="100" sortable="true" hidden="true">ID PENYAKIT</th>
					<th field="diagnosa" width="100" sortable="true">HASIL PEMERIKSAAN</th>
					<th field="penyakit" width="100" sortable="true">DIAGNOSA</th>
					<th field="tgl_periksa" width="100" sortable="true">TANGGAL PERIKSA</th>		
					<th field="keluhan" width="100" sortable="true">KELUHAN</th>
					<th field="jenis_periksa" width="100" sortable="true">JENIS PERIKSA</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="addPeriksa()">Add</a>&nbsp;
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="editPeriksa()">Edit</a>&nbsp;
        	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="removePeriksa()">Remove</a>&nbsp;
				 
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
					<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakPeriksa()"  style="color: #fff">CETAK PDF</a>
				</tr>
				</tr>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="speriksa" class="easyui-searchbox" style="width:250px" 
				searcher="cariperiksa" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px">
					<div name='nama_dokter'>DOKTER</div>
					<div name='nama'>NAMA PASIEN</div>
					<div name='keluhan'>KELUHAN</div>
					<div name='penyakit'>PENYAKIT</div>
					
				</div>  
			</div>
		</div>
		<div id="dialog-m_periksa" class="easyui-dialog" style="width:410px; height:420px; padding: 10px 20px" 
		closed="true" buttons="#dialog-buttons" iconCls="icon-user">
		</div>
		
		<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanPeriksa();">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-m_periksa').dialog('close');">Batal</a>
	</div>
		
<script>
	
	
	function cariperiksa(value,name){
		
		$('#datagrid-m_periksa').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	
	function addPeriksa(){
		
			
		$('#dialog-m_periksa').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/periksa/formPeriksa',
			title:'Tambah Pemeriksaan',
			onLoad:function(){
				$('#form_periksa').form('clear');
				$('#form_periksa #edit').val('');
				$('#form_periksa #kode_dokter').combobox('setValue','<?php echo $this->session->userdata('userid');?>');
			}
			});
	}
	
	function editPeriksa(){
		
        var row = $('#datagrid-m_periksa').datagrid('getSelected');
		if(row){
		$('#dialog-m_periksa').dialog({ 
		    closed: false, 
			cache: false, 
			modal: true, 
			href:base_url+'index.php/periksa/formPeriksa',
			title:'Edit Pemeriksaan',
			onLoad:function(){
				
				
				$('#form_periksa').form('clear');
				$('#form_periksa #edit').val('1');
				$('#form_periksa').form('load',row);	
				
			}
			});
		}else{
			$.messager.alert('INFO','Pilih satu record dulu','info');
		}
		
	}
	
	function simpanPeriksa(){
		$.messager.progress({
                title:'',
                msg:'Simpan Pemeriksaan...',
				text:''
         });
			
		$('#form_periksa').form('submit',{
			url: '<?php echo site_url('periksa/simpanPeriksa'); ?>',
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
						$('#dialog-m_periksa').dialog('close');
						$('#datagrid-m_periksa').datagrid('reload');
						$.messager.alert('INFO',result.msg,'info');
				
					
					}
					
			}
		});
	}
	
	
    function removePeriksa(){
		var row = $('#datagrid-m_periksa').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi', 'Anda yakin menghapus data ini',function(r){
				if (r){
					$.post('<?php echo site_url('periksa/hapusPeriksa'); ?>',{id_periksa:row.id_periksa},function(result){
						if (!result.error){
							$('#datagrid-m_periksa').datagrid('reload');
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

		$('#datagrid-m_periksa').datagrid('load',{"tgl_awal" : tgl_awal, "tgl_akhir" : tgl_akhir});
	}

	
	function cetakPeriksa(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter("http://localhost/poliklinik1/index.php/periksa/cetakPeriksa/"+tgl_awal+"/"+tgl_akhir,"DATA PEMERIKSAAN","800","400");
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
