jQuery(document).ready(function(i){"use strict";var t=null,n="";i(".wpb_edit_form_elements .svg_icon_button_field").each(function(){var n,t,e;n=i(this).prev(),t=function(t){n.html(t)},e=function(t){},wp.ajax.send("svg_get",{success:t,error:e,data:{nonce:i(this).attr("data-nonce"),icon:i(this).val()}})}).on("keyup",function(){var a;n!==i(this).val()&&(n=i(this).val(),null!==t&&(clearTimeout(t),t=null),a=i(this),t=setTimeout(function(){var t,n,e,s=a.parent().find(".svg_select_window");s.html("").show(),t=a.val(),n=function(t){var n,e;for(n in s.html("").show(),t)t.hasOwnProperty(n)&&((e=document.createElement("DIV")).classList.add(n),e.innerHTML=t[n],s.append(i(e)))},e=function(t){},wp.ajax.send("svg_search",{success:n,error:e,data:{nonce:a.attr("data-nonce"),search_terms:t}})},500))}),i(".wpb_edit_form_elements .svg_icon_button_field ~ .svg_select_window").on("click","div",function(){i(this).parents(".svg_select_window").parent().find("input").val(i(this).attr("class")).prev().html(i(this).html())})});