
<table id="datagrid-m_rekab" title="" class="easyui-datagrid scrollbarx" 
		style="width:auto; height: auto;" 
		data-options="
		url:'<?php echo base_url().'index.php/bulanan/getListLaporanBulanan';?>',
		toolbar:'#toolbar',rownumbers:true,pagination:true,border:false,
		striped:true,fit:true,fitColumns:true,
		singleSelect:true,collapsible:false" nowrap="false">
			<thead>
				<tr>
					<th field="kode_obat" hidden="true" width="100" sortable="true" >KODE OBAT</th>
					<th field="nama" width="100" sortable="true">NAMA OBAT</th>
					<th field="satuan" width="100" sortable="true">SATUAN</th>
					<th field="stok_awal" width="100" sortable="true">STOK AWAL</th>
					<th field="masuk" width="100" sortable="true">OBAT MASUK</th>
					<th field="resep" width="100" sortable="true">RESEP</th>		
					<th field="retur" width="100" sortable="true">OBAT EXPIRED</th>		
					<th field="saldo" width="100" sortable="true">SALDO</th>
				</tr>
			</thead>
		</table>
		
		<div id="toolbar" style='padding:5px;height:25px'>
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
				</tr>
			</div>
			<div style="display:inline;float:right;padding-top:-10px;">
				<input id="speriksa" class="easyui-searchbox" style="width:250px" 
				searcher="carirekab" prompt="Ketik disini" menu="#muser"></input>  
				<div id="muser" style="width:150px"> 
					<div name='nama'>NAMA</div>
				</div>  
			</div>
		</div>
<script>
	
	
	function carirekab(value,name){
		
		$('#datagrid-m_rekab').datagrid('load', { "searchKey": name, "searchValue": value });
	}

	function tampilkan() {
		var tgl_awal = $('#tgl_awal').datebox('getValue');
		var tgl_akhir = $('#tgl_akhir').datebox('getValue');

		$('#datagrid-m_rekab').datagrid('load',{"tgl_awal" : tgl_awal, "tgl_akhir" : tgl_akhir});
	}

	
	function cetakLaporan(){
        var tgl_awal = $('#tgl_awal').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        var tgl_akhir = $('#tgl_akhir').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter("http://localhost/poliklinik1/index.php/bulanan/cetakLaporan/"+tgl_awal+"/"+tgl_akhir,"LAPORAN BULANAN","800","400");
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