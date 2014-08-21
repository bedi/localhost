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

        <title>localhost</title>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    </head>
    <body>

        <div class="container theme-showcase" role="main">

            <div class="page-header">
                <h1>Localhost server</h1>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p>PHP 5, Apache 2, MySQL 5</p>
                </div>
            </div>

            <div class="page-header">
                <h2>Server Configuration</h2>
            </div>

            <div class="row">

                <div class="col-sm-3">

                    <ul class="list-group">
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading">Apache Version</h4>
                            <p class="list-group-item-text">
                                <?php
                                $apacheVersion = apache_get_version();
                                $array = explode(" ", $apacheVersion);
                                $array = explode("/", $array[0]);
                                echo $array[1];
                                ?>
                            </p>
                        </a>
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading">PHP Version</h4>
                            <p class="list-group-item-text"><?php echo $phpVersion = phpversion(); ?></p>
                        </a>
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading">MySQL Version</h4>
                            <p class="list-group-item-text">
                                <?php
                                $mysqlVersion = mysql_get_client_info();
                                $array = explode(" ", $mysqlVersion);
                                $array = explode("-", $array[1]);
                                echo $array[0];
                                ?>
                            </p>
                        </a>
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

            <div class="page-header">
                <h2>Tools</h2>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <a href="?phpinfo" class="btn btn-primary btn-lg" role="button">PHP info »</a>
                    <a href="//localhost/phpmyadmin" class="btn btn-primary btn-lg btn-warning" role="button">phpMyAdmin »</a>
                </div>
            </div>

            <div class="page-header">
                <h2>My projects</h2>
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
                echo '</div></div>';
                closedir($handle);
                ?>

            </div>


        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>







<?php

// repertoires à ignorer dans les projets
$projectsListIgnore = array ('.','..');


// textes
$langues = array(
    'en' => array(
        'langue' => 'English',
        'autreLangue' => 'Version Fran&ccedil;aise',
        'autreLangueLien' => 'fr',
        'titreHtml' => 'WAMP5 Homepage',
        'titreConf' => 'Server Configuration',
        'versa' => 'Apache Version :',
        'versp' => 'PHP Version :',
        'versm' => 'MySQL Version :',
        'phpExt' => 'Loaded Extensions : ',
        'titrePage' => 'Tools',
        'txtProjet' => 'Your Projects',
        'txtNoProjet' => 'No projects yet.<br />To create a new one, just create a directory in \'www\'.',
        'txtAlias' => 'Your Aliases',
        'txtNoAlias' => 'No Alias yet.<br />To create a new one, use the WAMP5 menu.',
        'faq' => 'http://www.en.wampserver.com/faq.php'
    ),
    'fr' => array(
        'langue' => 'Français',
        'autreLangue' => 'English Version',
        'autreLangueLien' => 'en',
        'titreHtml' => 'Accueil WAMP5',
        'titreConf' => 'Configuration Serveur',
        'versa' => 'Version de Apache:',
        'versp' => 'Version de PHP:',
        'versm' => 'Version de MySQL:',
        'phpExt' => 'Extensions Charg&eacute;es: ',
        'titrePage' => 'Outils',
        'txtProjet' => 'Vos Projets',
        'txtNoProjet' => 'Aucun projet.<br /> Pour en ajouter un nouveau, cr&eacute;ez simplement un r&eacute;pertoire dans \'www\'.',
        'txtAlias' => 'Vos Alias',
        'txtNoAlias' => 'Aucun alias.<br /> Pour en ajouter un nouveau, utilisez le menu de WAMP5.',
        'faq' => 'http://www.wampserver.com/faq.php'
    )
);



