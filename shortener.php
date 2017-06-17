<?php
$con = mysql_connect("localhost", "root", "") or die("Connection error: ". mysql_error());
$db = mysql_select_db("urlshortner", $con);
 
if(isset($_REQUEST['uri'])){
 $req = mysql_real_escape_string($_REQUEST['uri']);
 $get = mysql_query("select * from urlshort where short='$req'");
 $url = mysql_fetch_array($get);
 if(mysql_num_rows($get) == 0){
 echo "Error invalid url";
 exit();
 }else{
 header('location: '.$url['url']);
 exit();
 }
 
}
?>
<form method="post" action="">
 <div>
 <label>URL</label>
 <input type="text" name="url" placeholder="Paste your URL">
 </div>
 <div>
 <input type="submit" value="Shorten">
 </div>
</form>
 
<?php
if(isset($_POST['url'])){
 // Get data 
 $url = mysql_real_escape_string($_POST['url']);
 $uniqueUrl = randomUrl($type = 'alphanumeric');
 $host = "http://localhost/UrlShortner/";
 // Insert data
 $ins = mysql_query("insert into `urlshort` set url='$url', short='$uniqueUrl'") or die(mysql_error());
 if($ins){
 echo "Your short url is created : <a href='".$host.$uniqueUrl."'>".$host.$uniqueUrl."</a>";
 }else{
 echo "Error: creating short url";
 }
 
}
/*
 * Function to generate random string for unique url
*/
function randomUrl($type = 'alphanumeric', $length = 4){
 $str = '';
 switch($type):
 case 'alphanumeric':
 $possible = "23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ";
 break;
 case 'alpha':
 $possible = "abcdefghijklmnopqrstuvwxyz";
 break;
 case 'numeric':
 $possible = "0123456789";
 break;
 endswitch;
 
 $i = 0;
 while ($i < $length) {
 $str .= substr( $possible, mt_rand( 0, strlen( $possible )-1 ), 1 );
 $i++;
 }
 return $str;
}
?>
