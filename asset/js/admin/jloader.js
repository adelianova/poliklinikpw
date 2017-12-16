/**
 *   Page loaded in wait for the page  
 *
 * @author gxjiang
 * @date 2010/7/24
 *
 */

 //var _html = "<div id='loading' style='position:fixed;left:0;top:0;width:100%;height:100%;background:#000;opacity:0.8;filter:alpha(opacity=100);z-index:9999;color:#fff';font-size:25px;text-align:center;padding-top:300px;>Loading, please wait  ...</div></div>";
  var _html = "<div id='loading' style='position: fixed;top: 0;left: 0;background-color: #fff;	opacity: 1.0;z-index: 9999;text-align: center;width: 100%;height: 100%;padding-top: 300px;font-size: 14px;font-weight:bold;color: #555;'><img src='"+base_url+'asset/img/admin/loader.gif'+"'/><br/>LOADING</div>";
 
   
 window.onload = function(){  
    var _mask = document.getElementById('loading');  
    _mask.parentNode.removeChild(_mask);  
 };  
  
       
 
 document.write(_html);
 
   
 /*$(document).ready(function(){  
    $("#loading").remove();  
 });*/
 