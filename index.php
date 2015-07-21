<?php
if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="localhost">
        <meta name="author" content="Petr Malecha, www.bedi.cz">
        <title>localhost</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="container theme-showcase" role="main">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header">
                        <h1>Localhost server</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header">
                        <h2>Tools</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a href="?phpinfo" class="btn btn-primary btn-lg" role="button">PHP info »</a>
                    <a href="//localhost/phpmyadmin" class="btn btn-primary btn-lg btn-warning" role="button">phpMyAdmin »</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header">
                        <h2>My projects</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $projectsListIgnore = array ('.','..');
                $handle = opendir('.');
                $dirs = array();
                $i = 0;
                $in_column = 0;
                while ($file = readdir($handle)) {
                    if (is_dir($file) && !in_array($file, $projectsListIgnore)) {
                        if (strpos($file, '.') !== 0) {
                            $subdirs = scandir($file);
                            $dirs[$i]['domain'] = $file;
                            $dirs[$i]['root'] = $file;
                            foreach ($subdirs as $subdir) {
                                if ($subdir == "www_root" or $subdir == "public") {
                                    $dirs[$i]['root'] = $file . "/" . $subdir;
                                    break;
                                }
                            }
                            $i++;
                        }
                    }
                }
                $in_column = ceil(count($dirs) / 3);
                $i=0;
                foreach ($dirs as $dir) {
                    if ($i == 0 or $i == $in_column or $i == $in_column*2) {
                        echo '<div class="col-sm-4"><div class="list-group">';
                    }
                    echo '<a href="'.$dir['root'].'" class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; &nbsp;'.$dir['domain'].'</a>';
                    if ($i == $in_column-1 or $i == ($in_column*2)-1) {
                        echo '</div></div>';
                    }
                    $i++;
                }
                if (!empty($dirs)) {
                    echo '</div></div>';
                }
                closedir($handle);
                ?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-header">
                        <h2>Server Configuration</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">Apache Version</h4>
                            <p class="list-group-item-text">
                                <?php
                                $apacheVersion = apache_get_version();
                                $array = explode(" ", $apacheVersion);
                                $array = explode("/", $array[0]);
                                echo $array[1];
                                ?>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">PHP Version</h4>
                            <p class="list-group-item-text"><?php echo $phpVersion = phpversion(); ?></p>
                        </li>
                        <li class="list-group-item">
                            <h4 class="list-group-item-heading">MySQL Version</h4>
                            <p class="list-group-item-text">
                                <?php
                                $mysqlVersion = mysql_get_client_info();
                                $array = explode(" ", $mysqlVersion);
                                $array = explode("-", $array[1]);
                                echo $array[0];
                                ?>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">PHP configuration</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        allow_url_fopen - <?php echo ini_get('allow_url_fopen'); ?>
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        allow_url_include - <?php echo ini_get('allow_url_include'); ?>
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        max_execution_time - <?php echo ini_get('max_execution_time'); ?>
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        max_file_uploads - <?php echo ini_get('max_file_uploads'); ?>
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        post_max_size - <?php echo ini_get('post_max_size'); ?>
                                    </p>
                                </li>
                                <li class="list-group-item">
                                    <p class="list-group-item-text">
                                        upload_max_filesize - <?php echo ini_get('upload_max_filesize'); ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Loaded PHP Extensions</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                $loaded_extensions = get_loaded_extensions();
                                natcasesort($loaded_extensions);
                                echo implode(', ', $loaded_extensions);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Loaded Apache Modules</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            $loaded_extensions = apache_get_modules();
                            natcasesort($loaded_extensions);
                            echo implode(', ', $loaded_extensions);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>