// images
$pngFolder = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABhlBMVEX//v7//v3///7//fr//fj+/v3//fb+/fT+/Pf//PX+/Pb+/PP+/PL+/PH+/PD+++/+++7++u/9+vL9+vH79+r79+n79uj89tj89Nf889D88sj78sz78sr58N3u7u7u7ev777j67bL67Kv46sHt6uP26cns6d356aP56aD56Jv45pT45pP45ZD45I324av344r344T14J734oT34YD13pD24Hv03af13pP233X025303JL23nX23nHz2pX23Gvn2a7122fz2I3122T12mLz14Xv1JPy1YD12Vz02Fvy1H7v04T011Py03j011b01k7v0n/x0nHz1Ejv0Hnuz3Xx0Gvz00buzofz00Pxz2juz3Hy0TrmznzmzoHy0Djqy2vtymnxzS3xzi/kyG3jyG7wyyXkwJjpwHLiw2Liw2HhwmDdvlXevVPduVThsX7btDrbsj/gq3DbsDzbrT7brDvaqzjapjrbpTraojnboTrbmzrbmjrbl0Tbljrakz3ajzzZjTfZijLZiTJdVmhqAAAAgnRSTlP///////////////////////////////////////8A////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////9XzUpQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAB90RVh0U29mdHdhcmUATWFjcm9tZWRpYSBGaXJld29ya3MgOLVo0ngAAACqSURBVBiVY5BDAwxECGRlpgNBtpoKCMjLM8jnsYKASFJycnJ0tD1QRT6HromhHj8YMOcABYqEzc3d4uO9vIKCIkULgQIlYq5haao8YMBUDBQoZWIBAnFtAwsHD4kyoEA5l5SCkqa+qZ27X7hkBVCgUkhRXcvI2sk3MCpRugooUCOooWNs4+wdGpuQIlMDFKiWNbO0dXTx9AwICVGuBQqkFtQ1wEB9LhGeAwDSdzMEmZfC0wAAAABJRU5ErkJggg==
EOFILE;
$pngFolderGo = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJISURBVDjLpZPLS5RhFIef93NmnMIRSynvgRF5KWhRlmWbbotwU9sWLupfCBeBEYhQm2iVq1oF0TKIILIkMgosxBaBkpFDmpo549y+772dFl5bBIG/5eGch9+5KRFhOwrYpmIAk8+OjScr29uV2soTotzXtLOZLiD6q0oBUDjY89nGAJQErU3dD+NKKZDVYpTChr9a5sdvpWUtClCWqBRxZiE/9+o68CQGgJUQr8ujn/dxugyCSpRKkaw/S33n7QQigAfxgKCCitqpp939mwCjAvEapxOIF3xpBlOYJ78wQjxZB2LAa0QsYEm19iUQv29jBihJeltCF0F0AZNbIdXaS7K6ba3hdQey6iBWBS6IbQJMQGzHHqrarm0kCh6vf2AzLxGX5eboc5ZLBe52dZBsvAGRsAUgIi7EFycQl0VcDrEZvFlGXBZshtCGNNa0cXVkjEdXIjBb1kiEiLd4s4jYLOKy9L1+DGLQ3qKtpW7XAdpqj5MLC/Q8uMi98oYtAC2icIj9jdgMYjNYrznf0YsTj/MOjzCbTXO48RR5XaJ35k2yMBCoGIBov2yLSztNPpHCpwKROKHVOPF8X5rCeIv1BuMMK1GOI02nyZsiH769DVcBYXRneuhSJ8I5FCmAsNomrbPsrWzGeocTz1x2ht0VtXxKj/Jl+v1y0dCg/vVMl4daXKg12mtCq9lf0xGcaLnA2Mw7hidfTGhL5+ygROp/v/HQQLB4tPlMzcjk8EftOTk7KHr1hP4T0NKvFp0vqyl5F18YFLse/wPLHlqRZqo3CAAAAABJRU5ErkJggg==
EOFILE;
$pngPlugin = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsSAAALEgHS3X78AAAABGdBTUEAALGOfPtRkwAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAABmklEQVR42mL4//8/AyUYIIDAxK5du1BwXEb3/9D4FjBOzZ/wH10ehkF6AQIIw4B1G7b+D09o/h+X3gXG4YmteA0ACCCsLghPbPkfm9b5PzK5439Sdg9eAwACCEyANMBwaFwTGIMMAOEQIBuGA6Mb/qMbABBAEAOQnIyMo1M74Tgiqf2/b3gVhgEAAQQmQuKa/8ekdYMxyLCgmEYMHJXc9t87FNMAgACCGgBxIkgzyDaQU5FxQGQN2AUBUXX/vULKwdgjsOQ/SC9AAKEEYlB03f+oFJABdSjYP6L6P0guIqkVjt0DisEGAAQQigEgG0AhHxBVi4L9wqvBBiEHtqs/xACAAAIbEBBd/x+Eg2ObwH4FORmGfYCaQRikCUS7B5YBNReBMUgvQABBDADaAtIIwsEx9f/Dk9pQsH9kHTh8XANKMAIRIIDAhF9ELTiQQH4FaQAZCAsskPNhyRpkK7oBAAEEMSC8GsVGkEaYIlBghcU3gbGzL6YBAAEEJnzCgP6EYs/gcjCGKQI5G4Z9QiswDAAIIAZKszNAgAEAHgFgGSNMTwgAAAAASUVORK5CYII=
EOFILE;
$pngWrench = <<< EOFILE
iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAABO1BMVEXu7u7n5+fk5OTi4uLg4ODd3d3X19fV1dXU1NTS0tLPz8+7z+/MzMy6zu65ze65zu7Kysq3zO62zO3IyMjHx8e1yOiyyO2yyOzFxcXExMSyxue0xuexxefDw8OtxeuwxOXCwsLBwcGuxOWsw+q/v7+qweqqwuqrwuq+vr6nv+qmv+m7u7ukvumkvemivOi5ubm4uLicuOebuOeat+e0tLSYtuabtuaatuaXteaZteaatN6Xs+aVs+WTsuaTsuWRsOSrq6uLreKoqKinp6elpaWLqNijo6OFpt2CpNyAo92BotyAo9+dnZ18oNqbm5t4nt57nth7ntp4nt15ndp3nd6ZmZmYmJhym956mtJzm96WlpaVlZVwmNyTk5Nvl9lultuSkpKNjY2Li4uKioqIiIiHh4eGhoZQgtVKfNFdha6iAAAAaXRSTlMA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////914ivwAAAACXBIWXMAAAsSAAALEgHS3X78AAAAH3RFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyA4tWjSeAAAAKFJREFUGJVjYIABASc/PwYkIODDxBCNLODEzGiQgCwQxsTlzJCYmAgXiGKVdHFxYEuB8dkTOIS1tRUVocaIWiWI8IiIKKikaoD50kYWrpwmKSkpsRC+lBk3t2NEMgtMu4wpr5aeuHcAjC9vzadjYyjn7w7lK9kK6tqZK4d4wBQECenZW6pHesEdFC9mbK0W7otwsqenqmpMILIn4tIzgpG4ADUpGMOpkOiuAAAAAElFTkSuQmCC
EOFILE;

