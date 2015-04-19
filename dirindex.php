<?PHP
  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  function getFileList($dir)
  {
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // open directory for reading
    $d = new DirectoryIterator($dir) or die("getFileList: Failed opening directory $dir for reading");
    foreach($d as $fileinfo) {
      // skip hidden files
      if($fileinfo->isDot()) continue;
      $retval[] = array(
        'name' => "{$dir}{$fileinfo}",
        'type' => ($fileinfo->getType() == "dir") ? "dir" : mime_content_type($fileinfo->getRealPath()),
        'size' => $fileinfo->getSize(),
        'lastmod' => $fileinfo->getMTime()
      );
    }

    return $retval;
  }
?>

<h1>Directory Listing using SPL</h1>

<table class="collapse" border="1">
<thead>
<tr><th>Name</th><th>Type</th><th>Size</th><th>Last Modified</th></tr>
</thead>
<tbody>
<?PHP
  $dirlist = getFileList("images/");
  // output file list as table rows
  foreach($dirlist as $file) {
    echo "<tr>\n";
    echo "<td><a href=\"{$file['name']}\">",basename($file['name']),"</a></td>\n";
    echo "<td>{$file['type']}</td>\n";
    echo "<td>{$file['size']}</td>\n";
    echo "<td>",date('r', $file['lastmod']),"</td>\n";
    echo "</tr>\n";
  }
?>
</tbody>
</table>