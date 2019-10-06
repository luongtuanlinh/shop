To Email:  {{ $user }},
<br>
Click here to change your password: <b> {{((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http"). "://".@$_SERVER['HTTP_HOST']."/admin/password/reset/".$token }} </b>.
