<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<h1 class="content-subhead">Upload</h1>
<p>Welcome to The Daily Sky!<br>Please Upload your weather.dat file to get started!</p>
<form action="/weather/index.php/upload/uploadFile" method="post" class="pure-form" enctype="multipart/form-data"> 
 <input type="file" name="weatherFile">
 <br> <br>
 <input class="pure-button pure-button-primary" type="submit" value="Upload">
</form>
