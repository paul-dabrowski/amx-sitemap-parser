<?php
$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AMX Product Index</title>
</head>
<style>body,table{background:#FFF}body,p{font-weight:300}body,h1{font-style:normal}h1,p{text-rendering:optimizeLegibility}*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}body,html{font-size:100%;height:100%}body{color:#666;padding:0;margin:30px;font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif;line-height:1.5;position:relative;cursor:auto}a:hover{cursor:pointer}input[type=text]{-webkit-appearance:none;border-radius:0;background-color:#fafafa;font-family:inherit;border-style:solid;border-width:1px;border-color:#ccc;box-shadow:inset 0 1px 2px rgba(0,0,0,.1);color:rgba(0,0,0,.65);display:block;font-size:.875rem;margin:0 0 1.125rem;padding:.5625rem;height:2.5rem;width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;transition:box-shadow .45s,border-color .45s ease-in-out}#myInput,#myTable{border:1px solid #ddd}input[type=text]:focus{box-shadow:0 0 5px #999;background:#fff;border-color:#999;outline:0}input[type=text]:disabled{background-color:#DDD;cursor:default}table{margin-bottom:1.25rem;border:1px solid #fff;table-layout:auto}table tr td{padding:.5625rem .625rem;font-size:.875rem;color:#222;text-align:left}table tbody tr td,table tr td{display:table-cell;line-height:1.125rem}h1,p,td{margin:0;padding:0}a{color:#0b406b;text-decoration:none;line-height:inherit}a:focus,a:hover{color:#0d4e82}p{font-family:inherit;font-size:1rem;line-height:1.6;margin-bottom:1.25rem}h1{font-family:"Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif;font-weight:500;color:#444;margin-top:.625rem;margin-bottom:.5rem;line-height:1.4;font-size:1.75rem}@media only screen and (min-width:40.063em){h1{line-height:1.4;font-size:2.375rem}}@media print{*{background:0 0!important;color:#000!important;box-shadow:none!important;text-shadow:none!important}a,a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}tr{page-break-inside:avoid}@page{margin:.5cm}p{orphans:3;widows:3}body{margin-top:20px;margin-bottom:20px}}body:after{display:none}#myInput{position:fixed;top:10px;left:30px;width:80%;font-size:16px;padding:12px 20px 12px 40px;margin-bottom:12px}#myTable{border-collapse:collapse;width:100%;font-size:18px}#myTable td{text-align:left;padding:12px}#myTable tr{border-bottom:1px solid #ddd}#myTable tr:hover{background-color:#f1f1f1}</style>
<body>
<p>&nbsp;</p>
<h1>AMX Product Index</h1>
<input type="text" id="myInput" onkeyup="mySearchFunction()" placeholder="Search for products..">
<table id="myTable">';

$destfile = 'AMXindex.html'; //Destination filename for the final result.
$filename = 'sitemap.xml'; //Local filename for the sitemap to be parsed.

//check if filelocation is writeable
if( (is_writable(__FILE__)) || (is_writable($destfile)) ) {
  set_time_limit(400);
} else {
  echo $header;
  echo '<h2>Filename '.$destfile.' is not writeable. Please check file and/or directory permissions</h2>';
  echo '</body></html>';
  die();
}
 
$currentElement = '';
$currentLoc = '';
$map = "\n";
function parsePage($data)
{
 global $map;
 $ch = curl_init($data);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HEADER, 0);

   $contents = curl_exec($ch);

   // find the title
   preg_match('/(?<=\<[Tt][Ii][Tt][Ll][Ee]\>)\s*?(.*?)\s*?(?=\<\/[Tt][Ii][Tt][Ll][Ee]\>)/U', $contents, $title);
   $title = $title[0];
 
   // find the first h1 tag
   $header = array();
   preg_match('/(?<=\<[Hh]3\>)(.*?)(?=\<\/[Hh]3\>)/U', $contents, $header);
   $header = strip_tags($header[0]);
 
   if ( strlen($title) > 0 && strlen($header) > 0 ) {
    // print the title and h1 tag in combo
    $map .= '<tr><td class="link"><a href="'.str_replace('&','&amp;',$data).'" title="'.(strlen($header)>0?trim($header):trim($title)).'">'.trim($title).(strlen($header)>0?" - ".trim($header):'').'</a></td>'."\n";
   } elseif ( strlen($title) > 0 ) {
    $map .= '<tr><td class="link"><a href="'.str_replace('&','&amp;',$data).'" title="'.trim($title).'">'.trim($title).'</a></td>'."\n";
   } elseif ( strlen($header) > 0 ) {
    $map .= '<tr><td class="link"><a href="'.str_replace('&','&amp;',$data).'" title="'.trim($header).'">'.trim($header).'</a></td>'."\n";
   } else {
    $map .= '<tr><td class="link"><a href="'.str_replace('&','&amp;',$data).'" title="'.trim($data).'">'.trim($data).'</a></td>'."\n";
   };
 
   // find description
   preg_match('/(?<=\<[Mm][Ee][Tt][Aa]\s[Nn][Aa][Mm][Ee]\=\"[Dd]escription\" content\=\")(.*?)(?="\s*?\/?\>)/U', $contents, $description);
   $description = $description[0];
 
   // print description
    if ( strlen($description)>0 ) {
      $map .= '<td class="desc">'.trim($description).'</td></tr>'."\n";
    } else if ( strlen($title) > 0 ){
      $map .= '<td class="desc">'.trim($title).'</td></tr>'."\n";
    } else if ( strlen($header) > 0 ){
      $map .= '<td class="desc">'.trim($header).'</td></tr>'."\n";
    } else {
      $map .= '<td class="desc">Product Name</td></tr>'."\n";
    };
   // close the file
   curl_close($ch);
};

 
/////////// XML PARSE FUNCTIONS HERE /////////////
// the start element function
function startElement($xmlParser, $name, $attribs)
{
 global $currentElement;
 $currentElement = $name;
};
 
// the end element function
function endElement($parser, $name)
{
 global $currentElement,$currentLoc;
 if ( $currentElement == 'loc') {
    if (strpos($currentLoc, 'products' )) {
    parsePage($currentLoc);
    $currentLoc = '';
  };
 };
 $currentElement = '';
};
 
// the character data function
function characterData($parser, $data) 
{
 global $currentElement,$currentLoc;
 // if the current element is loc then it will be a url
 if ( $currentElement == 'loc' ) {
  if (strpos($data, 'products' )) {
    $currentLoc .= $data;
  }
 };
};
 
// create parse object
$xml_parser = xml_parser_create();
// turn off case folding!
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
// set start and end element functions
xml_set_element_handler($xml_parser,"startElement", "endElement");
// set character data function
xml_set_character_data_handler($xml_parser, "characterData");
 
// open xml file

if ( !($fp = fopen($filename, "r")) ) {
 die("could not open XML input");
};

// read the file - print error if something went wrong.
while ( $data = fread($fp,filesize($filename)) ) {
 if ( !xml_parse($xml_parser, $data,feof($fp)) ) {
  die(sprintf("XML error: %s at line %d",xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser)));
 };
};
 
// close file
fclose($fp);

$footer = '</table>
<script>function mySearchFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
</body></html>';

// write output to a file
$fp2 = fopen($destfile, "w+");
fwrite($fp2,$header.$map.$footer);
fclose($fp2);
 
// print output
echo $header.$map.$footer;