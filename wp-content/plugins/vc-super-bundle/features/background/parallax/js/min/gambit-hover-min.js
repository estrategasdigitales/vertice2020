document.addEventListener("DOMContentLoaded",function(){var t=document.querySelectorAll(".gambit_hover_row");if(Array.prototype.forEach.call(t,function(t,e){var a=document.gambitFindElementParentRow(t);a.style.overflow="hidden",a.classList.add("has_gambit_hover_row");var r=0;try{r=navigator.userAgent.match(/(MSIE |Trident.*rv[ :])([0-9]+)/)[2]}catch(i){}var o=document.createElement("div");o.classList.add("gambit_hover_inner"),o.setAttribute("data-type",t.getAttribute("data-type")),o.setAttribute("data-amount",t.getAttribute("data-amount")),o.setAttribute("data-inverted",t.getAttribute("data-inverted")),o.style.opacity=Math.abs(parseFloat(t.getAttribute("data-opacity"))/100),o.style.backgroundImage="url("+t.getAttribute("data-bg-image")+")","11"===r&&o.classList.add("gambit_ie11_hover_fix");var n=0;n="tilt"===t.getAttribute("data-type")?.6*-parseInt(t.getAttribute("data-amount"),10)+"%":-parseInt(t.getAttribute("data-amount"),10)+"px",o.style.top=n,o.style.left=n,o.style.right=n,o.style.bottom=n,o.style.zIndex=t.style.zIndex,a.insertBefore(o,a.firstChild)}),!navigator.userAgent.match(/(Mobi|Android)/)){var t=document.querySelectorAll(".has_gambit_hover_row");Array.prototype.forEach.call(t,function(t,e){t.addEventListener("mousemove",function(t){for(var e=t.target.parentNode;!e.classList.contains("has_gambit_hover_row");){if("HTML"===e.tagName)return;e=e.parentNode}var a=e.getBoundingClientRect(),r=t.pageY-(a.top+window.pageYOffset),i=t.pageX-(a.left+window.pageXOffset);r/=e.clientHeight,i/=e.clientWidth;var o=e.querySelectorAll(".gambit_hover_inner");Array.prototype.forEach.call(o,function(t,e){var a,o=parseFloat(t.getAttribute("data-amount")),n="true"===t.getAttribute("data-inverted");if("tilt"===t.getAttribute("data-type")){var s=i*o-o/2,l=(1-r)*o-o/2;n&&(s=(1-i)*o-o/2,l=r*o-o/2),a="perspective(2000px) ",a+="rotateY("+s+"deg) ",a+="rotateX("+l+"deg) ",t.style.webkitTransition="all 0s",t.style.transition="all 0s",t.style.webkitTransform=a,t.style.transform=a}else{var d=i*o-o/2,u=r*o-o/2;n&&(d*=-1,u*=-1),a="translate3D("+d+"px, "+u+"px, 0) ",t.style.webkitTransition="all 0s",t.style.transition="all 0s",t.style.webkitTransform=a,t.style.transform=a}})}),t.addEventListener("mouseout",function(t){for(var e=t.target.parentNode;!e.classList.contains("has_gambit_hover_row");){if("HTML"===e.tagName)return;e=e.parentNode}if(!t.relatedTarget||!e.contains(t.relatedTarget)){var a=e.querySelectorAll(".gambit_hover_inner");Array.prototype.forEach.call(a,function(t,e){parseFloat(t.getAttribute("data-amount"));t.style.webkitTransition="all 3s ease-in-out",t.style.transition="all 3s ease-in-out","tilt"===t.getAttribute("data-type")?(t.style.webkitTransform="perspective(2000px) rotateY(0) rotateX(0)",t.style.transform="perspective(2000px) rotateY(0) rotateX(0)"):(t.style.webkitTransform="translate3D(0, 0, 0)",t.style.transform="translate3D(0, 0, 0)")})}})})}});