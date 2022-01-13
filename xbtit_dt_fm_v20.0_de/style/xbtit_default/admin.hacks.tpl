<if:ftp>
<form name="ftp_data" action="<tag:form_action />" method="post">
<input type="hidden" name="add_hack_folder" value="<tag:hack_folder />" />
<div align="center"><tag:language.HACK_WHY_FTP /></div>
<br />
<table class="lista" cellpadding="4" cellspacing="0">
  <tr>
    <td class="block" colspan="4" align="center"><tag:hack_title_action /></td>
  </tr>
  <tr>
    <td class="lista"><tag:language.HACK_FTP_SERVER /></td>
    <td class="lista"><input type="text" name="ftp_server" size="40" value="localhost" /></td>
    <td class="lista"><tag:language.HACK_FTP_PORT /></td>
    <td class="lista"><input type="text" name="ftp_port" size="10" value="21" /></td>
  </tr>
  <tr>
    <td class="lista"><tag:language.HACK_FTP_USERNAME /></td>
    <td class="lista"><input type="text" name="ftp_user" size="40" /></td>
    <td class="lista"><tag:language.HACK_FTP_PASSWORD /></td>
    <td class="lista"><input type="password" name="ftp_pwd" size="40" /></td>
  </tr>
  <tr>
    <td class="lista" colspan="2"><tag:language.HACK_FTP_BASEDIR /></td>
    <td class="lista" colspan="2"><input type="text" name="ftp_basedir" size="40" />
    </td>
  </tr>
  <tr>
    <td class="block" colspan="2" align="center"><input type="submit" name="confirm" value="<tag:language.FRM_CONFIRM />" /></td>
    <td class="block" colspan="2" align="center"><input type="submit" name="confirm" value="<tag:language.FRM_CANCEL />" /></td>
  </tr>
</table>
</form>
<br />
<else:ftp>
<script type="text/javascript">
<!--
function valid_folder(value) {
  if (value=='')
    document.add_hack.confirm.disabled=true;
  else
    document.add_hack.confirm.disabled=false;
}
-->
</script>
<if:test>
<br />
<form name="add_hack" action="<tag:form_action />" method="post">
<input type="hidden" name="add_hack_folder" value="<tag:hack_folder />" />
<table class="lista" cellpadding="4" cellspacing="0">
  <tr>
    <td class="block" colspan="3" align="center"><tag:hack_title_action /></td>
  </tr>
<if:test_ok>
  <tr>
    <td class="header" align="center"><tag:language.HACK_OPERATION /></td>
    <td class="header" align="center"><tag:language.FILE_NAME /></td>
    <td class="header" align="center"><tag:language.HACK_STATUS /></td>
  </tr>
  <loop:test_result>
  <tr>
    <td class="lista"><tag:test_result[].operation /></td>
    <td class="lista"><tag:test_result[].name /></td>
    <td class="lista" style="text-align:center;"><tag:test_result[].status /></td>
  </tr>
  </loop:test_result>
  <tr>
    <td class="header" colspan="3" style="text-align:center;">
      <input type="submit" name="confirm" class="btn" value="<tag:hack_install />" />
      <input type="submit" name="confirm" class="btn" value="<tag:language.FRM_CANCEL />" />
    </td>
  </tr>
<else:test_ok>
  <tr>
    <td class="header" align="center"><tag:language.FILE_NAME /></td>
    <td class="header" align="center"><tag:language.HACK_STATUS /></td>
    <td class="header" align="center"><tag:language.HACK_SOLUTION /></td>
  </tr>
  <loop:test_result>
  <tr>
    <td class="lista"><tag:test_result[].file /></td>
    <td class="lista"><tag:test_result[].message /></td>
    <td class="red" style="font-weight:bold;"><tag:test_result[].solution /></td>
  </tr>
  </loop:test_result>
