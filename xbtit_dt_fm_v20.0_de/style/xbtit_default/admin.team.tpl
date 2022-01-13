<tag:success />
<tag:sure />
<tag:edit />
<tag:add_team />
<tag:close />
<tag:pagertop />
<tag:current />
<loop:teams>
<tr><td class=lista style="text-align:center"><b><tag:teams[].id /></b> </td> <td class=lista align=center style="text-align:center"><img src='<tag:teams[].image />' border=0></td> <td class=lista style="text-align:center"><b><tag:teams[].name /></b></td><td class=lista style="text-align:center"><a href=index.php?page=userdetails&id=<tag:teams[].owner />><tag:teams[].OWNERNAME /></a></td><td class=lista style="text-align:center"><tag:teams[].info /></td><td class=lista style="text-align:center"><tag:teams[].edbj />&nbsp;<tag:teams[].delb /></td></tr>
</loop:teams>
<tag:end />
<tag:pagerbottom />