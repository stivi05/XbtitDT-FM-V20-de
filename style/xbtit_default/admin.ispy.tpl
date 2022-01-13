<table class="header" width="100%" align="center">
  <tr>
    <td class="lista" colspan="6"><tag:pager_top /></td>
  </tr>
  <tr>
    <td class="header"><b>Sender</b></td>
    <td class="header"><b>Reciever</b></td>
    <td class="header"><b>Message</b></td>
    <td class="header"><b>Send date</b></td>
    <td class="header"><b>Readed</b></td>
    <td class="header"><b>Delete</b></td>
  </tr>
  <loop:spy>
  <tr>
    <td class="lista"><tag:spy[].sender /></td>
    <td class="lista"><tag:spy[].receiver /></td>
    <td class="lista"><tag:spy[].msg /></td>
    <td class="lista"><tag:spy[].added /></td>
    <td class="lista"><tag:spy[].readed /></td>
    <td class="lista"><tag:spy[].delete /></td>
  </tr>
  </loop:spy>
  <tr>
    <td class="lista" colspan="6"><tag:pager_bottom /></td>
  </tr>
</table>