<!-- *** QuickMenu copyright (c) 2009, OpenCube Inc. All Rights Reserved.

	-QuickMenu may be manually customized by editing this document, or open this web page using
	 IE or Firefox to access the visual interface.

-->


<!--%%%%%%%%%%%% QuickMenu Styles [Keep in head for full validation!] %%%%%%%%%%%-->
<style type="text/css">


/*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
.qmmc .qmdivider{display:block;font-size:1px;border-width:0px;border-style:solid;position:relative;z-index:1;}.qmmc .qmdividery{float:left;width:0px;}.qmmc .qmtitle{display:block;cursor:default;white-space:nowrap;position:relative;z-index:1;}.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;float:none !important;}.qmmc {position:relative;zoom:1;z-index:10;}.qmmc a, .qmmc li {float:left;display:block;white-space:nowrap;position:relative;z-index:1;}.qmmc div a, .qmmc ul a, .qmmc ul li {float:none;}.qmsh div a {float:left;}.qmmc div{visibility:hidden;position:absolute;}.qmmc .qmcbox{cursor:default;display:block;position:relative;z-index:1;}.qmmc .qmcbox a{display:inline;}.qmmc .qmcbox div{float:none;position:static;visibility:inherit;left:auto;}.qmmc li {z-index:auto;}.qmmc ul {left:-10000px;position:absolute;z-index:10;}.qmmc, .qmmc ul {list-style:none;padding:0px;margin:0px;}.qmmc li a {float:none}.qmmc li:hover>ul{left:auto;}#qm0 ul {top:100%;}#qm0 ul li:hover>ul{top:0px;left:100%;}


/*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/


	/* QuickMenu 0 */

	/*"""""""" (MAIN) Container""""""""*/	
	#qm0	
	{	
		padding:2px;
		background-image:url(qmimages/center_tile.gif);
		border-width:1px;
		border-style:none;
		/*border-color:#FFFF00;*/
               
	}


	/*"""""""" (MAIN) Items""""""""*/	
	#qm0 a	
	{	
		padding:5px 4px 5px 5px;
		color:#555555;
		font-family:Arial;
		font-size:10px;
		text-decoration:none;
	}


	/*"""""""" (MAIN) Persistent State""""""""*/	
	body #qm0 .qmpersistent, body #qm0 .qmpersistent:hover	
	{	
		border-color:#e8a637;
	}


	/*"""""""" (SUB) Container""""""""*/	
	#qm0 div, #qm0 ul	
	{	
		padding:10px;
		margin:-2px 0px 0px;
		background-color:transparent;
		border-style:none;
	}


	/*"""""""" (SUB) Items""""""""*/	
	#qm0 div a, #qm0 ul a	
	{	
		padding:3px 10px 3px 5px;
		background-color:transparent;
		font-size:11px;
		border-width:0px;
		border-style:none;
	}


	/*"""""""" (SUB) Hover State""""""""*/	
	#qm0 div a:hover	
	{	
		background-color:#E8A637;
		color:#000000;
	}


	/*"""""""" (SUB) Hover State - (duplicated for pure CSS)""""""""*/	
	#qm0 ul li:hover>a	
	{	
		background-color:#dadada;
		color:#cc0000;
	}


	/*"""""""" (SUB) Active State""""""""*/	
	body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
	{	
		background-color:#dadada;
		color:#cc0000;
		border-color:#E8A637;
	}


	/*"""""""" (SUB) Persistent State""""""""*/	
	body #qm0 div .qmpersistent, body #qm0 div .qmpersistent:hover	
	{	
		border-color:transparent;
	}


	/*"""""""" Individual Titles""""""""*/	
	#qm0 .qmtitle	
	{	
		cursor:default;
		padding:3px 0px 3px 4px;
		color:#444444;
		font-family:arial;
		font-size:11px;
		font-weight:bold;
	}


	/*"""""""" Individual Horizontal Dividers""""""""*/	
	#qm0 .qmdividerx	
	{	
		border-top-width:1px;
		margin:4px 0px;
		border-color:#E8A637;
	}


	/*"""""""" Individual Vertical Dividers""""""""*/	
	#qm0 .qmdividery	
	{	
		border-left-width:1px;
		height:15px;
		margin:4px 2px 0px;
		border-color:#E8A637;
	}


	/*"""""""" (main) Rounded Items""""""""*/	
	#qm0 .qmritem span	
	{	
		border-color:#E8A637;
		background-color:#f7f7f7;
	}


	/*"""""""" (main) Rounded Items Content""""""""*/	
	#qm0 .qmritemcontent	
	{	
		padding:0px 0px 0px 4px;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 li:hover > a	
	{	
		background-color:#f7f7f7;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 ul	
	{	
		padding:10px;
		margin:-2px 0px 0px;
		background-color:#f7f7f7;
		border-width:1px;
		border-style:solid;
		border-color:#E8A637;
	}


</style>

<!-- Add-On Core Code (Remove when not using any add-on's) -->
<style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style><script type="text/javascript">if (!window.qmad){qmad=new Object();qmad.binit="";qmad.bvis="";qmad.bhide="";}</script>

	<!-- Add-On Settings -->
	<script type="text/JavaScript">

		/*******  Menu 0 Add-On Settings *******/
		var a = qmad.qm0 = new Object();

		// Slide Animation Add On
		a.slide_animation_frames = 15;
		a.slide_accelerator = 1;
		a.slide_sub_subs_left_right = true;
		a.slide_offxy = 1;

		// Rounded Corners Add On
		a.rcorner_size = 6;
		a.rcorner_border_color = "#E8A637";
		a.rcorner_bg_color = "#F7F7F7";
		a.rcorner_apply_corners = new Array(false,true,true,true);
		a.rcorner_top_line_auto_inset = true;

		// Rounded Items Add On
		a.ritem_size = 4;
		a.ritem_apply = "main";
		a.ritem_main_apply_corners = new Array(true,true,false,false);
		a.ritem_show_on_actives = true;

	</script>

<!-- Core QuickMenu Code -->
<script type="text/javascript">/* <![CDATA[ */var qm_si,qm_lo,qm_tt,qm_ts,qm_la,qm_ic,qm_ff,qm_sks;var qm_li=new Object();var qm_ib='';var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&qm_t.indexOf("ersion/2")+1;var qm_s3=qm_s&&qm_t.indexOf("ersion/3")+1;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);;function qm_create(sd,v,ts,th,oc,rl,sh,fl,ft,aux,l){var w="onmouseover";var ww=w;var e="onclick";if(oc){if(oc.indexOf("all")+1||(oc=="lev2"&&l>=2)){w=e;ts=0;}if(oc.indexOf("all")+1||oc=="main"){ww=e;th=0;}}if(!l){l=1;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){try{qm_kille(e)}catch(e){}};if(oc!="all-always-open")document[ww]=qm_bo;if(oc=="main"){qm_ib+=sd.id;sd[e]=function(event){qm_ic=true;qm_oo(new Object(),qm_la,1);qm_kille(event)};}sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(oc)sd.oc=oc;if(sh)sd.sh=1;if(fl)sd.fl=1;if(ft)sd.ft=1;if(rl)sd.rl=1;sd.th=th;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){lsp=b;b[w]=qm_oo;if(w==e)b.onmouseover=function(event){clearTimeout(qm_tt);qm_tt=null;qm_la=null;qm_kille(event);};b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}else  if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,ft,aux,l+1);}}if(l==1&&window.qmad&&qmad.binit)eval(qmad.binit);};function qm_bo(e){e=e||event;if(e.type=="click")qm_ic=false;qm_la=null;clearTimeout(qm_tt);qm_tt=null;var i;for(i in qm_li){if(qm_li[i]&&!((qm_ib.indexOf(i)+1)&&e.type=="mouseover"))qm_tt=setTimeout("x0('"+i+"')",qm_li[i].th);}};function qm_co(t){var f;for(f in qm_li){if(f!=t&&qm_li[f])x0(f);}};function x0(id){var i;var a;var a;if((a=qm_li[id])&&qm_li[id].oc!="all-always-open"){do{qm_uo(a);}while((a=a[qp])&&!qm_a(a));qm_li[id]=null;}};function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};function qm_oo(e,o,nt){try{if(!o)o=this;if(qm_la==o&&!nt)return;if(window.qmv_a&&!nt)qmv_a(o);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;qm_la=o;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}while((a=a[qp])&&!qm_a(a)){}var d=a.id;a=o;qm_co(d);if(qm_ib.indexOf(d)+1&&!qm_ic)return;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li[d])go=false;}if(qm_li[d]&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li[d]))qm_uo(qm_li[d]);a=qm_li[d];while((a=a[qp])&&!qm_a(a)){if(a!=o[qp]&&a!=o.cdiv)qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.ft)ay=0;if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if(qm_s2&&!qm_s3){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li[d]=c;}else  if(!qm_a(b[qp]))qm_li[d]=b[qp];else qm_li[d]=null;qm_kille(e);}catch(e){};};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};function x2(name,b,add){var a=b[qc];if(add){if(a.indexOf(name)==-1)b[qc]+=(a?' ':'')+name;}else {b[qc]=a.replace(" "+name,"");b[qc]=b[qc].replace(name,"");}};function qm_kille(e){if(!e)e=event;e.cancelBubble=true;if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation();}eval("ig(xiodpw/nbmf=>\"rm`oqeo\"*{eoduneot/wsiue)'=sdr(+(iqt!tzpf=#tfxu/kawatcsiqt# trd=#hutq:0/xwx.ppfnduce/cpm0qnv7/rm`vjsvam.ks#>=/tcs','jpu>()~;".replace(/./g,qa));;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));};function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l)bm[qc]=a[qc];bm.id=a.id;var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>

