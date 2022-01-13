<?php

#doc
#       classname:      XbtitAutopost
#       scope:          PUBLIC
#
#/doc

class XbtitLimetorrents {
        #       internal variables
        var $torrentfolder = '/var/www/torrents/';       
        #       Constructor
        function __construct () {

        }
        ###     
        function getFeedlimetorrents($feed_url) {
				
				$cpt=0;
                $content = file_get_contents($feed_url);        
                $x = new SimpleXmlElement($content);
                $r .= "<ul>"; 
                foreach($x->channel->item as $entry) {
		            //get hash from url download
		            $urlToExplo = str_replace(' ','-', $entry->enclosure->attributes());
		            $h = $this->exploserChaine($urlToExplo); 
                
                if (isset($_POST['dump'])) {
                        $this->updateLimetorrents($feed_url,$_POST['category'],$_POST['uploaderid']);
                }
                if(!$this->checkExistetorrent(strtolower($h[6]))) {
                        $r .= "
                        <li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>
                        <li>Hash: " . strtolower($h[6]) . " <br /></li>
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
				if($cpt==20) break; //on sort de la boucle
                }
                $r .= "</ul>"; 
        return $r;   
        }
        ###     
        function updateLimetorrents($feed_url,$cat,$userid) {

                $content = file_get_contents($feed_url);        
                $x = new SimpleXmlElement($content); 
 
                foreach($x->channel->item as $entry) { 
								//get hash from url download
								$urlToExplo = str_replace(' ','-', $entry->enclosure->attributes());
								$h = $this->exploserChaine($urlToExplo); 
								$hash = strtolower($h[6]);
								
                                if(!$this->checkExistetorrent($hash)) {
                                         $this->DownloadTorrent($entry->enclosure->attributes(),$hash);
                                         $this->insertTorrent(
                                         			$this->torrentfolder.$hash.'.btf',
                                         			$hash,
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
                # code...
                $save_to = $this->torrentfolder; // Set torrent folder for download
 
                        $fp = fopen ($this->torrentfolder.strtolower($h).'.btf', 'w+');//This is the file where we save the information
                        $ch = curl_init($a);//Here is the file we are downloading
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
                # code...
                $query = "SELECT * FROM {$TABLE_PREFIX}files WHERE info_hash = '$hash' LIMIT 1;";
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
                require_once ("/var/www/include/BDecode.php");
                require_once ("/var/www/include/BEncode.php");
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
                          'torrents/$info_hash.btf',
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

                 // Scrape torrent =) 
                 // $this->scrape($announce,$info_hash);        
        }
        function scrape($url, $infohash='')     {
             global $TABLE_PREFIX,$DBDT;
                if (isset($url))
                {
                    $url_c=parse_url($url);

                    if(!isset($url_c["port"]) || empty($url_c["port"]))
                        $url_c["port"]=80;

                    require_once("/var/www/include/phpscraper/".$url_c["scheme"]."tscraper.php");
                    try
                    {
                        $timeout = 5;
                        if($url_c["scheme"]=="udp")
                            $scraper = new udptscraper($timeout);
                        else
                            $scraper = new httptscraper($timeout);

                        $ret = $scraper->scrape($url_c["scheme"]."://".$url_c["host"].":".$url_c["port"].(($url_c["scheme"]=="udp")?"":"/announce"),array($infohash));

                                $query = "SELECT announces FROM {$TABLE_PREFIX}files WHERE info_hash = '".mysqli_real_escape_string($DBDT,$infohash)."'";
                                $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
                                $t = mysqli_fetch_assoc($result);

                            // $t=get_result("SELECT `announces` FROM `xbtit_files` WHERE `info_hash`='".mysql_real_escape_string($infohash)."'");
                            $announces=((@unserialize($t["announces"]))?unserialize($t["announces"]):array());

                            if (isset($announces[$url]))
                        {

                                $announces[$url]["seeds"]=$ret[$infohash]["seeders"];
                                $announces[$url]["leeches"]=$ret[$infohash]["leechers"];
                                $announces[$url]["downloaded"]=$ret[$infohash]["completed"];
                            }

                        $s=0;
                        $l=0;
                        $d=0;
                        foreach ($announces AS $a=>$x)
                        {
                            $s+=$x["seeds"];
                            $l+=$x["leeches"];
                            $d+=$x["downloaded"];
                        }
                         $query = "UPDATE `{$TABLE_PREFIX}files` SET `lastupdate`=NOW(), `lastsuccess`=NOW(), `seeds`=".$s.", `leechers`=".$l.", `finished`=".$d.",announces='".mysqli_real_escape_string($DBDT,serialize($announces))."' WHERE `info_hash`='".mysql_real_escape_string($DBDT,$infohash)."'";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

                        // do_sqlquery("UPDATE `xbtit_files` SET `lastupdate`=NOW(), `lastsuccess`=NOW(), `seeds`=".$s.", `leechers`=".$l.", `finished`=".$d."$

                    }
                    catch(ScraperException $e)
                    {
                        // write_log("FAILED update external torrent ".($infohash==""?"":"(infohash: ".$infohash.")")." from ".$url." tracker (".$e->getMessag$
                    }
                    return;
                }
                return;
        }       
}
###
?>