//affichage du phpinfo
if (isset($_GET['phpinfo']))
{
    phpinfo();
    exit();
}


//affichage des images
if (isset($_GET['img']))
{
    switch ($_GET['img'])
    {
        case 'pngFolder' :
            header("Content-type: image/png");
            echo base64_decode($pngFolder);
            exit();

        case 'pngFolderGo' :
            header("Content-type: image/png");
            echo base64_decode($pngFolderGo);
            exit();

        case 'gifLogo' :
            header("Content-type: image/gif");
            echo base64_decode($gifLogo);
            exit();

        case 'pngPlugin' :
            header("Content-type: image/png");
            echo base64_decode($pngPlugin);
            exit();

        case 'pngWrench' :
            header("Content-type: image/png");
            echo base64_decode($pngWrench);
            exit();

        case 'favicon' :
            header("Content-type: image/x-icon");
            echo base64_decode($favicon);
            exit();
    }
}



// Définition de la langue et des textes 

if (isset ($_GET['lang']))
{
    $langue = $_GET['lang'];
}
elseif (preg_match("/^fr/", $_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
    $langue = 'fr';
}
else
{
    $langue = 'en';
}


$projectContents = '';
$phpExtContents = '';
// recuperation des projets
$handle = opendir(".");
while ($file = readdir($handle))
{
    if (is_dir($file) && !in_array($file,$projectsListIgnore))
    {
        $projectContents .= '<li><a href="'.$file.'">'.$file.'</a></li>';
    }
}
closedir($handle);
if (!isset($projectContents))
    $projectContents = $langues[$langue]['txtNoProjet'];


// recuperation des extensions PHP
$loaded_extensions = get_loaded_extensions();
foreach ($loaded_extensions as $extension)
    $phpExtContents .= "<li>${extension}</li>";


$apacheVersion = apache_get_version();
$phpVersion = phpversion();
$mysqlVersion = mysql_get_client_info();


$pageContents = <<< EOPAGE
<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html lang="en" xml:lang="en">
<head>
	<title>localhost</title>
	<meta http-equiv="Content-Type" content="txt/html; charset=utf-8" />

	<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

html {
	background: #ddd;
}
body {
	margin: 1em 10%;
	padding: 1em 3em;
	font: 80%/1.4 tahoma, arial, helvetica, lucida sans, sans-serif;
	border: 1px solid #999;
	background: #eee;
	position: relative;
}
#head {
	margin-bottom: 1.8em;
	margin-top: 1.8em;
	padding-bottom: 0em;
	border-bottom: 1px solid #999;
	height: 125px;
}
.utility {
	position: absolute;
	right: 4em;
	top: 145px;
	font-size: 0.85em;
}
.utility li {
	display: inline;
}

