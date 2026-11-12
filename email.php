<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.zeptomail.com/v1.1/email",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{
"bounce_address":"info@zoho.thekarurtraders.com",
"from": { "address": "noreply@thekarurtraders.com"},
"to": [{"email_address": {"address": "mskathirit@gmail.com","name": "KTGT"}}],
"subject":"Test Email",
"htmlbody":"<div><b> Test email sent successfully. </b></div>",
}
  ]
}',
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "authorization: Zoho-enczapikey wSsVR60k/kGjDP8ozzL+J+xsz1oGBA/3QB563FCj4nSpGv3F88duxUGcBQ/xG6JMF2VpFDBGo7ohyhwChmVcjtokmw4HXSiF9mqRe1U4J3x17qnvhDzJV29elxOOLI0Jxw9ok2JlF8An+g==",
        "cache-control: no-cache",
        "content-type: application/json",
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
?>