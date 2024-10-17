<?php
$url_host = 'http://' . $_SERVER['HTTP_HOST'];
$pattern_document_root = addcslashes(realpath($_SERVER['DOCUMENT_ROOT']), '\\');
$pattern_uri = '/' . preg_quote($pattern_document_root, '/') . '(.*)$/';

preg_match_all($pattern_uri, __DIR__, $matches);

if (isset($matches[1][0])) {
    $url_path = $url_host . $matches[1][0];
} else {
    $url_path = '';  // Chuỗi rỗng nếu không có dữ liệu
}

$url_path = str_replace('\\', '/', $url_path);

if (!class_exists('lessc')) {
    $dir_block = dirname($_SERVER['SCRIPT_FILENAME']);
    require_once($dir_block . '/libs/lessc.inc.php');
}
$less = new lessc;
$less->compileFile('less/1354.less', 'css/1354.css');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>1354</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
              <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
              <link rel="stylesheet" href="css/1354.css"> 
    </head>
    <body>
        <?php require_once './1354-content.php'; ?>
    </body>
</html>
