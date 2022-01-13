<?php
/////////////////////////////////////////////////////////////////////////////////////
// xbtit - Bittorrent tracker/frontend
//
// Copyright (C) 2004 - 2015  Btiteam 
//
//    This file is part of xbtit DT (DC) FM - 05/2014 DiemThuy.
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
// IMDb Suggest with jQuery Autocomplete
// Author: Abhinay Rathore
// Demo: http://lab.abhinayrathore.com/imdb_suggest/
// Website: http://www.AbhinayRathore.com
// Blog: http://web3o.blogspot.com
// Last Updated: Oct 26, 2011
////////////////////////////////////////////////////////////////////////////////////
try{
    $term = trim(strtolower($_REQUEST['term']));
    $search = str_replace(array(" ", "(", ")"), array("_", "", ""), $term); //format search term
    $firstchar = substr($search,0,1); //get first character
    $url = "http://sg.media-imdb.com/suggests/${firstchar}/${search}.json"; //format IMDb suggest URL
    $jsonp = @file_get_contents($url); //get JSONP data
    preg_match('/^imdb\$.*?\((.*?)\)$/ms', $jsonp, $matches); //convert JSONP to JSON
    $json = $matches[1];
    $arr = json_decode($json, true);
    $s = array(); //New array for jQuery Autocomplete data format
    if(isset($arr['d'])){
        foreach($arr['d'] as $d){
            $img = preg_replace('/_V1_.*?.jpg/ms', "_V1._SY50.jpg", $d['i'][0]);
            $s[] = array('label' => $d['l'], 'value' => $d['id'], 'cast' => $d['s'], 'img' => $img, 'search' => $d['search']);
        }
    }
    header('content-type: application/json; charset=utf-8');
    echo json_encode($s); //Convert it to JSON again
} catch (Exception $e){
    //Do nothing
}
?>