</if:test_ok>
</table>
</form>
<if:test_ok2>
<br /><span style='font-size:12pt'><a href=<tag:hack_manual_link />><tag:language.MHI_VIEW_INSRUCT /></a></span><br /><br />
</if:test_ok2>
<br />
<a href="<tag:hack_main_link />"><tag:language.ACP_HACKS_CONFIG /></a>
<br />
<else:test>
<if:manual_install>
<table class="lista" width="100%" cellspacing="1" cellpadding="6" >
    <tr>
      <td class="header" align="center" colspan="6">Standard hacks in XBTIT DT FM V20.0 Donators Edition</td>
    </tr>
    <tr>
      <td class="header">Hack 1</td>
      <td class="lista">User Group Images by DiemThuy</td>
      <td class="header">Hack 2</td>
      <td class="lista">Category RSS/uTorrent Feed by DiemThuy</td>
      <td class="header">Hack 3</td>
      <td class="lista">Uploader Medals by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 4</td>
      <td class="lista">Group Colours Overall by Petr1fied/Lupin</td>
      <td class="header">Hack 5</td>
      <td class="lista">Sticky Torrent by Losmi</td>
      <td class="header">Hack 6</td>
      <td class="lista">Avatar Upload by JBoy</td>
    </tr>
      <tr>
      <td class="header">Hack 7</td>
      <td class="lista">Bonus system by Real_ptr</td>
      <td class="header">Hack 8</td>
      <td class="lista">Torrent Request & Vote Hack by DiemThuy</td>
      <td class="header">Hack 9</td>
      <td class="lista">Social Network Hack by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 10</td>
      <td class="lista">Total Online Time by DiemThuy</td>
      <td class="header">Hack 11</td>
      <td class="lista">Images For User Rating by FireBlade</td>
      <td class="header">Hack 12</td>
      <td class="lista">Flush Ghost Torrent by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 13</td>
      <td class="lista">Advanced Don Sys by DiemThuy/cooly</td>
      <td class="header">Hack 14</td>
      <td class="lista">Donation Historie by DiemThuy</td>
      <td class="header">Hack 15</td>
      <td class="lista">NAT user check by Petr1fied/DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 16</td>
      <td class="lista">Timed Ranks by DiemThuy</td>
      <td class="header">Hack 17</td>
      <td class="lista">Simple Donor Display by Lupin</td>
      <td class="header">Hack 18</td>
      <td class="lista">Max Torrents setting UG by DiemThuy</td>
    </tr>
      <tr>
      <td class="header">Hack 19</td>
      <td class="lista">Helpdesk by DiemThuy</td>
      <td class="header">Hack 20</td>
      <td class="lista">Peers Colors by DiemThuy</td>
      <td class="header">Hack 21</td>
      <td class="lista">Custom title by Real_ptr</td>
    </tr>
    <tr>
      <td class="header">Hack 22</td>
      <td class="lista">Vip Torrent System by DiemThuy</td>
      <td class="header">Hack 23</td>
      <td class="lista">Free Leech Hack by DiemThuy</td>
      <td class="header">Hack 24</td>
      <td class="lista">Torrent Image Upload by Real_ptr</td>
    </tr>
      <tr>
      <td class="header">Hack 25</td>
      <td class="lista">Signup Bonus Upload by RBert</td>
      <td class="header">Hack 26</td>
      <td class="lista">Auto Announce by Linux198</td>
      <td class="header">Hack 27</td>
      <td class="lista">Welcome member in SB by DarkLegion</td>
    </tr>
     <tr>
      <td class="header">Hack 28</td>
      <td class="lista">Graphic average bar by Miskotes</td>
      <td class="header">Hack 29</td>
      <td class="lista">ShoutBox Upload Announce by Lupin</td>
      <td class="header">Hack 30</td>
      <td class="lista">Staff Page by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 31</td>
      <td class="lista">Torrents Thanks by Lupin</td>
      <td class="header">Hack 32</td>
      <td class="lista">bbcode buttons Shoutbox by Cooly</td>
      <td class="header">Hack 33</td>
      <td class="lista">Torrent Bookmark Hack by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 34</td>
      <td class="lista">SB per Hour by DiemThuy</td>
      <td class="header">Hack 35</td>
      <td class="lista">Rules by Losmi</td>
      <td class="header">Hack 36</td>
      <td class="lista">FAQ by Losmi</td>
    </tr>
    <tr>
      <td class="header">Hack 37</td>
      <td class="lista">Torrents Grabbed by DiemThuy</td>
      <td class="header">Hack 38</td>
      <td class="lista">Where did you hear about us by DiemThuy</td>
      <td class="header">Hack 39</td>
      <td class="lista">Similar Torrents by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 40</td>
      <td class="lista">SB Exchange Control by DiemThuy</td>
      <td class="header">Hack 41</td>
      <td class="lista">Welcome PM New Users by Cooly</td>
      <td class="header">Hack 42</td>
      <td class="lista">Report Users & Torrents by DiemThuy</td>
    </tr>
        <tr>
      <td class="header">Hack 43</td>
      <td class="lista">Uploader Control by DiemThuy</td>
      <td class="header">Hack 44</td>
      <td class="lista">Advanced Torrent Search Hack by DiemThuy</td>
      <td class="header">Hack 45</td>
      <td class="lista">High UL Speed Report by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 46</td>
      <td class="lista">Ask For Reseed by DiemThuy</td>
      <td class="header">Hack 47</td>
      <td class="lista">Staff Chat Module by Cooly</td>
      <td class="header">Hack 48</td>
      <td class="lista">Low Ratio Ban System by DiemThuy</td>
    </tr>
      <tr>
      <td class="header">Hack 49</td>
      <td class="lista">Warning System by Linux198</td>
      <td class="header">Hack 50</td>
      <td class="lista">Mass E-mail by DiemThuy</td>
      <td class="header">Hack 51</td>
      <td class="lista">Online Block Timeout by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 52</td>
      <td class="lista">Show all uploads per user by DiemThuy</td>
      <td class="header">Hack 53</td>
      <td class="lista">IP Duplicate Accounts by CobraCRK</td>
      <td class="header">Hack 54</td>
      <td class="lista">Site On/Offline by Lupin</td>
    </tr>
    <tr>
      <td class="header">Hack 55</td>
      <td class="lista">DT Login Page by DiemThuy</td>
      <td class="header">Hack 56</td>
      <td class="lista">DT Online Block by DiemThuy</td>
      <td class="header">Hack 57</td>
      <td class="lista">Online status in shoutbox by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 58</td>
      <td class="lista">Birthday Hack by Petr1fied</td>
      <td class="header">Hack 59</td>
      <td class="lista">Staff Checks by DiemThuy</td>
      <td class="header">Hack 60</td>
      <td class="lista">Max Users Online by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 61</td>
      <td class="lista">Warn Level by DiemThuy</td>
      <td class="header">Hack 62</td>
      <td class="lista">Color speed stats in peers by Miskotes</td>
      <td class="header">Hack 63</td>
      <td class="lista">Peer Conectable by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 64</td>
      <td class="lista">Flash Last Torrents by Dodge</td>
      <td class="header">Hack 65</td>
      <td class="lista">Todays Torrents by Kvetinka/DiemThuy</td>
      <td class="header">Hack 66</td>
      <td class="lista">Lottery by JBoy</td>
    </tr>
    <tr>
      <td class="header">Hack 67</td>
      <td class="lista">User Immunity by DiemThuy</td>
      <td class="header">Hack 68</td>
      <td class="lista">Baloon on Mouseover by DiemThuy</td>
      <td class="header">Hack 69</td>
      <td class="lista">Stats Limit by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 70</td>
      <td class="lista">Invitation System by Dodge</td>
      <td class="header">Hack 71</td>
      <td class="lista">Comments Layout by Real_ptr</td>
      <td class="header">Hack 72</td>
      <td class="lista">Reputation System by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 73</td>
      <td class="lista">View.Edit.Del.Prev. SB/COM by Miskotes</td>
      <td class="header">Hack 74</td>
      <td class="lista">Torrent Comments - Reply by Petr1fied</td>
      <td class="header">Hack 75</td>
      <td class="lista">Lock Comments by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 76</td>
      <td class="lista">Torrents Age by DiemThuy</td>
      <td class="header">Hack 77</td>
      <td class="lista">User list Online-Offline by Morvol/Cooly</td>
      <td class="header">Hack 78</td>
      <td class="lista">Menu Switch by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 79</td>
      <td class="lista">Auto Prune Users by Real_ptr</td>
      <td class="header">Hack 80</td>
      <td class="lista">Change Nickname by Petr1fied</td>
      <td class="header">Hack 81</td>
      <td class="lista">Happy Hour by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 82</td>
      <td class="lista">Private Profile by MrFix</td>
      <td class="header">Hack 83</td>
      <td class="lista">Timed Open Registration by DiemThuy</td>
      <td class="header">Hack 84</td>
      <td class="lista">Gold & Silver Torrents by Losmi</td>
    </tr>
        <tr>
      <td class="header">Hack 85</td>
      <td class="lista">Ajax rating by Miskotes</td>
      <td class="header">Hack 86</td>
      <td class="lista">Hide Porn Cat. by DiemThuy</td>
      <td class="header">Hack 87</td>
      <td class="lista">Ban Client by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 88</td>
      <td class="lista">Recommended by DiemThuy</td>
      <td class="header">Hack 89</td>
      <td class="lista">Multi Delete torrents by Cooly</td>
      <td class="header">Hack 90</td>
      <td class="lista">Client Logging by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 91</td>
      <td class="lista">Gold Request by DiemThuy</td>
      <td class="header">Hack 92</td>
      <td class="lista">Staff & Support Comment in UD by Petr1fied</td>
      <td class="header">Hack 93</td>
      <td class="lista">BlackJack by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 94</td>
      <td class="lista">Search by ip, email, pid by Miskotes</td>
      <td class="header">Hack 95</td>
      <td class="lista">Gold/Silver Torrent Search by Juzik</td>
      <td class="header">Hack 96</td>
      <td class="lista">PM Spy by DiemThuy/Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 97</td>
      <td class="lista">Hide Online Status by DiemThuy</td>
      <td class="header">Hack 98</td>
      <td class="lista">Add New Users in ACP by Lupin/Petr1fied</td>
      <td class="header">Hack 99</td>
      <td class="lista">Last Bot Visit by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 100</td>
      <td class="lista">Disable Reg. with Dup. IP by DiemThuy</td>
      <td class="header">Hack 101</td>
      <td class="lista">Show last Browser by DiemThuy</td>
      <td class="header">Hack 102</td>
      <td class="lista">last 10 snatchers in TD by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 103</td>
      <td class="lista">Comments Block by DiemThuy</td>
      <td class="header">Hack 104</td>
      <td class="lista">Give Points To Uploaders by Hasu</td>
      <td class="header">Hack 105</td>
      <td class="lista">AddThis by Signo</td>
    </tr>
    <tr>
      <td class="header">Hack 106</td>
      <td class="lista">UserBars Enhanced by Qwe2000</td>
      <td class="header">Hack 107</td>
      <td class="lista">Admin Edit Seedbonus by ShadowMaster</td>
      <td class="header">Hack 108</td>
      <td class="lista">Profile Hit Count by Cooly/MrFix</td>
    </tr>
    <tr>
      <td class="header">Hack 109</td>
      <td class="lista">Announce Lot winner In SB by DiemThuy</td>
      <td class="header">Hack 110</td>
      <td class="lista">Auto Start Lottery by DiemThuy</td>
      <td class="header">Hack 111</td>
      <td class="lista">VIP Free Leech by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 112</td>
      <td class="lista">Int. Forum Category by DiemThuy</td>
      <td class="header">Hack 113</td>
      <td class="lista">Split Torrents By Days by Hasu</td>
      <td class="header">Hack 114</td>
      <td class="lista">Vote For Comments by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 115</td>
      <td class="lista">Expected/Offer by DiemThuy</td>
      <td class="header">Hack 116</td>
      <td class="lista">Expected/Offer Update by DiemThuy</td>
      <td class="header">Hack 117</td>
      <td class="lista">Timed Ranks Staff Control by DiemThuy</td>
    </tr>
        <tr>
      <td class="header">Hack 118</td>
      <td class="lista">Show members whois by Petr1fied</td>
      <td class="header">Hack 119</td>
      <td class="lista">BanButton by DiemThuy/Petr1fied</td>
      <td class="header">Hack 120</td>
      <td class="lista">Allow/Disallow UP/Download by Linux198</td>
    </tr>
    <tr>
      <td class="header">Hack 121</td>
      <td class="lista">Detect & Blacklist Proxy by DiemThuy</td>
      <td class="header">Hack 122</td>
      <td class="lista">Search for Uploader by DiemThuy</td>
      <td class="header">Hack 123</td>
      <td class="lista">User Signup Agreement by DiemThuy</td>
    </tr>
        <tr>
      <td class="header">Hack 124</td>
      <td class="lista">Announcement by DiemThuy</td>
      <td class="header">Hack 125</td>
      <td class="lista">IP Log by DiemThuy</td>
      <td class="header">Hack 126</td>
      <td class="lista">Anti Hit & Run by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 127</td>
      <td class="lista">Booted Users by Cooly</td>
      <td class="header">Hack 128</td>
      <td class="lista">Seed Time by DiemThuy</td>
      <td class="header">Hack 129</td>
      <td class="lista">Online Time in UD by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 130</td>
      <td class="lista">Ban Cheapmail Domains by Petr1fied</td>
      <td class="header">Hack 131</td>
      <td class="lista">Hide Language/Style Menu by King Cobra</td>
      <td class="header">Hack 132</td>
      <td class="lista">Torrent Moderation by Losmi</td>
    </tr>
    <tr>
      <td class="header">Hack 133</td>
      <td class="lista">Scrolling News Switch by DiemThuy</td>
      <td class="header">Hack 134</td>
      <td class="lista">NFO Ripper by Cooly</td>
      <td class="header">Hack 135</td>
      <td class="lista">Get IMDB by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 136</td>
      <td class="lista">Invalid Login System by DiemThuy</td>
      <td class="header">Hack 137</td>
      <td class="lista">Invalid Login Log by DiemThuy</td>
      <td class="header">Hack 138</td>
      <td class="lista">Donate SB by Cooly/DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 139</td>
      <td class="lista">LED Ticker by DiemThuy</td>
      <td class="header">Hack 140</td>
      <td class="lista">Staff Comment in TD by DiemThuy</td>
      <td class="header">Hack 141</td>
      <td class="lista">Recommended Tor. by Kvetinka</td>
    </tr>
     <tr>
      <td class="header">Hack 142</td>
      <td class="lista">Subtitles Hack by Cooly/Lupin</td>
      <td class="header">Hack 143</td>
      <td class="lista">Hide Side Blocks by DiemThuy</td>
      <td class="header">Hack 144</td>
      <td class="lista">Auto Rank by Petr1fied</td>
    </tr>
    <tr>
      <td class="header">Hack 145</td>
      <td class="lista">Email Notification PM by DiemThuy</td>
      <td class="header">Hack 146</td>
      <td class="lista">Torrent re-new by DiemThuy</td>
      <td class="header">Hack 147</td>
      <td class="lista">Advertise System by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 148</td>
      <td class="lista">Forum Auto Topic by Dodge</td>
      <td class="header">Hack 149</td>
      <td class="lista">Up/DL per day by DiemThuy</td>
      <td class="header">Hack 150</td>
      <td class="lista">Tor Cat Subscription by Lupin</td>
    </tr>
    <tr>
      <td class="header">Hack 151</td>
      <td class="lista">User Images by DiemThuy</td>
      <td class="header">Hack 152</td>
      <td class="lista">Show Zodiac by DiemThuy</td>
      <td class="header">Hack 153</td>
      <td class="lista">Ignore User by Kvetinka</td>
    </tr>
    <tr>
      <td class="header">Hack 154</td>
      <td class="lista">Comment in Client by DiemThuy</td>
      <td class="header">Hack 155</td>
      <td class="lista">Seasons Fun by DiemThuy</td>
      <td class="header">Hack 156</td>
      <td class="lista">Multi Tracker Scrape by Bitheaven</td>
    </tr>
    <tr>
      <td class="header">Hack 157</td>
      <td class="lista">Account Parked by Confe</td>
      <td class="header">Hack 158</td>
      <td class="lista">Xmas Present by DiemThuy</td>
      <td class="header">Hack 159</td>
      <td class="lista">Shout Sound by Cooly</td>
    </tr>
     <tr>
      <td class="header">Hack 160</td>
      <td class="lista">Auto post pics in Chat by DiemThuy</td>
      <td class="header">Hack 161</td>
      <td class="lista">DT Arcade by DiemThuy</td>
      <td class="header">Hack 162</td>
      <td class="lista">DT Featured Torrent by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 163</td>
      <td class="lista">Auto Featured by DiemThuy</td>
      <td class="header">Hack 164</td>
      <td class="lista">Donate for Invite by DiemThuy</td>
      <td class="header">Hack 165</td>
      <td class="lista">Clean Shoutbox by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 166</td>
      <td class="lista">Referral System by DiemThuy</td>
      <td class="header">Hack 167</td>
      <td class="lista">Report a Bug by DiemThuy</td>
      <td class="header">Hack 168</td>
      <td class="lista">DT Login Switch by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 169</td>
      <td class="lista">SB Banned by Cooly</td>
      <td class="header">Hack 170</td>
      <td class="lista">Group Color Picker by Cooly</td>
      <td class="header">Hack 171</td>
      <td class="lista">YouTube in TD by DiemThuy/Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 172</td>
      <td class="lista">Upload Multiplier by DiemThuy</td>
      <td class="header">Hack 173</td>
      <td class="lista">Magnet Link by Laurianti</td>
      <td class="header">Hack 174</td>
      <td class="lista">Copy Torrent Name by Yupy</td>
    </tr>
    <tr>
      <td class="header">Hack 175</td>
      <td class="lista">Facebook Login By Juzik</td>
      <td class="header">Hack 176</td>
      <td class="lista">Clean Hit & Run by Cooly</td>
      <td class="header">Hack 177</td>
      <td class="lista">New Forum Post in SB by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 178</td>
      <td class="lista">New T Comment in SB by ShadowMaster</td>
      <td class="header">Hack 179</td>
      <td class="lista">Matrix Sreensaver by Cooly</td>
      <td class="header">Hack 180</td>
      <td class="lista">Flasch IRC by DiemThuy</td>
    </tr>
     <tr>
      <td class="header">Hack 181</td>
      <td class="lista">Ratio Editor by Jboy</td>
      <td class="header">Hack 182</td>
      <td class="lista">New T after L visit by Vasyajva</td>
      <td class="header">Hack 183</td>
      <td class="lista">Reason for Torent Delete by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 184</td>
      <td class="lista">Disclaimer by TreetopClimber/DT</td>
      <td class="header">Hack 185</td>
      <td class="lista">Upload Form Protection by Cooly</td>
      <td class="header">Hack 186</td>
      <td class="lista">NFO Uploader by Miskotes</td>
    </tr>
        <tr>
      <td class="header">Hack 187</td>
      <td class="lista">Torrent Tag by Laurianti</td>
      <td class="header">Hack 188</td>
      <td class="lista">Gender by Confe</td>
      <td class="header">Hack 189</td>
      <td class="lista">Personal Notepad by Kvetinka</td>
    </tr>
    <tr>
      <td class="header">Hack 190</td>
      <td class="lista">Password Generator by Yupy</td>
      <td class="header">Hack 191</td>
      <td class="lista">Shitlist by DiemThuy</td>
      <td class="header">Hack 192</td>
      <td class="lista">Uploader Request by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 193</td>
      <td class="lista">Shoutbox Layout by DiemThuy</td>
      <td class="header">Hack 194</td>
      <td class="lista">Last Up/Down by Dragon64/DT</td>
      <td class="header">Hack 195</td>
      <td class="lista">Categories Block by Liroy</td>
    </tr>
    <tr>
      <td class="header">Hack 196</td>
      <td class="lista">Anonymous Links by Cooly</td>
      <td class="header">Hack 197</td>
      <td class="lista">ADS addon by DiemThuy</td>
      <td class="header">Hack 198</td>
      <td class="lista">Up/Dl Rate/Hour by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 199</td>
      <td class="lista">New Torrent Block by DiemThuy</td>
      <td class="header">Hack 200</td>
      <td class="lista">Hide Peers by DiemThuy</td>
      <td class="header">Hack 201</td>
      <td class="lista">Div Shout addons by Div</td>
    </tr>
    <tr>
      <td class="header">Hack 202</td>
      <td class="lista">ACP Password by DiemThuy</td>
      <td class="header">Hack 203</td>
      <td class="lista">Private Shouts by Cooly</td>
      <td class="header">Hack 204</td>
      <td class="lista">Image Link by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 205</td>
      <td class="lista">Language in Torrents by MrFix</td>
      <td class="header">Hack 206</td>
      <td class="lista">Invited Users by DiemThuy</td>
      <td class="header">Hack 207</td>
      <td class="lista">YouTube Page by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 208</td>
      <td class="lista">PM Not. On Tor. Com. by Liroy</td>
      <td class="header">Hack 209</td>
      <td class="lista">Refresh Peers by DrAgon64</td>
      <td class="header">Hack 210</td>
      <td class="lista">Torrent Dumper by Atmoner</td>
    </tr>
    <tr>
      <td class="header">Hack 211</td>
      <td class="lista">IMDB rating in TL by DiemThuy</td>
      <td class="header">Hack 212</td>
      <td class="lista">IMDB images used overall by DiemThuy</td>
      <td class="header">Hack 213</td>
      <td class="lista">Similar torrents in TL by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 214</td>
      <td class="lista">Search Cloud by Cooly/DT</td>
      <td class="header">Hack 215</td>
      <td class="lista">Int Forum Ban by SM/Cooly</td>
      <td class="header">Hack 216</td>
      <td class="lista">PW Duplicate Accounts by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 217</td>
      <td class="lista">Speedtest by DiemThuy</td>
      <td class="header">Hack 218</td>
      <td class="lista">Comments in ACP by DiemThuy</td>
      <td class="header">Hack 219</td>
      <td class="lista">Event Counter by DiemThuy</td>
    </tr>
    <tr>
      <td class="header">Hack 220</td>
      <td class="lista">Teams by Cooly</td>
      <td class="header">Hack 221</td>
      <td class="lista">Delete Me by Kvetinka</td>
      <td class="header">Hack 222</td>
      <td class="lista">Google analitic by Atmoner</td>
    </tr>
    <tr>
      <td class="header">Hack 223</td>
      <td class="lista">Pm popup by ExtremTeam</td>
      <td class="header">Hack 224</td>
      <td class="lista">Teams pages by DiemThuy</td>
      <td class="header">Hack 225</td>
      <td class="lista">Torrent Scroller by Real_ptr</td>
    </tr>
    <tr>
      <td class="header">Hack 226</td>
      <td class="lista">SSL by DiemThuy</td>
      <td class="header">Hack 227</td>
      <td class="lista">Anti flood comments by DiemThuy</td>
      <td class="header">Hack 228</td>
      <td class="lista">Shout as System by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 229</td>
      <td class="lista">Currently Viewing Topic by Yupy</td>
      <td class="header">Hack 230</td>
      <td class="lista">Active Users on Forum by Yupy</td>
      <td class="header">Hack 231</td>
      <td class="lista">Torrent search Info by Bhorer_alo</td>
    </tr>
    <tr>
      <td class="header">Hack 232</td>
      <td class="lista">Username Changelog by DiemThuy</td>
      <td class="header">Hack 233</td>
      <td class="lista">Hide None Fatal PHP Errors by DiemThuy</td>
      <td class="header">Hack 234</td>
      <td class="lista">Cat. Permissions by Real_ptr</td>
   </tr>
   <tr>
      <td class="header">Hack 235</td>
      <td class="lista">Show Used Style by DiemThuy</td>
      <td class="header">Hack 236</td>
      <td class="lista">Slot Machine by Cooly</td>
      <td class="header">Hack 237</td>
      <td class="lista">User Img Store by DiemThuy</td>
   </tr>
      <tr>
      <td class="header">Hack 238</td>
      <td class="lista">SB for Torrent to Top by DiemThuy</td>
      <td class="header">Hack 239</td>
      <td class="lista">Search Block by Diemthuy</td>
      <td class="header">Hack 240</td>
      <td class="lista">Auto Torrent Prune by Petr1fied</td>
   </tr>
    <tr>
      <td class="header">Hack 241</td>
      <td class="lista">Ratio Fix by Bhorer_alo</td>
      <td class="header">Hack 242</td>
      <td class="lista">Reseed Button Rules Set by DiemThuy</td>
      <td class="header">Hack 243</td>
      <td class="lista">Backup Database By Khez</td>
   </tr>
    <tr>
      <td class="header">Hack 244</td>
      <td class="lista">YouTube BB code in SB by Flier</td>
      <td class="header">Hack 245</td>
      <td class="lista">Staff Shout Addon by DiemThuy</td>
      <td class="header">Hack 246</td>
      <td class="lista">Yupy Login page by Yupy/DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 247</td>
      <td class="lista">New Collapse by TreetopClimber</td>
      <td class="header">Hack 248</td>
      <td class="lista">Give Support by linux198/DiemThuy</td>
      <td class="header">Hack 249</td>
      <td class="lista">Pie Chart by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 250</td>
      <td class="lista">Profile Status by Yupy/DiemThuy</td>
      <td class="header">Hack 251</td>
      <td class="lista">Block Links in Comments by Yupy</td>
      <td class="header">Hack 252</td>
      <td class="lista">Forced to Thank/Comment by CrazySaloon</td>
   </tr>
    <tr>
      <td class="header">Hack 253</td>
      <td class="lista">IMDb search by DiemThuy</td>
      <td class="header">Hack 254</td>
      <td class="lista">New Users Day/Month by A4kata</td>
      <td class="header">Hack 255</td>
      <td class="lista">Date Picker by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 256</td>
      <td class="lista">Calculater by Juzik</td>
      <td class="header">Hack 257</td>
      <td class="lista">New Torrents Day/Month by DiemThuy</td>
      <td class="header">Hack 258</td>
      <td class="lista">Background Rotator by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 259</td>
      <td class="lista">Apply Membership by DiemThuy</td>
      <td class="header">Hack 260</td>
      <td class="lista">Orlydb Pre Time by DiemThuy</td>
      <td class="header">Hack 261</td>
      <td class="lista">DOX by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 262</td>
      <td class="lista">XBTIT Quiz by DiemThuy</td>
      <td class="header">Hack 263</td>
      <td class="lista">Birthday Calender by DiemThuy</td>
      <td class="header">Hack 264</td>
      <td class="lista">Flah MP3 Player by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 265</td>
      <td class="lista">Contact by Yupy/DiemThuy</td>
      <td class="header">Hack 266</td>
      <td class="lista">Server Stats by DiemThuy</td>
      <td class="header">Hack 267</td>
      <td class="lista">Delete Unreaded pm,s by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 268</td>
      <td class="lista">None Connectable in ACP by DiemThuy</td>
      <td class="header">Hack 269</td>
      <td class="lista">SB to Upload Conversion by DiemThuy</td>
      <td class="header">Hack 270</td>
      <td class="lista">Custom Dropdownmenu Links by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 271</td>
      <td class="lista">PreDB Pretime by Crash_OV</td>
      <td class="header">Hack 272</td>
      <td class="lista">Mass Moderate by DiemThuy</td>
      <td class="header">Hack 273</td>
      <td class="lista">Enable or Disable Blocks by Bhorer_Alo</td>
   </tr>
    <tr>
      <td class="header">Hack 274</td>
      <td class="lista">Cat Free Leech by DiemThuy</td>
      <td class="header">Hack 275</td>
      <td class="lista">Memcache by Cooly</td>
      <td class="header">Hack 276</td>
      <td class="lista">Gallery by Cooly</td>
    </tr>
    <tr>
      <td class="header">Hack 277</td>
      <td class="lista">Google Captcha by DiemThuy</td>
      <td class="header">Hack 278</td>
      <td class="lista">Pm notification on forum post by Jufek</td>
      <td class="header">Hack 279</td>
      <td class="lista">Owner Auto Thanks by DiemThuy</td>
   </tr>
    <tr>
      <td class="header">Hack 280</td>
      <td class="lista">Ajax Categories Sort by Losmi</td>
      <td class="header">Hack 281</td>
      <td class="lista">Shoutbox Reply by Danno</td>
      <td class="header">Hack 282</td>
      <td class="lista">Min Age to See Porn by DiemThuy</td>
   </tr>
  </table>
