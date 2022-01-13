<?php

#doc
#       classname:      XbtitAutopost
#       scope:          PUBLIC
#
#/doc

class XbtitExtratorrent {
		var $maxTorrents = '50';
        ###     
        function getFeedextratorrent($feed_url) {
	
				$cpt=0;
                $content = file_get_contents($feed_url);        
                $x = new SimpleXmlElement($content);
                $r .= "<ul>"; 
                foreach($x->channel->item as $entry) {
                if (isset($_POST['dump'])) {
                        $this->updateExtra($feed_url,$_POST['category'],$_POST['uploaderid']);
                }
                if(!$this->checkExistetorrent($entry->info_hash)) {
                        $r .= "
                        <li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>
                        <li>Hash: " . $entry->info_hash . " <br /></li>
                        <li>Date: " . $entry->pubDate . " <br /></li>
                        <li>Taille: " . $entry->size . " <br /></li>
                        <li>
                         " . $entry->enclosure->attributes() . " 
                        </li>
                        <br /><hr>";
                } else {
                        return false;
                }
                $cpt++;
				if($cpt==$this->maxTorrents) break; 
                }
                $r .= "</ul>"; 
        return $r;   
        }
        ###     
        function updateExtra($feed_url,$cat,$userid) {
				global $TORRENTSDIR;
                $content = file_get_contents($feed_url);        
                $x = new SimpleXmlElement($content); 
 
                foreach($x->channel->item as $entry) { 
                                if(!$this->checkExistetorrent($entry->info_hash)) {
                                         $this->DownloadTorrent('http://torcache.net/torrent/'.strtoupper($entry->info_hash).'.torrent');
                                         $this->insertTorrent(
                                         		dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($entry->info_hash).'.btf',
                                         		$entry->info_hash,
                                         		$entry->title,
                                         		$userid,
                                         		$cat
                                         );  
                                }   
                	}        
        }
        ###
        function DownloadTorrent($a) {
                global $TORRENTSDIR;
                        $filename = str_replace('.torrent', '.btf', basename($a));
                        $fp = fopen(dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($filename), 'w+');
                        
                        $ch = curl_init($a); 
                        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Important 
                        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER,0); // None header
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); // Binary trasfer 1
                        curl_setopt($ch, CURLOPT_REFERER, 'http://torcache.net/');
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