(function(t){var e={};function n(o){if(e[o]){return e[o].exports}var l=e[o]={i:o,l:false,exports:{}};t[o].call(l.exports,l,l.exports,n);l.l=true;return l.exports}n.m=t;n.c=e;n.d=function(t,e,o){if(!n.o(t,e)){Object.defineProperty(t,e,{configurable:false,enumerable:true,get:o})}};n.r=function(t){Object.defineProperty(t,"__esModule",{value:true})};n.n=function(t){var e=t&&t.__esModule?function e(){return t["default"]}:function e(){return t};n.d(e,"a",e);return e};n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)};n.p=".";return n(n.s=0)})({"./src/fullWidth.js":function(t,e){(function(){if(typeof window.vceResetFullWidthElements!=="undefined"){return}let t=undefined;const e='[data-vcv-layout-zone="header"]';const n='[data-vcv-layout-zone="footer"]';const o=".vcv-editor-theme-hf";function l(){t=Array.prototype.slice.call(document.querySelectorAll('[data-vce-full-width="true"],[data-vce-full-width-section="true"]'));if(t.length){i()}}function i(){if(!t.length){return}t.forEach(function(t){const l=document.body;const i=t.parentElement;const c=t.querySelector('[data-vce-element-content="true"]');const r=document.querySelector(".vce-full-width-custom-container");const u=parseInt(window.getComputedStyle(t,null)["margin-left"],10);const d=parseInt(window.getComputedStyle(t,null)["margin-right"],10);let s,f;if(t.closest(e)||t.closest(n)||t.closest(o)){return}if(document.body.contains(r)){s=0-i.getBoundingClientRect().left-u+r.getBoundingClientRect().left;f=r.getBoundingClientRect().width}else{s=0-i.getBoundingClientRect().left-u;f=document.documentElement.getBoundingClientRect().width}t.style.width=f+"px";if(l.classList.contains("rtl")){t.style.right=s+"px"}else{t.style.left=s+"px"}if(!t.getAttribute("data-vce-stretch-content")&&!t.getAttribute("data-vce-section-stretch-content")){let t=-1*s;if(t<0){t=0}let e=f-t-i.getBoundingClientRect().width+u+d;if(e<0){e=0}c.style["padding-left"]=t+"px";c.style["padding-right"]=e+"px"}else{c.style["padding-left"]="";c.style["padding-right"]=""}})}l();window.addEventListener("resize",i);window.vceResetFullWidthElements=l;window.vcv.on("ready",function(){window.vceResetFullWidthElements&&window.vceResetFullWidthElements()})})()},0:function(t,e,n){t.exports=n("./src/fullWidth.js")}});