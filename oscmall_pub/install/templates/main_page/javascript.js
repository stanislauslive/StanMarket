/*
  Copyright (c) 2002 - 2006 SystemsManager.Net

  SystemsManager Technologies
  oscMall System Version 4
  http://www.systemsmanager.net
  
  Portions Copyright (c) 2002 osCommerce
  
  This source file is subject to version 2.0 of the GPL license,   
  that is bundled with this package in the file LICENSE. If you
  did not receive a copy of the oscMall System license and are unable 
  to obtain it through the world-wide-web, please send a note to    
  license@systemsmanager.net so we can mail you a copy immediately.
*/

function toggleBox(szDivID) {
  if (document.layers) { // NN4+
    if (document.layers[szDivID].visibility == 'visible') {
      document.layers[szDivID].visibility = "hide";
      document.layers[szDivID].display = "none";
      document.layers[szDivID+"SD"].fontWeight = "normal";
    } else {
      document.layers[szDivID].visibility = "show";
      document.layers[szDivID].display = "inline";
      document.layers[szDivID+"SD"].fontWeight = "bold";
    }
  } else if (document.getElementById) { // gecko(NN6) + IE 5+
    var obj = document.getElementById(szDivID);
    var objSD = document.getElementById(szDivID+"SD");

    if (obj.style.visibility == 'visible') {
      obj.style.visibility = "hidden";
      obj.style.display = "none";
      objSD.style.fontWeight = "normal";
    } else {
      obj.style.visibility = "visible";
      obj.style.display = "inline";
      objSD.style.fontWeight = "bold";
    }
  } else if (document.all) { // IE 4
    if (document.all[szDivID].style.visibility == 'visible') {
      document.all[szDivID].style.visibility = "hidden";
      document.all[szDivID].style.display = "none";
      document.all[szDivID+"SD"].style.fontWeight = "normal";
    } else {
      document.all[szDivID].style.visibility = "visible";
      document.all[szDivID].style.display = "inline";
      document.all[szDivID+"SD"].style.fontWeight = "bold";
    }
  }
}

function changeStyle(what, how) {
  if (document.getElementById) {
    document.getElementById(what).style.fontWeight = how;
  } else if (document.all) {
    document.all[what].style.fontWeight = how;
  }
}

function changeText(where, what) {
  if (document.getElementById) {
    document.getElementById(where).innerHTML = what;
  } else if (document.all) {
    document.all[where].innerHTML = what;
  }
}
