{************************************
* BANDEAU CNIL - TPL
*************************************}
<style type="text/css">
.bandeaucnilcookies {
	display:none;
	position:fixed;
	{if {$position_bandeau} == 1}bottom:0;{else}top:0;{/if}
	width:100%;
	min-height:41px;
	background:{$bg_color};
	color:{$font_color};
	z-index:10000;	
	padding:2px;
	font-size:13px;
}
.bandeaucnilcookies p{
	margin:0;
	padding-top:2px;
}
.texteBandeau{
	width:80%;
	float:left;
	margin:8px 0px 8px 15px;
	font-weight:bold;
}
.btnAcceptContainer {
	margin-top:5px;
	min-width:5%;	
	float:left;
	text-align:right;
	float:right;
	margin-right:15px;
}
.btnAcceptContainer p{
	padding-top:14px;
}
.bandeaucnilcookies .btn {
	background:{$btn_bg_color};
	color:{$btn_font_color};
	padding:4px 8px;
	height:27px;
	border-radius:2px;
	cursor:pointer;
}
.bandeaucnilcookies .btn:hover {
	color:{$btn_bg_color};
	background:{$btn_font_color};
}

@media(max-width:767px){ 
.bandeaucnilcookies, .bandeaucnilcookies .btn { font-size:11px; }
.bandeaucnilcookies .btn { padding:5px 8px 0px; }
.texteBandeau { width:100%;text-align:center;margin-bottom:0px;margin-left:0;padding:3px; } 
.btnAcceptContainer { width:100%;text-align:center;margin-bottom:10px; } 
}
</style>

<div id="bandeauCNIL" class="bandeaucnilcookies">

    <div class="texteBandeau">
    	<p>{$texte_bandeau}</p>
    </div>
    <div class="btnAcceptContainer">
    	<a class="btn" id="confirmBtn" onclick="acceptCookies();">{$texte_bouton}</a>
    </div>
    
</div>
