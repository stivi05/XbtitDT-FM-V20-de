<script type="text/javascript">
<!--
function bbshout(repdeb, repfin) {
  var input = document.forms['chatForm'].elements['chatbarText'];
  input.focus();

  if(typeof document.selection != 'undefined') {

    var range = document.selection.createRange();
    var insText = range.text;
    range.text = repdeb + insText + repfin;

    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -repfin.length);
    } else {
      range.moveStart('character', repdeb.length + insText.length + repfin.length);
    }
    range.select();
  }

  else if(typeof input.selectionStart != 'undefined')
  {

    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + repdeb + insText + repfin + input.value.substr(end);

    var pos;
    if (insText.length == 0) {
      pos = start + repdeb.length;
    } else {
      pos = start + repdeb.length + insText.length + repfin.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }

  else
  {

    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Insertion à la position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }

    var insText = prompt("Veuillez entrer le texte à formater:");
    input.value = input.value.substr(0, pos) + repdeb + insText + repfin + input.value.substr(pos);
  }
}

function bbcolor() {
	var colorvalue = document.forms['chatForm'].elements['color'].value;
	bbshout("[color="+colorvalue+"]", "[/color]");
}

function bbfont() {
	var fontvalue = document.forms['chatForm'].elements['font'].value;
	bbshout("[font="+fontvalue+"]", "[/font]");
}
function bbsize() {
    var sizevalue = document.forms['chatForm'].elements['size'].value;
    bbshout("[size="+sizevalue+"]", "[/size]");
}
//-->
</script>

<?php

function shoutfun(){
echo "<center><table border=0 cellpadding=0 cellspacing=2><tr>";
echo "<tr>";
echo "<td width=22><a href=\"javascript:bbshout('[marquee]', '[/marquee]')\"><img src=images/bbcode/bbcode_marquee.gif border=0 alt='Marquee'></a></td>";
echo "<td width=22><a href=\"javascript:bbshout('[b]', '[/b]')\"><img src=images/bbcode/bbcode_bold.gif border=0 alt='Bold'></a></td>";
echo "<td width=22><a href=\"javascript:bbshout('[i]', '[/i]')\"><img src=images/bbcode/bbcode_italic.gif border=0 alt='Italic'></a></td>";
echo "<td width=22><a href=\"javascript:bbshout('[u]', '[/u]')\"><img src=images/bbcode/bbcode_underline.gif border=0 alt='Underline'></a></td>";
echo "<td width=22><a href=\"javascript:bbshout('[url]', '[/url]')\"><img src=images/bbcode/bbcode_url.gif border=0 alt='Url'></a></td>";

echo "<td width=22><a href=\"javascript:bbshout('https://www.youtube.com/watch?v=', '')\"><img src=images/bbcode/bbcode_video.gif border=0 alt='youtube'></a></td>";
echo "<td width=22><a href=\"javascript:bbshout('[img]', '[/img]')\"><img src=images/bbcode/bbcode_image.gif border=0 alt='Img'></a></td>";


echo "<td>
<select name='color' size=\"1\" onChange=\"javascript:bbcolor()\">
<option selected='selected'>COLOR</option>
<option value=skyblue style=color:skyblue>sky blue</option>
<option value=royalblue style=color:royalblue>royal blue</option>
<option value=blue style=color:blue>blue</option>
<option value=darkblue style=color:darkblue>dark-blue</option>
<option value=orange style=color:orange>orange</option>
<option value=orangered style=color:orangered>orange-red</option>
<option value=crimson style=color:crimson>crimson</option>
<option value=red style=color:red>red</option>
<option value=firebrick style=color:firebrick>firebrick</option>
<option value=darkred style=color:darkred>dark red</option>
<option value=green style=color:green>green</option>
<option value=limegreen style=color:limegreen>limegreen</option>
<option value=seagreen style=color:seagreen>sea-green</option>
<option value=deeppink style=color:deeppink>deeppink</option>
<option value=tomato style=color:tomato>tomato</option>
<option value=coral style=color:coral>coral</option>
<option value=purple style=color:purple>purple</option>
<option value=indigo style=color:indigo>indigo</option>
<option value=burlywood style=color:burlywood>burlywood</option>
<option value=sandybrown style=color:sandybrown>sandy brown</option>
<option value=sienna style=color:sienna>sienna</option>
<option value=chocolate style=color:chocolate>chocolate</option>
<option value=teal style=color:teal>teal</option>
<option value=silver style=color:silver>silver</option>
</select></td>";

echo "<td>
<select name='size' size=\"1\" onChange=\"javascript:bbsize()\">
<option selected='selected'>Size</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
</select></td>";
echo "</tr></table></center>";
}
?>