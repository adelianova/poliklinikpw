
<table id="datagrid-m_periksa" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/laporan_pemeriksaan/getListLaporanPemeriksaan';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false"  nowrap="false">
			<thead>
				<tr>
					<th field="nip" width="80" sortable="true" >NIP</th>
					<th field="nama" width="100" sortable="true">NAMA PASIEN</th>
					<th field="bagian" width="100" sortable="true">BAGIAN</th>
					<th field="status_pasien" width="100" sortable="true">STATUS PASIEN</th>
					<th field="gender" width="100" sortable="true">GENDER</th>
					<th field="tgl_periksa" width="100" sortable="true">TANGGAL PERIKSA</th>
					<th field="diagnosa" width="100" sortable="true">HASIL PEMERIKSAAN</th>		
					<th field="penyakit" width="100" sortable="true">DIAGNOSA</th>
					<th field="kode_dokter" width="100" sortable="true">KODE DOKTER</th>
					<th field="nama_dokter" width="100" sortable="true">NAMA DOKTER</th>
					<th field="jenis_periksa" width="100" sortable="true">JENIS PEMERIKSAAN</th>
					
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
			<div style="display:inline;float:left;padding-top:-10px;">
				<tr>
					<td class='label_form'>Pilih Tanggal</td>
					<td >
					<input name='tgl_awal' id='tgl_awal' class='easyui-datebox' prompt="Dari tanggal" style="padding:3px;width:15%"/>	
					</td>
					<td >
					<input name='tgl_akhir' id='tgl_akhir' class='easyui-datebox' prompt="Sampai tanggal" style="padding:3px;width:17%"/>	
					</td>
					<tr>
						<td>
							<input name='status_pasien' id='status_pasien' class='easyui-combobox' prompt="Pilih status" style="padding:3px;width:20%" data-options="
			                      url:'<?php echo base_url();?>index.php/laporan_pemeriksaan/getStatus',
			                      valueField:'id_status_pasien',
			                      textField:'status_pasien'
			                       "/>
						</td>
					</tr>
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="tampilkan();">Tampilkan Data</a>
					<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakLaporan()"  style="color: #fff">CETAK PDF</a>
				</tr>
				</tr>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="speriksa" class="easyui-searchbox" style="width:250px" 
				searcher="cariperiksa" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA PASIEN</div>
					<div name='nama_dokter'>NAMA DOKTER</div>
				</div>  
			</div>
		</div>
<script>
	
	
	function cariperiksa(value,name){
		
		$('#datagrid-m_periksa').datagrid('load', { "searchKey": name, "searchValue": value });
	}
	function tampilkan() {
		var tgl_awal = $('#tgl_awal').datebox('getValue');
		var tgl_akhir = $('#tgl_akhir').datebox('getValue');
		var status_pasien = $('#status_pasien').combobox('getValue');
		$('#datagrid-m_periksa').datagrid('load',
		{
			"tgl_awal" : tgl_awal, 
			"tgl_akhir" : tgl_akhir,
			"status_pasien" : status_pasien
		});
	}

	
	function cetakLaporan(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var status_pasien = $('#status_pasien').combobox('getValue');
        PopupCenter("http://localhost/poliklinik1/index.php/laporan_pemeriksaan/cetakLaporan/"+tgl_awal+"/"+tgl_akhir+"/"+status_pasien,"LAPORAN PEMERIKSAAN","800","400");
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