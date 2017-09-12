<?php
if (isset($_GET['phpinfo'])) {
    phpinfo();
    exit();
}
$config = @include_once 'config-localhost.php';
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Localhost</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="?phpinfo" class="btn btn-primary">PHP info »</a>
                    &nbsp;
                    <?php if (@$config['phpmyadmin_url'])  { ?>
                        <a href="<?php echo $config['phpmyadmin_url']; ?>" class="btn btn-warning">phpMyAdmin »</a>
                    <?php } ?>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h2>My projects</h2>
                    <div class="list-group">
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
                                        if ($subdir == ".git" and file_exists($subdir.'/HEAD')) {
                                            $file = file_get_contents($subdir.'/HEAD');
                                            $branch = str_replace('ref: refs/heads/', '', $file);
                                            $dirs[$i]['git'] = $branch;
                                        }
                                        if ($subdir == "www_root" or $subdir == "public") {
                                            $dirs[$i]['root'] = $file . "/" . $subdir;
                                            break;
                                        }
                                    }
                                    $i++;
                                }
                            }
                        }
                        foreach ($dirs as $dir) { ?>
                            <a href="<?php echo $dir['root']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <span>
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        <?php echo $dir['domain']; ?>
                                    </span>
                                    <small><?php echo @$dir['git']; ?></small>
                                </div>
                            </a>
                        <?php }
                        closedir($handle);
                        ?>
                    </div>
                </div>
                <div class="col-6">
                    <h2>Server Configuration</h2>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action align-items-start">
                            <h5 class="mb-1">Apache version</h5>
                            <p class="mb-1">
                                <?php
                                $apacheVersion = apache_get_version();
                                $array = explode(" ", $apacheVersion);
                                $array = explode("/", $array[0]);
                                echo $array[1];
                                ?>
                            </p>
                        </li>
                        <li class="list-group-item list-group-item-action align-items-start">
                            <h5 class="mb-1">PHP version</h5>
                            <p class="mb-1">
                                <?php echo $phpVersion = phpversion(); ?>
                            </p>
                        </li>
                        <li class="list-group-item list-group-item-action align-items-start">
                            <h5 class="mb-1">SQL version</h5>
                            <p class="mb-1">
                                <?php
                                $mysqlVersion = mysqli_get_client_info();
                                $array = explode(" ", $mysqlVersion);
                                $array = explode("-", $array[1]);
                                echo $array[0];
                                ?>
                            </p>
                        </li>
                    </ul>
                    <hr>
                    <h3>PHP configuration</h3>
                    <ul class="list-group">
                        <li class="list-group-item">
                            allow_url_fopen - <?php echo ini_get('allow_url_fopen'); ?>
                        </li>
                        <li class="list-group-item">
                            allow_url_include - <?php echo ini_get('allow_url_include'); ?>
                        </li>
                        <li class="list-group-item">
                            max_execution_time - <?php echo ini_get('max_execution_time'); ?>
                        </li>
                        <li class="list-group-item">
                            max_file_uploads - <?php echo ini_get('max_file_uploads'); ?>
                        </li>
                        <li class="list-group-item">
                            post_max_size - <?php echo ini_get('post_max_size'); ?>
                        </li>
                        <li class="list-group-item">
                            upload_max_filesize - <?php echo ini_get('upload_max_filesize'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    </body>
</html>