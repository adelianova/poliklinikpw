	<table id="datagrid-m_keluar" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/keluar/getListKeluar';?>',
		toolbar:'#toolbar1',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="kode_obat" width="100" sortable="true">KODE OBAT</th>
					<th field="nama" width="100" sortable="true">NAMA OBAT</th>		
					<th field="satuan" width="100" sortable="true">SATUAN</th>
					<th field="qty" width="100" sortable="true">QUANTITY</th>
					<th field="id_periksa" width="100" sortable="true">ID Periksa</th>
					<th field="tgl_periksa" width="100" sortable="true">TANGGAL </th>
					
				</tr>
			</thead>
	</table>

<div id="toolbar1" style='padding:5px;height:25px'>
			<div style="display:inline;float:left;padding-top:-10px;">
				<tr>
					<td class='label_form'>Pilih Tanggal</td>
					<td >
					<input name='tgl_awal' id='tgl_awal' class='easyui-datebox' prompt="Dari tanggal" style="padding:3px;width:30%"/>	
					</td>
					<td >
					<input name='tgl_akhir' id='tgl_akhir' class='easyui-datebox' prompt="Sampai tanggal" style="padding:3px;width:30%"/>	
					</td>
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="tampilkan();">Tampilkan Data</a>
					<a class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="cetakLaporan()"  style="color: #fff">CETAK PDF</a>
				</tr>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="skeluar" class="easyui-searchbox" style="width:250px" 
				searcher="carikeluar" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA OBAT</div>
				</div>  
			</div>
		</div>
<script>
	
	
	function carikeluar(value,name){
		
		$('#datagrid-m_keluar').datagrid('load', { "searchKey": name, "searchValue": value });
	}

	function tampilkan() {
		var tgl_awal = $('#tgl_awal').datebox('getValue');
		var tgl_akhir = $('#tgl_akhir').datebox('getValue');

		$('#datagrid-m_keluar').datagrid('load',{"tgl_awal" : tgl_awal, "tgl_akhir" : tgl_akhir});
	}
	function cetakLaporan(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter("http://localhost/poliklinik1/index.php/keluar/cetakLaporan/"+tgl_awal+"/"+tgl_akhir,"LAPORAN OBAT KELUAR","800","400");
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