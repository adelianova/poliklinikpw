    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="en" />
		<meta name="robots" content="noindex,nofollow" />
		<script type="text/javascript"> 
			var base_url = "<?php print base_url(); ?>";	
		</script>
		<link rel="shortcut icon" href="<?php echo base_url().'asset/img/admin/favicon.ico';?>"/>
		
		<?php echo @$metadata; ?>
		<title><?php echo @$judul; ?></title>
		<style>
	.layout-panel-center .panel-title{
		text-align:right;
		padding-right:10px;
	}
	</style>

	</head>
	<body class="easyui-layout dashboard" style="overflow-y: hidden" scroll="no">
    <div data-options="region:'north',border:false" style="height:70px;background:#a1caf4;padding:10px; background-image:url(<?php echo base_url();?>asset/img/admin/banner.png); background-repeat:no-repeat; background-position:center left;">

		   <div class="tagNameArea">

		 	<span>Logged, <strong style="color:#2c3e50;"><?php echo $this->session->userdata('name');?>&nbsp;&nbsp;&nbsp;</strong></span> 
		 	<div data-options="iconCls:'icon-unlock'">
		 	<a href='javascript:void(0)' class="easyui-linkbutton" role="button" onClick='logout()' style="overflow-y: hidden">&nbsp; Log Out &nbsp; </a>
		 	<!-- <a href="main" class="easyui-linkbutton" role="button"> Dashboard </a> -->
		 	</div>
			
		</div>
    	
    </div>
	<div region="west" split="true" title="Navigator" style="width:250px;" class='content_main'>
	<a href="main" style='padding:30px' animate="true" lines="true"> Dashboard </a> <br>
	<a href="home" style='padding:30px' animate="true" lines="true"> Info </a>
	<ul id='tree-menu' class="easyui-tree" style='padding:10px' animate="true" lines="true">
	</ul>
    </div>
    <div id="content" region="center" title=""  class='content_footer' style='overflow:hidden'> 
	    <div id='content_tab' class="easyui-tabs isinya" border='false' fit="true" cache='false'>
        <div id='isi_content' title="Main Content" style='overflow:hidden' iconCls='icon-paper'>
        	<div class="easyui-draggable easyui-resizable" data-options="handle:'#title'" style="width:800px;height:200px;background:#fafafa;border:1px solid #ccc;margin-top:10px">
        		<div id="title" style="padding:5px;background:#93bcff;color:#fff">Kontrak Dokter Yang Akan Selesai</div>
        		<table id="datagrid-m_kontrak" title="" class="easyui-datagrid scrollbarx" 
					style="width:auto; height: auto;" 
					data-options="
					url:'<?php echo base_url().'index.php/user/getKontrak';?>',
					toolbar:'#toolbar',rownumbers:true,border:true,
					striped:true,fit:true,fitColumns:true,
					singleSelect:true,collapsible:false">
						<thead>
							<tr>
								<th field="id_kontrak" width="100" sortable="true" hidden="true">ID KONTRAK</th>
								<th field="kode_dokter" width="100" sortable="true" hidden="true">KODE DOKTER</th>
								<th field="nomor" width="100" sortable="true">NOMOR KONTRAK</th>
								<th field="mulai_kontrak" width="100" sortable="true">TANGGAL MULAI </th>
								<th field="selesai_kontrak" width="100" sortable="true">TANGGAL SELESAI</th>
								<th field="keterangan" width="100" sortable="true">KETERANGAN</th>
								<th field="nama_dokter" width="100" sortable="true">NAMA DOKTER</th>
								<th field="sisa_kontrak" width="120" sortable="true">SISA WAKTU (Bulan)</th>
								
							</tr>
						</thead>
				</table>
    		</div>
<!-- 
    		<div class="easyui-draggable easyui-resizable" data-options="handle:'#title'" style="width:800px;height:200px;background:#fafafa;border:1px solid #ccc;margin-top:10px">
        		<div id="title" style="padding:5px;background:#93bcff;color:#fff">Obat Yang Akan Expired</div>
        		<table id="datagrid-m_expired" title="" class="easyui-datagrid scrollbarx" 
					style="width:auto; height: auto;" 
					data-options="
					url:'<?php echo base_url().'index.php/user/getExpired';?>',
					toolbar:'#toolbar',rownumbers:true,border:true,
					striped:true,fit:true,fitColumns:true,
					singleSelect:true,collapsible:false">
						<thead>
							<tr>
								<th field="id_dtl_stock" width="100" sortable="true" hidden="true">ID DETAIL STOCK</th>
								<th field="id_stock" width="100" sortable="true" hidden="true">ID STOCK</th>
								<th field="id_obat" width="100" sortable="true" hidden="true">ID OBAT</th>
								<th field="nama" width="100" sortable="true">NAMA</th>
								<th field="qty" width="100" sortable="true">QTY</th>
								<th field="tgl_expired" width="100" sortable="true">TANGGAL EXPIRED</th>
								<th field="sisa_waktu" width="100" sortable="true">SISA WAKTU (Bulan)</th>								
							</tr>
						</thead>
				</table>
    		</div> -->

		</div>
		</div>
    </div>
	<div data-options="region:'south',border:false" style="background:#2980b9; color:#ecf0f1; padding:10px; text-align:center;">SIM PDAM Kota Malang</div>


	</body>
</html>
<script>
	$(function(){
		$('#tree-menu').tree({    
		animate:true,
		url:base_url+'index.php/user/getDefaultMenu',
		onClick: function open1(node){
			var login='';
			$.ajax({
				url:base_url+'index.php/user/isLogin',
				async:false,
				success:function(result){
					login=result;
					
				}
			});
			if(login=='1'){
			if(node.akses==true){
			
			$('#content_tab').tabs("close", 0);
			$('.easyui-dialog').dialog('destroy');
			$('.datagrid-toolbar').remove();
			$('#content_tab').tabs('add', {
				
					title: node.text,
					iconCls:node.iconCls,	
					cache:false,
					href:base_url+'index.php/dashboard/load_page/'+node.url
					
				
			});
			}
			}else{
			window.location=base_url+'index.php/login';
			}
			
		
		}
		});
		

	});
		
	function logout(){
		window.location=base_url+'index.php/logout';
		return false;
	}
</script>