h2 {
	margin: 0.8em 0 0 0;
}

ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
#head ul li, dl ul li, #foot li {
	list-style: none;
	display: inline;
	margin: 0;
	padding: 0 0.2em;
}
ul.aliases, ul.projects, ul.tools {
	list-style: none;
	line-height: 24px;
}
ul.aliases a, ul.projects a, ul.tools a {
	padding-left: 22px;
	background: url(index.php?img=pngFolder) 0 100% no-repeat;
}
ul.tools a {
	background: url(index.php?img=pngWrench) 0 100% no-repeat;
}
ul.aliases a {
	background: url(index.php?img=pngFolderGo) 0 100% no-repeat;
}
dl {
	margin: 0;
	padding: 0;
}
dt {
	font-weight: bold;
	text-align: right;
	width: 11em;
	clear: both;
}
dd {
	margin: -1.35em 0 0 12em;
	padding-bottom: 0.4em;
	overflow: auto;
}
dd ul li {
	float: left;
	display: block;
	width: 16.5%;
	margin: 0;
	padding: 0 0 0 20px;
	background: url(index.php?img=pngPlugin) 2px 50% no-repeat;
	line-height: 1.6;
}
a {
	color: #024378;
	font-weight: bold;
	text-decoration: none;
}
a:hover {
	color: #04569A;
	text-decoration: underline;
}
#foot {
	text-align: center;
	margin-top: 1.8em;
	border-top: 1px solid #999;
	padding-top: 1em;
	font-size: 0.85em;
}
</style>

</head>

<body>
	<div id="head">
		<h1>BEDI localhost server</h1>
		<ul>
			<li>PHP 5</li>
			<li>Apache 2</li>
			<li>MySQL 5</li>
		</ul>
	</div>

	<h2> {$langues[$langue]['titreConf']} </h2>

	<dl class="content">
		<dt>{$langues[$langue]['versa']}</dt>
		<dd>${apacheVersion} &nbsp;</dd>
		<dt>{$langues[$langue]['versp']}</dt>
		<dd>${phpVersion} &nbsp;</dd>
		<dt>{$langues[$langue]['phpExt']}</dt> 
		<dd>
			<ul>
			${phpExtContents}
			</ul>
		</dd>
		<dt>{$langues[$langue]['versm']}</dt>
		<dd>${mysqlVersion} &nbsp;</dd>
	</dl>
	<h2>{$langues[$langue]['titrePage']}</h2>
	<ul class="tools">
		<li><a href="?phpinfo=1">phpinfo()</a></li>
		<li><a href="phpmyadmin/">phpmyadmin</a></li>
	</ul>
	<h2>{$langues[$langue]['txtProjet']}</h2>
	<ul class="projects">
	$projectContents
	</ul>
	<ul id="foot">
		<li><a href="http://www.bedi.cz">Bedi.cz</a></li>
	</ul>
</body>
</html>
EOPAGE;

//echo $pageContents;