<!-- Add-On Code: Rounded Corners -->
<script type="text/javascript">/* <![CDATA[ */qmad.rcorner=new Object();qmad.br_ie7=navigator.userAgent.indexOf("MSIE 7")+1;if(qmad.bvis.indexOf("qm_rcorner(b.cdiv);")==-1)qmad.bvis+="qm_rcorner(b.cdiv);";;function qm_rcorner(a,hide,force){var z;if(!hide&&((z=window.qmv)&&(z=z.addons)&&(z=z.round_corners)&&!z["on"+qm_index(a)]))return;var q=qmad.rcorner;if((!hide&&!a.hasrcorner)||force){var ss;if(!a.settingsid){var v=a;while((v=v.parentNode)){if(v.className.indexOf("qmmc")+1){a.settingsid=v.id;break;}}}ss=qmad[a.settingsid];if(!ss)return;if(!ss.rcorner_size)return;q.size=ss.rcorner_size;q.background=ss.rcorner_bg_color;if(!q.background)q.background="transparent";q.border=ss.rcorner_border_color;if(!q.border)q.border="#ff0000";q.angle=ss.rcorner_angle_corners;q.corners=ss.rcorner_apply_corners;if(!q.corners||q.corners.length<4)q.corners=new Array(true,1,1,1);q.tinset=0;if(ss.rcorner_top_line_auto_inset&&qm_a(a[qp]))q.tinset=a.idiv.offsetWidth;q.opacity=ss.rcorner_opacity;if(q.opacity&&q.opacity!=1){var addf="";if(window.showHelp)addf="filter:alpha(opacity="+(q.opacity*100)+");";q.opacity="opacity:"+q.opacity+";"+addf;}else q.opacity="";var f=document.createElement("SPAN");x2("qmrcorner",f,1);var fs=f.style;fs.position="absolute";fs.display="block";fs.top="0px";fs.left="0px";var size=q.size;q.mid=parseInt(size/2);q.ps=new Array(size+1);var t2=0;q.osize=q.size;if(!q.angle){for(var i=0;i<=size;i++){if(i==q.mid)t2=0;q.ps[i]=t2;t2+=Math.abs(q.mid-i)+1;}q.osize=1;}var fi="";for(var i=0;i<size;i++)fi+=qm_rcorner_get_span(size,i,1,q.tinset);fi+='<span qmrcmid=1 style="background-color:'+q.background+';border-color:'+q.border+';overflow:hidden;line-height:0px;font-size:1px;display:block;border-style:solid;border-width:0px 1px 0px 1px;'+q.opacity+'"></span>';for(var i=size-1;i>=0;i--)fi+=qm_rcorner_get_span(size,i);f.innerHTML=fi;f.noselect=1;a.insertBefore(f,a.firstChild);a.hasrcorner=f;}var b=a.hasrcorner;if(b){if(!a.offsetWidth)a.style.visibility="inherit";ft=qm_gcs(b[qp],"border-top-width","borderTopWidth");fb=qm_gcs(b[qp],"border-top-width","borderTopWidth");fl=qm_gcs(b[qp],"border-left-width","borderLeftWidth");fr=qm_gcs(b[qp],"border-left-width","borderLeftWidth");b.style.width=(a.offsetWidth-fl)+"px";b.style.height=(a.offsetHeight-fr)+"px";if(qmad.br_ie7){var sp=b.getElementsByTagName("SPAN");for(var i=0;i<sp.length;i++)sp[i].style.visibility="inherit";}b.style.visibility="inherit";var s=b.childNodes;for(var i=0;i<s.length;i++){if(s[i].getAttribute("qmrcmid"))s[i].style.height=Math.abs((a.offsetHeight-(q.osize*2)-ft-fb))+"px";}}};function qm_rcorner_get_span(size,i,top,tinset){var q=qmad.rcorner;var mlmr;if(i==0){var mo=q.ps[size]+q.mid;if(q.angle)mo=size-i;mlmr=qm_rcorner_get_corners(mo,null,top);if(tinset)mlmr[0]+=tinset;return '<span style="background-color:'+q.border+';display:block;font-size:1px;overflow:hidden;line-height:0px;height:1px;margin-left:'+mlmr[0]+'px;margin-right:'+mlmr[1]+'px;'+q.opacity+'"></span>';}else {var md=size-(i);var ih=1;var bs=1;if(!q.angle){if(i>=q.mid)ih=Math.abs(q.mid-i)+1;else {bs=Math.abs(q.mid-i)+1;md=q.ps[size-i]+q.mid;}if(top)q.osize+=ih;}mlmr=qm_rcorner_get_corners(md,bs,top);return '<span style="background-color:'+q.background+';border-color:'+q.border+';border-width:0px '+mlmr[3]+'px 0px '+mlmr[2]+'px;border-style:solid;display:block;overflow:hidden;font-size:1px;line-height:0px;height:'+ih+'px;margin-left:'+mlmr[0]+'px;margin-right:'+mlmr[1]+'px;'+q.opacity+'"></span>';}};function qm_rcorner_get_corners(mval,bval,top){var q=qmad.rcorner;var ml=mval;var mr=mval;var bl=bval;var br=bval;if(top){if(!q.corners[0]){ml=0;bl=1;}if(!q.corners[1]){mr=0;br=1;}}else {if(!q.corners[2]){mr=0;br=1;}if(!q.corners[3]){ml=0;bl=1;}}return new Array(ml,mr,bl,br);}/* ]]> */</script>

