<?php

#doc
#       classname:      XbtitAutopost
#       scope:          PUBLIC
#
#/doc

class XbtitBitsnoop {
        #       internal variables   
		var $num_lines = 30; // Max query 
    
        ###     
        function getFeedbitsnoop($feed_url) {
 
 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $feed_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; fr; rv:1.9b5) Gecko/2008041514 Firefox/3.0b5");
				$resultat = curl_exec ($ch);
				curl_close($ch);
				$data_array = $this->arrayData($resultat);
                if (isset($_POST['dump'])) {
                        $this->updateBitsnoop($feed_url,$_POST['category'],$_POST['uploaderid']);
                } 
                $r .= "<ul>"; 
				// Output the final data
				foreach ($data_array as $value){
				$f = explode('|', $value);
                if(!$this->checkExistetorrent($f[0])) {
					$r .= '<li>Torrent hash: '.$f[0].'</li>';
					$r .= '<li>Torrent name: '.$f[1].'</li>';
					$r .= '<li>Category: '.$f[2].'</li>';
					$r .= '<li>Description: <a href="'.$f[3].'" target="_BLANK">'.$f[3].'</a></li>';
					$r .= '<li>Torrent link: <a href="'.$f[4].'" target="_BLANK">'.$f[4].'</a></li>';
					$r .='<br /><hr>';
					} else
						return false;
				}
                $r .= "</ul>"; 
        return $r;   
        }
        ###
		function arrayData($data){
			// Create an array out of each line
			$data_array=explode("\n", $data);
			// Find the last key in the array
			$last_key=count($data_array)-1;
			// If the last line is empty revise the last key downwards until there's actually something there
			while(empty($data_array[$last_key])){
				$last_key-=1;
			}
			// Figure out the first key based upon the value set for the number of lines to display
			$first_key=$last_key-($this->num_lines-1);
			// Start a new array to store the last X lines in
			$final_array=array();
		 
			// Work through the array and only add the last X lines to it.
			foreach($data_array as $key => $value) {
				if($key >= $first_key && $key <= $last_key) {
					$final_array[]=$value;
				}
			}
		return $final_array;
		} // end function
        ###     
        function updateBitsnoop($feed_url,$cat,$userid) {
				global $TORRENTSDIR;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $feed_url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; fr; rv:1.9b5) Gecko/2008041514 Firefox/3.0b5");
				$resultat = curl_exec ($ch);
				curl_close($ch);
				$data_array = $this->arrayData($resultat);
 
                foreach($data_array as $entry) {
                				$f = explode('|', $entry); 
                                if(!$this->checkExistetorrent(strtolower($f[0]))) {
                                         $this->DownloadTorrent($f[4]);
                                         $this->insertTorrent(
                                         		dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($f[0]).'.btf',
                                         		strtolower($f[0]),
                                         		$f[1],
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
                        $fp = fopen (dirname(__FILE__).'/../../'.$TORRENTSDIR.'/'.strtolower($filename), 'w+');
                        $ch = curl_init($a);
                        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // Important 
                        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER,0); // None header
                        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1); // Binary trasfer 1
                        curl_setopt($ch, CURLOPT_REFERER, 'http://torrage.com/');
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