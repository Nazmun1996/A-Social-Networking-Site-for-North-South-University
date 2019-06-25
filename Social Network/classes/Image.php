<?php
class Image
{
    public static function uploadImage($formname, $query, $params)
    {
        $client_id = '9a207d3f25eb29b';
        $image = base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.imgur.com/3/image.json',
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Client-ID ' . $client_id
            ) ,
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POSTFIELDS => array(
                'image' => $image
            )
        ));
        $out = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($out);
        $preparams = array(
            $formname => $response->data->link
        );
        $params = $preparams + $params;
        DB::query($query, $params);
    }
}
