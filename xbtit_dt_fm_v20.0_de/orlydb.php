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

//gets the match content
function get_match($regex,$content)
{
        preg_match($regex,$content,$matches);
        return $matches[1];
}


//gets the data from a URL
function get_data($url)
{
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}

//function orlyread
function orlyread($rel) {


        $orlyurl = "http://orlydb.com/?q=".$rel;

        //get the page content
        $orly_content = get_data($orlyurl);
        
        //parse for product name
        $orly['time'] = @get_match('/<span class="timestamp">(.*)<\/span>/isU',$orly_content);
        $orly['section'] = @get_match('/<span class="section"><a [^>]*>(.*)<\/a><\/span>/isU',$orly_content);
        $orly['release'] = @get_match('/<span class="release">(.*)<\/span>/isU',$orly_content);
        $orly['inforight'] = @get_match('/<span class="inforight"><span class="info">(.*)<\/span><\/span>/isU',$orly_content);
        $orly['nukeright'] = @get_match('/<span class="nukeright"><span class="nuke">(.*)<\/span><\/span>/isU',$orly_content);

        return $orly;

}
?>