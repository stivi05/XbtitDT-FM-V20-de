<?php

#doc
#       classname:      XbtitAutopost
#       scope:          PUBLIC
#
#/doc

class XbtitMnova {
        #       internal variables
        var $maxTorrents = '50';
        var $apiUrl = 'http://www.mnova.eu/rss.php?search='; 

        ###     
        function getFeedmnova($feed_url) {
 
                $content = file_get_contents($this->apiUrl.$feed_url);        
				
                $x = new SimpleXmlElement($content);
 
                $r .= "<ul>"; 
                foreach($x->channel->item as $entry) {
				$h = $this->exploserChaine($entry->enclosure->attributes());

                if (isset($_POST['dump'])) {
                        $this->updateMnova($feed_url,$_POST['category'],$_POST['uploaderid']);
                }
 
                if(!$this->checkExistetorrent($h[9])) {
                        $r .= "
                        <li><a href='$entry->guid' title='$entry->title'>" . $entry->title . "</a></li>
                        <li>Hash: " . $h[9] . " <br /></li>
                        <li>Category: " . $entry->category . " <br /></li>
                        <li>
                         <a href=".$entry->enclosure->attributes().">" . $entry->enclosure->attributes() . "</a> 
                        </li>
                        <br /><hr>";
                } else {
                        return false;
                }
 
                }
                $r .= "</ul>"; 
        return $r;   
        }
        ###     
        function updateMnova($feed_url,$cat,$userid) {
				global $TORRENTSDIR;
                $content = file_get_contents($this->apiUrl.$feed_url);        
                $x = new SimpleXmlElement($content); 
 
                foreach($x->channel->item as $entry) {
                	$h = $this->exploserChaine($entry->enclosure->attributes()); 
                                 if(!$this->checkExistetorrent($h[9])) {
                                         $this->DownloadTorrent($entry->enclosure->attributes(),$h[9]);
                                         $this->insertTorrent(
                                         		dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($h[9]).'.btf',
                                         		$h[9], // hash torrent
                                         		$entry->title,
                                         		$userid,
                                         		$cat
                                         );
                                }   
                	}        
        }
        ###
	    function exploserChaine( $chaine ){
		  # code...
		   $to = '.,;:!?/&"';
		   $from = '          ';
		   $chaine = strtr( $chaine, $to, $from ); 
		   $tabTemp = explode( ' ', $chaine ); 
		   @strip_tags($tabTemp);
		   foreach( $tabTemp as $k => $v ){
		       if($v != NULL){
		           if(preg_match('#(.*){1}(\')#', $v, $matches)){
		               $v = substr($v, 2); 
		            }
		           $tabChaine[] = $v; 
		       }
		   }
		   return $tabChaine;
	    }
        ###
        function DownloadTorrent($a,$h) {
                global $TORRENTSDIR;
 
                        $fp = fopen (dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($h).'.btf', 'w+');
                        $ch = curl_init($a); 
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Important 
                        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER,0); // None header
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); // Binary trasfer 1
                        curl_setopt($ch, CURLOPT_REFERER, 'http://www.mnova.eu/');
                        curl_exec($ch);
                        curl_close($ch);
                        fclose($fp);
 
        }
        ###
        function checkExistetorrent($hash){
                global $TABLE_PREFIX;
                $query = "SELECT info_hash FROM {$TABLE_PREFIX}files WHERE info_hash = '$hash' LIMIT 1;";
       			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
                $row = mysqli_fetch_array($result);
                if ($row) {
                        return true;
                } else {
                        return false;
                }
        }
        ###             
        function insertTorrent($torrent,$info_hash,$filename,$user,$cat){
       			global $TABLE_PREFIX, $TORRENTSDIR,$DBDT;
                require_once (dirname(__FILE__)."/../../include/BDecode.php");
                require_once (dirname(__FILE__)."/../../include/BEncode.php");
                $fd = fopen($torrent, "rb") or die('Impossible d ouvrire le torrent');
                $alltorrent = fread($fd, filesize($torrent));

                $array = BDecode($alltorrent);
                // Announce
                $announce=str_replace(array("\r\n","\r","\n"),"",$array["announce"]);

                // Dipslay all tracker announce
                $announces=array();
                for ($i=0;$i<count($array["announce-list"]);$i++) {
                $current=$array["announce-list"][$i];
                if (is_array($current)) $announces[$current[0]]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);
                else $announces[$current]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);
                }
                $announces[$announce]=array("seeds"=>0, "leeches"=>0, "downloaded"=>0);

                // description not writen by user, we get info directly from torrent.
                if (isset($array["comment"]))
                   $info =  mysqli_real_escape_string($DBDT,htmlspecialchars($array["comment"]));
                else
                        $info = "";

                // Size
                if (isset($array["info"]) && $array["info"]) $upfile=$array["info"];
                        else $upfile = 0;

                if (isset($upfile["length"]))
                {
                  $size = (float)($upfile["length"]);
                }
                else if (isset($upfile["files"]))
                         {
                // multifiles torrent
                                 $size=0;
                                 foreach ($upfile["files"] as $file)
                                         {
                                         $size+=(float)($file["length"]);
                                         }
                         }
                else
                        $size = "0";            

                // Query :p     
                $now = date("Y-m-d H:i:s");     
                $query = "INSERT INTO {$TABLE_PREFIX}files (info_hash, announces, filename, url, info, category, data, size, comment, external,announce_url, uploader,anonymous, bin_hash)
                  VALUES (
                          '$info_hash',
                          '".mysqli_real_escape_string($DBDT,serialize($announces))."',
                          '".mysqli_real_escape_string($DBDT,$filename)."',
                          '$TORRENTSDIR/$info_hash.btf',
                          '$info',
                          '$cat',
                          '$now',
                          '$size',
                          '".mysqli_real_escape_string($DBDT,$filename)."',
                          'yes',
                          '$announce',
                          '$user',
                          'false',
                          '0x$info_hash'
                          )";
                $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));          
        }      
}
###
?>