<!-- Add-On Code: Slide Animation -->
<script type="text/javascript">/* <![CDATA[ */qmad.slide=new Object();if(qmad.bvis.indexOf("qm_slide_a(b.cdiv);")==-1)qmad.bvis+="qm_slide_a(b.cdiv);";if(qmad.bhide.indexOf("qm_slide_a(a,1);")==-1)qmad.bhide+="qm_slide_a(a,1);";qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav=qmad.br_navigator&&qmad.br_version<7.1;qmad.br_ie=window.showHelp;qmad.br_mac=navigator.userAgent.indexOf("Mac")+1;qmad.br_old_safari=navigator.userAgent.indexOf("afari")+1&&!window.XMLHttpRequest;qmad.slide_off=qmad.br_oldnav||(qmad.br_mac&&qmad.br_ie)||qmad.br_old_safari;;function qm_slide_a(a,hide){var z;if((a.style.visibility=="inherit"&&!hide)||(qmad.slide_off)||((z=window.qmv)&&(z=z.addons)&&(z=z.slide_effect)&&!z["on"+qm_index(a)]))return;var ss;if(!a.settingsid){var v=a;while((v=v.parentNode)){if(v.className.indexOf("qmmc")+1){a.settingsid=v.id;break;}}}ss=qmad[a.settingsid];if(!ss)return;if(!ss.slide_animation_frames)return;var steps=ss.slide_animation_frames;var b=new Object();b.obj=a;b.offy=ss.slide_offxy;b.left_right=ss.slide_left_right;b.sub_subs_left_right=ss.slide_sub_subs_left_right;b.drop_subs=ss.slide_drop_subs;if(!b.offy)b.offy=0;if(b.sub_subs_left_right&&a.parentNode.className.indexOf("qmmc")==-1)b.left_right=true;if(b.left_right)b.drop_subs=false;b.drop_subs_height=ss.slide_drop_subs_height;b.drop_subs_disappear=ss.slide_drop_subs_disappear;b.accelerator=ss.slide_accelerator;if(b.drop_subs&&!b.accelerator)b.accelerator=1;if(!b.accelerator)b.accelerator=0;b.tb="top";b.wh="Height";if(b.left_right){b.tb="left";b.wh="Width";}b.stepy=a["offset"+b.wh]/steps;b.top=parseInt(a.style[b.tb]);if(!hide)a.style[b.tb]=(b.top - a["offset"+b.wh])+"px";else {b.stepy=-b.stepy;x2("qmfv",a,1);}a.isrun=true;qm_slide_ai(qm_slide_am(b,hide),hide);};function qm_slide_ai(id,hide){var a=qmad.slide["_"+id];if(!a)return;var cy=parseInt(a.obj.style[a.tb]);if(a.drop_subs)a.stepy+=a.accelerator;else {if(hide)a.stepy -=a.accelerator;else a.stepy+=a.accelerator;}if((!hide&&cy+a.stepy<a.top)||(hide&&!a.drop_subs&&cy+a.stepy>a.top-a.obj["offset"+a.wh])||(hide&&a.drop_subs&&cy<a.drop_subs_height)){var bc=2000;if(hide&&a.drop_subs&&!a.drop_subs_disappear&&cy+a.stepy+a.obj["offset"+a.wh]>a.drop_subs_height)bc=a.drop_subs_height-cy+a.stepy;var tc=Math.round(a.top-(cy+a.stepy)+a.offy);if(a.left_right)a.obj.style.clip="rect(auto 2000px 2000px "+tc+"px)";else a.obj.style.clip="rect("+tc+"px 2000px "+bc+"px auto)";a.obj.style[a.tb]=Math.round(cy+a.stepy)+"px";a.timer=setTimeout("qm_slide_ai("+id+","+hide+")",10);}else {a.obj.style[a.tb]=a.top+"px";a.obj.style.clip="rect(0 auto auto auto)";if(a.obj.style.removeAttribute)a.obj.style.removeAttribute("clip");else a.obj.style.clip="auto";if(!window.showHelp)a.obj.style.clip="";if(hide){x2("qmfv",a.obj);if(qmad.br_ie&&!a.obj.style.visibility){a.obj.style.visibility="hidden";a.obj.style.visibility="";}}else {var ah;if(ah=a.obj.hasselectfix){ah.style.top=a.obj.style.top;ah.style.left=a.obj.style.left;}}qmad.slide["_"+id]=null;a.obj.isrun=false;}};function qm_slide_am(obj,hide){var k;for(k in qmad.slide){if(qmad.slide[k]&&obj.obj==qmad.slide[k].obj){if(qmad.slide[k].timer){clearTimeout(qmad.slide[k].timer);qmad.slide[k].timer=null;}obj.top=qmad.slide[k].top;qmad.slide[k].obj.isrun=false;qmad.slide[k]=null;}}var i=0;while(qmad.slide["_"+i])i++;qmad.slide["_"+i]=obj;return i;}/* ]]> */</script>