<table class="lista" width="100%" cellspacing="1" cellpadding="6">
  <tr>
    <td class="header" align="center"><tag:language.HACK_TITLE /></td>
    <td class="header" align="center"><tag:language.HACK_VERSION /></td>
    <td class="header" align="center"><tag:language.HACK_AUTHOR /></td>
    <td class="header" align="center"><tag:language.HACK_ADDED /></td>
    <td class="header" align="center">&nbsp;</td>
  </tr>
  
  <if:no_hacks>
    <tr>
      <td class="lista" colspan="5" style="text-align:center;">There are no extra DT FM hacks installed yet</td>
    </tr>

  <else:no_hacks>
  <loop:hacks>
    <tr>
      <td class="lista"><tag:hacks[].title /></td>
      <td class="lista" style="text-align:center;"><tag:hacks[].version /></td>
      <td class="lista"><tag:hacks[].author /></td>
      <td class="lista" style="text-align:center;"><tag:hacks[].added /></td>
      <td class="lista" style="text-align:center;"><a href="<tag:hacks[].uninstall />"><tag:language.HACK_UNINSTALL /></a></td>
    </tr>
  </loop:hacks>
  </if:no_hacks>
</table>
<br />
<form name="add_hack" action="<tag:form_action />" method="post">
<table class="lista" cellpadding="4" cellspacing="0">
  <tr>
    <td class="header" colspan="3"><tag:language.HACK_ADD_NEW /></td>
  </tr>
  <tr>
    <td class="lista"><tag:language.HACK_SELECT /></td>
    <td class="lista" align="left"><tag:hack_combo /></td>
    <td class="lista"><input type="submit" class="btn" name="confirm" disabled="disabled" value="<tag:language.FRM_CONFIRM />" /></td>
  </tr>
</table>
</form>

<else:manual_install>

<div align='center'><b><span style='font-family:arial; font-size:16pt; color:#000000;'><tag:language.MHI_MAN_INSRUCT_FOR />:</span></b><br /><br /><span style='font-family:arial; font-size:16pt; color:#0000FF;'><b><tag:title /> v<tag:version /> <tag:language.BY /> <tag:author /></b></span></div><br /><br />

<tag:HTMLOUT />
</if:manual_install>

</if:test>
</if:ftp>