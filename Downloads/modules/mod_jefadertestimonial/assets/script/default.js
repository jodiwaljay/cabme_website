/***********************************************
* Translucent Slideshow script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

////NO need to edit beyond here/////////////

var delay = pause1; //set delay between message change (in miliseconds)
var maxsteps=40; // number of steps to take to change from start color to endcolor
var stepdelay=degree1; // time in miliseconds of a single step

if(trans_width1 == 100)
{
	var imagewidth = (100-25)/2;
	var trans_width1 = 75;
} else {
	var imagewidth = (100 - trans_width1)/2;
}

var startcolor	= new Array(starfonttcolor_r,starfonttcolor_g,starfonttcolor_b); // start color (red, green, blue)
var endcolor	= new Array(endfontcolor_r,endfontcolor_g,endfontcolor_b); // end color (red, green, blue)


//var startcolor= new Array(0,0,0); // start color (red, green, blue)
//var endcolor=new Array(0,255,255); // end color (red, green, blue)

var imageholder=new Array();

begintag='<div style="font:'+fontstyle1+' '+fontsize+'px'+' '+fontfamily+'; '+ 'padding:'+je_fadar_padding+'px;">'; //set opening tag, such as font declarations

for (i=0;i<slideshowcontent1.length;i++){
	imageholder[i]= new Image()
	imageholder[i].src=slideshowcontent1[i][0]
}

closetag='</div>';

var fadelinks=1; //should links inside scroller content also fade like text? 0 for no, 1 for yes.
var ie4=document.all&&!document.getElementById;
var DOM2=document.getElementById;
var faderdelay=0;
var index=0;

//function to change content
function changecontent(){
  if (index>=slideshowcontent1.length)
    index=0
  if (DOM2){
    document.getElementById("fscroller").style.color="rgb("+startcolor[0]+", "+startcolor[1]+", "+startcolor[2]+")"
    document.getElementById("fscroller").innerHTML=begintag+slideshowcontent1[index][0]+'<p style=text-align:right;>'+slideshowcontent1[index][1]+'<br/>'+slideshowcontent1[index][2]+slideshowcontent1[index][3]+'</p>'+'<div style="text-align:right;">'+slideshowcontent1[index][4]+'</div>'+closetag
    if (fadelinks)
      linkcolorchange(1);
    colorfade(1, 15);
  }
  else if (ie4)
    document.all.fscroller.innerHTML=begintag+slideshowcontent1[index]+closetag;
  index++
}



function linkcolorchange(step){
  var obj=document.getElementById("fscroller").getElementsByTagName("A");
  if (obj.length>0){
    for (i=0;i<obj.length;i++)
      obj[i].style.color=getstepcolor(step);
  }
}


var fadecounter;
function colorfade(step) {
  if(step<=maxsteps) {
    document.getElementById("fscroller").style.color=getstepcolor(step);
    if (fadelinks)
      linkcolorchange(step);
    step++;
    fadecounter=setTimeout("colorfade("+step+")",stepdelay);
  }else{
    clearTimeout(fadecounter);
    document.getElementById("fscroller").style.color="rgb("+endcolor[0]+", "+endcolor[1]+", "+endcolor[2]+")";
    setTimeout("changecontent()", delay);

  }
}


function getstepcolor(step) {
  var diff
  var newcolor=new Array(3);

  for(var i=0; i<3; i++) {
    diff = (startcolor[i]-endcolor[i]);

    if(diff > 0) {
      newcolor[i] = startcolor[i]-(Math.round((diff/maxsteps))*step);
    } else {
      newcolor[i] = startcolor[i]+(Math.round((Math.abs(diff)/maxsteps))*step);
    }
  }
  return ("rgb(" + newcolor[0] + ", " + newcolor[1] + ", " + newcolor[2] + ")");
}

if (ie4||DOM2)
  	document.write('<table style="background:'+bgcolor1+';" width="100%" height="'+trans_height1+'"><tr><td width="'+imagewidth+'%" id="style2-inner1-module">&nbsp;</td><td width="'+trans_width1+'%"><div id="fscroller" style="text-align:justify; font-weight:bold;"></div></td><td width="'+imagewidth+'%" id="style2-inner2-module">&nbsp;</td></tr></table>');
else if (document.layers){
	document.write('<ilayer id=tickernsmain visibility=hide width='+trans_width1+' height='+trans_height1+' bgcolor1='+bgcolor1+'><layer id=tickernssub width='+trans_width1+' height='+trans_height1+' left=0 top=0>'+'<div>'+slideshowcontent1[0][0]+'</div></layer></ilayer>')
}
if (window.addEventListener)
	window.addEventListener("load", changecontent, false)
else if (window.attachEvent)
	window.attachEvent("onload", changecontent)
else if (ie4||dom||document.layers)
	window.onload=changecontent