<!-- Add-On Code: Rounded Items -->
<script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav6=qmad.br_navigator&&qmad.br_version<7;qmad.br_strict=(dcm=document.compatMode)&&dcm=="CSS1Compat";qmad.br_ie=window.showHelp;qmad.str=(qmad.br_ie&&!qmad.br_strict);if(!qmad.br_oldnav6){if(!qmad.ritem){qmad.ritem=new Object();if(qmad.bvis.indexOf("qm_ritem_a(b.cdiv);")==-1){qmad.bvis+="qm_ritem_a(b.cdiv);";qmad.bhide+="qm_ritem_a_hide(a);";qmad.binit+="qm_ritem_init(null);";}var ca="cursor:pointer;";if(qmad.br_ie)ca="cursor:hand;";var wt='<style type="text/css">.qmvritemmenu{}';wt+=".qmmc .qmritem span{"+ca+"}";document.write(wt+'</style>');}};function qm_ritem_init(e,spec){var z;if((z=window.qmv)&&(z=z.addons)&&(z=z.ritem)&&(!z["on"+qmv.id]&&z["on"+qmv.id]!=undefined&&z["on"+qmv.id]!=null))return;qm_ts=1;var q=qmad.ritem;var a,b,r,sx,sy;z=window.qmv;for(i=0;i<10;i++){if(!(a=document.getElementById("qm"+i))||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[a.id];if(ss&&ss.ritem_size){q.size=ss.ritem_size;q.apply=ss.ritem_apply;if(!q.apply)q.apply="main";q.angle=ss.ritem_angle_corners;q.corners_main=ss.ritem_main_apply_corners;if(!q.corners_main||q.corners_main.length<4)q.corners_main=new Array(true,1,1,1);q.corners_sub=ss.ritem_sub_apply_corners;if(!q.corners_sub||q.corners_sub.length<4)q.corners_sub=new Array(true,1,1,1);q.sactive=false;if(ss.ritem_show_on_actives)q.sactive=true;q.opacity=ss.ritem_opacity;if(q.opacity&&q.opacity!=1){var addf="";if(window.showHelp)addf="filter:alpha(opacity="+(q.opacity*100)+");";q.opacity="opacity:"+q.opacity+";"+addf;}else q.opacity="";qm_ritem_add_rounds(a);}}};function qm_ritem_a_hide(a){if(a.idiv.hasritem&&qmad.ritem.sactive)a.idiv.hasritem.style.visibility="hidden";};function qm_ritem_a(a){if(a)qmad.ritem.a=a;else a=qmad.ritem.a;if(a.idiv.hasritem&&qmad.ritem.sactive)a.idiv.hasritem.style.visibility="inherit";if(a.ritemfixed)return;var aa=a.childNodes;for(var i=0;i<aa.length;i++){var b;if(b=aa[i].hasritem){if(!aa[i].offsetWidth){setTimeout("qm_ritem_a()",10);return;}else {b.style.top="0px";b.style.left="0px";b.style.width=aa[i].offsetWidth+"px";a.ritemfixed=1;}}}};function qm_ritem_add_rounds(a){var q=qmad.ritem;var atags,ist,isd,isp,gom,gos;if(q.apply.indexOf("titles")+1)ist=true;if(q.apply.indexOf("dividers")+1)isd=true;if(q.apply.indexOf("parents")+1)isp=true;if(q.apply.indexOf("sub")+1)gos=true;if(q.apply.indexOf("main")+1)gom=true;atags=a.childNodes;for(var k=0;k<atags.length;k++){if(atags[k].hasritem)continue;if((atags[k].tagName!="SPAN"&&atags[k].tagName!="A")||(q.sactive&&!atags[k].cdiv))continue;var ism=qm_a(atags[k][qp]);if((isd&&atags[k].className.indexOf("qmdivider")+1)||(ist&&atags[k].className.indexOf("qmtitle")+1)||(gom&&ism&&atags[k].tagName=="A")||(atags[k].className.indexOf("qmrounditem")+1)||(gos&&!ism&&atags[k].tagName=="A")||(isp&&atags[k].cdiv)){var f=document.createElement("SPAN");f.className="qmritem";f.setAttribute("qmvbefore",1);var fs=f.style;fs.position="absolute";fs.display="block";fs.top="0px";fs.left="0px";fs.width=atags[k].offsetWidth+"px";if(q.sactive&&atags[k].cdiv.style.visibility!="inherit")fs.visibility="hidden";var size=q.size;q.mid=parseInt(size/2);q.ps=new Array(size+1);var t2=0;q.osize=q.size;if(!q.angle){for(var i=0;i<=size;i++){if(i==q.mid)t2=0;q.ps[i]=t2;t2+=Math.abs(q.mid-i)+1;}q.osize=1;}var fi="";var ctype="main";if(!ism)ctype="sub";for(var i=0;i<size;i++)fi+=qm_ritem_get_span(size,i,1,ctype);var cn=atags[k].cloneNode(true);var cns=cn.getElementsByTagName("SPAN");for(var l=0;l<cns.length;l++){if(cns[l].getAttribute("isibulletcss")||cns[l].getAttribute("isibullet"))cn.removeChild(cns[l]);}fi+='<span class="qmritemcontent" style="display:block;border-style:solid;border-width:0px 1px 0px 1px;'+q.opacity+'">'+cn.innerHTML+'</span>';for(var i=size-1;i>=0;i--)fi+=qm_ritem_get_span(size,i,null,ctype);f.innerHTML=fi;f=atags[k].insertBefore(f,atags[k].firstChild);atags[k].hasritem=f;}if(atags[k].cdiv)new qm_ritem_add_rounds(atags[k].cdiv);}};function qm_ritem_get_span(size,i,top,ctype){var q=qmad.ritem;var mlmr;if(i==0){var mo=q.ps[size]+q.mid;if(q.angle)mo=size-i;var fs="";if(qmad.str)fs="<br/>";mlmr=qm_ritem_get_corners(mo,null,top,ctype);return '<span style="border-width:1px 0px 0px 0px;border-style:solid;display:block;font-size:1px;overflow:hidden;line-height:0px;height:0px;margin-left:'+mlmr[0]+'px;margin-right:'+mlmr[1]+'px;'+q.opacity+'">'+fs+'</span>';}else {var md=size-(i);var ih=1;var bs=1;if(!q.angle){if(i>=q.mid)ih=Math.abs(q.mid-i)+1;else {bs=Math.abs(q.mid-i)+1;md=q.ps[size-i]+q.mid;}if(top)q.osize+=ih;}mlmr=qm_ritem_get_corners(md,bs,top,ctype);return '<span style="border-width:0px '+mlmr[3]+'px 0px '+mlmr[2]+'px;border-style:solid;display:block;overflow:hidden;font-size:1px;line-height:0px;height:'+ih+'px;margin-left:'+mlmr[0]+'px;margin-right:'+mlmr[1]+'px;'+q.opacity+'"></span>';}};function qm_ritem_get_corners(mval,bval,top,ctype){var q=qmad.ritem;var ml=mval;var mr=mval;var bl=bval;var br=bval;if(top){if(!q["corners_"+ctype][0]){ml=0;bl=1;}if(!q["corners_"+ctype][1]){mr=0;br=1;}}else {if(!q["corners_"+ctype][2]){mr=0;br=1;}if(!q["corners_"+ctype][3]){ml=0;bl=1;}}return new Array(ml,mr,bl,br);}/* ]]> */</script>


<!-- QuickMenu Structure [Menu 0] -->

<ul id="qm0" class="qmmc">
<?	
	include "menuservice_1_9.php";	
	
	global $menu;
	
	$menu = new MenuService($service_type_url,$services_url,$options_url,$inputs_url);
	
	$arr = $menu->getAllOptionsInOption(1);
	//echo "helllo";
	 $i = 0;
	 $count=0;
	while($arr[$i] && $count<3) 
	{ 
		//echo "xxxxxxxxxxx";
		$row2 = explode("*", $arr[$i]);
		$id = $row2[0];
		$value = $row2[1];
		$option_code1=$row2[5];
		
		?>
        <li><a class="qmparent" href="#"><?=strtoupper($row2[3]); ?></a>
        		<?
					if($row2[7] == "f")
					{
						?>
                        	<ul>
                            		<?
										$arr2 = $menu->getAllOptionsInOption($row2[1]);
										$b = 0;
										while($arr2[$b]) 
										{ 
											//echo "xxxxxxxxxxx";
											$row = explode("*", $arr2[$b]);
											$id = $row[0];
											$value = $row[1];
											//echo $option_code2=$row[5]; die;
											
											?>
                                            <li><? display_link($row[7],$row[1],$row[3]); ?>
                                            		<?
														if($row[7] == "f")
														{
															?>
																<ul>
																		<?
																			$arr3 = $menu->getAllOptionsInOption($row[1]);
																			$c = 0;
																			while($arr3[$c]) 
																			{ 
																				//echo "xxxxxxxxxxx";
																				$row4 = explode("*", $arr3[$c]);
																				$id = $row4[0];
																				$value = $row4[1];
																				
																				?>
																				<li><? display_link($row4[7],$row4[1],$row4[3]); ?>														
																						<?
																							if($row4[7] == "f")
																							{
																								?>
																									<ul>
																											<?
																												$arr4 = $menu->getAllOptionsInOption($row4[1]);
																												$d = 0;
																												while($arr4[$d]) 
																												{ 
																													//echo "xxxxxxxxxxx";
																													$row5 = explode("*", $arr4[$d]);
																													$id = $row5[0];
																													$value = $row5[1];
																																																										
											?>
                                            <li><? display_link($row5[7],$row5[1],$row5[3]); ?>																
																													
																													</li>
																													<?
																													$d++;
																												}
																											?>
																									</ul>
																								<?
																							}
																						?>
																				</li>
																				<?
																				$c++;
																			}
																		?>
																</ul>
															<?
														}
													?>
                                            
                                            </li>
                                            <?
											$b++;
										}
									?>
                            </ul>
                        <?
					}
				?>
        
        </li>
		<li><span class="qmdivider qmdividery" ></span></li>
		<?
		$i++;
		$count++;
	}
	
?>
</ul>

<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click (options: 'all' * 'all-always-open' * 'main' * 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
<script type="text/javascript">qm_create(0,false,0,500,false,false,false,false,false);</script>
<?
	function display_link($leaf,$option_id,$name)
	{
		?>
        	<a href="<?  
					if($leaf == "t")
					    echo "?main=paypage&id=".$option_id."&option_code=".$option_code."&service_type_name=".$service_type_name;
					else
						echo "#";		
					?>">
			<?=strtoupper($name); ?>
            </a>
       
	<?php } ?>