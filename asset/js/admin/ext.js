function formatMoney(val) {
		
	return accounting.formatNumber(val, 0, ",", "."); // 4.999,99
};

$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
	};
	
	
$.fn.datebox.defaults.parser = function(s){
		if (!s) return new Date();
		var ss = s.split('-');

		var d = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var y = parseInt(ss[2],10);
		
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	};

$.extend($.fn.datagrid.defaults.editors, {
	combogrid: {
		init: function(container, options){
			var input = $('<input type="text" class="datagrid-editable-input">').appendTo(container); 
			input.combogrid(options);
			return input;
		},
		destroy: function(target){
			$(target).combogrid('destroy');
		},
		getValue: function(target){
			return $(target).combogrid('getValue');
		},
		setValue: function(target, value){
			$(target).combogrid('setValue', value);
		},
		resize: function(target, width){
			$(target).combogrid('resize',width);
		}
	}
});


$.extend($.fn.panel.methods,{
	clear: function(jq){
		return jq.each(function(){
			var t = $(this);
			t.find('.combo-f').each(function(){
				$(this).combo('destroy');
			});
			t.find('.m-btn').each(function(){
				$(this).menubutton('destroy');
			});
			t.find('.s-btn').each(function(){
				$(this).splitbutton('destroy');
			});
			t.find('.tooltip-f').each(function(){
				$(this).tooltip('destroy');
			});
			
			t.empty();
		})
	}
})

function formatDate(value,row){
  
  if(value!=null && value !=undefined){
  var date = new Date(value);
  var y = date.getFullYear();
  var m = date.getMonth()+1;
  var d = date.getDate();
  return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
  }else{
  return '';
  }
  
}

function formatDate2(dates){
  var date = new Date(dates);
  var y = date.getFullYear();
  var m = date.getMonth()+1;
  var d = date.getDate();
  return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;	
}