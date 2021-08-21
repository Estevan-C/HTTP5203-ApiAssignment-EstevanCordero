<?php

 function idgb($keyword){

     $curl = curl_init();

     curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://api.igdb.com/v4/games',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS => 'fields name, total_rating, follows, url, summary;
            limit 10;
            search'.'"'.$keyword.'"'.';
            where rating > 75;',
         CURLOPT_HTTPHEADER => array(
             'Client-ID: 5phbmxh06rixigjugxdqq2qn0gut55',
             'Authorization: Bearer 6snxw2malygnr6a4852bjxmkrnc413',
             'Content-Type: text/plain'
         ),
     ));

     $response = curl_exec($curl);
     curl_close($curl);

     $data = json_decode($response);

     return $data;
 }

