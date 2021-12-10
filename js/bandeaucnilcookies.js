/* Module Bandeau CNIL - JS 
 * Auteur: Hadrien Boyer
 */

function checkCNILBandeau() {
    if (document.cookie.indexOf("cnilcookie28393x") < 0) {
    	document.getElementById("bandeauCNIL").style.display = "block";
    }
}

function acceptCookies() {
	document.cookie = "gyz$xx=cnilcookie28393x; expires=" + (new Date(2021,0,1)).toUTCString();
	document.getElementById('bandeauCNIL').style.display='none';
	document.getElementById('confirmBtn').style.display='none';
	return false;
}

window.onload = checkCNILBandeau;
