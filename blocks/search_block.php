 <?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam
//
//    This file is part of xbtit DT FM.
//
// Redistribution and use in source and binary forms, with or without modification,
// are permitted provided that the following conditions are met:
//
//   1. Redistributions of source code must retain the above copyright notice,
//      this list of conditions and the following disclaimer.
//   2. Redistributions in binary form must reproduce the above copyright notice,
//      this list of conditions and the following disclaimer in the documentation
//      and/or other materials provided with the distribution.
//   3. The name of the author may not be used to endorse or promote products
//      derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
// WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
// MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
// IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
// SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
// TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
// PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
// LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
// NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
// EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//
////////////////////////////////////////////////////////////////////////////////////
?>
 
  <table border="0" align="center" class="blocklist">
<form action="index.php" method="get" name="torrent_search">
  <input type="hidden" name="page" value="torrents" />

      <td><input
      onfocus="if (this.value == 'Torrents') this.value='';"
   onblur="if(this.value == '') this.value='Torrents';"
      type="text" name="search" size="15" maxlength="50" value="Torrents" /></td>
</form>

  <form action="index.php" method="get" name="user_search">
  <input type="hidden" name="page" value="users" />
      <td><input
      onfocus="if (this.value == 'Users') this.value='';"
   	  onblur="if(this.value == '') this.value='Gebruikers';"
      type="text" name="searchtext" size="15" maxlength="50" value="Users" /></td>
      <input type="hidden" name="level" value="0" />
  </form>

  <form action="index.php?" method="get" name="smf_forum_search">
  <input type="hidden" name="page" value="forum" />
  <input type="hidden" name="action" value="search2" />
  <td><input
   onfocus="if (this.value == 'Forums') this.value='';"
   onblur="if(this.value == '') this.value='Forums';"
  type="text" name="search" size="15" maxlength="50" value="Forums" /></td>
  </form>

<form action="http://www.google.com/search" method="get" name="google_search">
      <td><input
      onfocus="if (this.value == 'Google') this.value='';"
      onblur="if(this.value == '') this.value='Google';"
      type="text" name="q" size="15" maxlength="50" value="Google" /></td>
  </form>
</table>