<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?=$_header_title?></title>
        <link rel="shortcut icon" href="<?=$_base?>/img/favicon.png" />
        <link rel="stylesheet" href="<?=$_base?>/layouts/Bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?=$_base?>/layouts/Bootstrap/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="<?=$_base?>/layouts/Bootstrap/css/style.css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="<?=$_base?>/js/html5shiv.js"></script>
            <script src="<?=$_base?>/js/respond.js"></script>
        <![endif]-->
        <script src="<?=$_base?>/js/jquery.js"></script>
        <script src="<?=$_base?>/layouts/Bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var _url = "<?=$_url?>",
                _base = "<?=$_base?>",
                _request = "<?=$_request?>"
            ;
        </script>
        <script type="text/javascript" src="<?=$_base?>/js/__.js"></script>
        <script type="text/javascript" src="<?=$_base?>/js/form.js"></script>
<?php if (\sowerphp\core\App::layerExists('sowerphp/general')) : ?>
        <link rel="stylesheet" href="<?=$_base?>/css/navpanel.css" />
        <script type="text/javascript" src="<?=$_base?>/js/datepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?=$_base?>/js/datepicker/bootstrap-datepicker.es.js"></script>
        <link rel="stylesheet" href="<?=$_base?>/js/datepicker/datepicker3.css" />
        <link rel="stylesheet" href="<?=$_base?>/css/font-awesome.min.css" />
<?php endif; ?>
<?php if (\sowerphp\core\App::layerExists('sowerphp/app')) : ?>
        <script type="text/javascript" src="<?=$_base?>/js/app.js"></script>
<?php endif; ?>
<?php if (file_exists(DIR_PROJECT.'/website/webroot/css/custom.css')) : ?>
        <link rel="stylesheet" href="<?=$_base?>/css/custom.css" />
<?php endif; ?>
<?=$_header_extra?>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Ocultar mostrar navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=$_base?>/"><?=$_body_title?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
<?php
foreach ($_nav_website as $link=>$name) {
    $active = $_page == $link ? ' active' : '';
    if ($link[0]=='/') $link = $_base.$link;
    if (isset($name['nav'])) {
        echo '                        <li class="dropdown',$active,'">',"\n";
        echo '                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">',$name['name'],' <span class="caret"></span></a>',"\n";
        echo '                            <ul class="dropdown-menu" role="menu">',"\n";
        foreach($name['nav'] as $l=>$n) {
            echo '                                <li><a href="',$link,$l,'">',$n,'</a></li>',"\n";
        }
        echo '                            </ul>',"\n";
        echo '                        </li>',"\n";
    } else {
        if (is_array($name)) {
            $title = isset($name['desc']) ? $name['desc'] : (isset($name['title']) ? $name['title'] : '');
            $name = $name['name'];
        } else $title = '';
        echo '                        <li class="'.$active.'"><a href="',$link,'" title="',$title,'">',$name,'</a></li>',"\n";
    }
}
?>
                    </ul>
<?php if (\sowerphp\core\App::layerExists('sowerphp/app')) : ?>
                    <ul class="nav navbar-nav navbar-right">
<?php if (!$_Auth->logged()) : ?>
                        <li><a href="<?=$_base?>/usuarios/ingresar"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar sesión</a></li>
<?php else : ?>
<?php
$Account = $_Auth->User->getEmailAccount();
if ($Account) {
    $emails = $Account->countUnreadMessages();
    echo '                        <li class="notification"><a href="'.$Account->getUserUrl().'" target="_blank"><i class="fa fa-envelope-o"></i> '.($emails?' <span class="badge">'.$emails.'</span>':'').'</a></li>',"\n";
}
?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>Aplicación <span class="caret"></span></strong></a>
                            <ul class="dropdown-menu" role="menu">
<?php
foreach ($_nav_app as $link=>&$info) {
    if ($_Auth->check($link)) {
        if(!is_array($info)) $info = ['name'=>$info];
        echo '                                <li><a href="',$_base,$link,'">',$info['name'],'</a></li>',"\n";
    }
}
?>
                                <li class="divider"></li>
<?php if (\sowerphp\core\Module::loaded('Sistema.Enlaces')) : ?>
                                <li><a href="<?=$_base?>/enlaces"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Enlaces</a></li>
<?php endif; ?>
<?php if (\sowerphp\core\Module::loaded('Rrhh')) : ?>
                                <li><a href="<?=$_base?>/rrhh/empleados/cumpleanios"><span class="fa fa-birthday-cake" aria-hidden="true"></span> Cumpleaños</a></li>
<?php endif; ?>
                                <li><a href="<?=$_base?>/documentacion"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Documentación</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=$_base?>/usuarios/perfil"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Perfil de usuario</a></li>
                                <li><a href="<?=$_base?>/usuarios/salir"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Cerrar sesión</a></li>
                            </ul>
                        </li>
<?php endif; ?>
                    </ul>
<?php endif; ?>
                </div>
            </div>
        </div>
        <div class="container main-container">
<!-- BEGIN MAIN CONTENT -->
<?php
// menú de módulos si hay sesión iniciada
if (\sowerphp\core\App::layerExists('sowerphp/app') and $_Auth->logged() and $_module_breadcrumb) {
    echo '<ol class="breadcrumb">',"\n";
    $url = '/';
    foreach ($_module_breadcrumb as $link => &$name) {
        if (is_string($link)) {
            echo '    <li><a href="',$_base,$url,$link,'">',$name,'</a></li>',"\n";
            $url .= $link.'/';
        } else {
            echo '    <li class="active">',$name,'</li>';
        }
    }
    echo '</ol>',"\n";
}
// mensaje de sesión
$message = \sowerphp\core\Model_Datasource_Session::message();
if ($message) {
    $icons = [
        'success' => 'ok',
        'info' => 'info-sign',
        'warning' => 'warning-sign',
        'danger' => 'exclamation-sign',
    ];
    echo '<div class="alert alert-',$message['type'],'" role="alert">',"\n";
    echo '    <span class="glyphicon glyphicon-',$icons[$message['type']],'" aria-hidden="true"></span>',"\n";
    echo '    <span class="sr-only">',$message['type'],': </span>',$message['text'],"\n";
    echo '</div>'."\n";
}
// contenido de la página
echo $_content;
?>
<!-- END MAIN CONTENT -->
        </div>
         <footer class="footer">
            <div class="container">
                <div class="text-muted pull-left">
                    <?=(is_array($_footer)?$_footer['left']:$_footer)."\n"?>
                </div>
                <div class="text-muted pull-right" style="text-align:right">
<?=!empty($_footer['right'])?'                    '.$_footer['right'].'<br/>'."\n":''?>
<?php
if (isset($_Auth) and $_Auth->logged()) {
    echo '                    <span>';
    echo '[stats] time: ',round(microtime(true)-TIME_START, 2),' [s] - ';
    echo 'memory: ',round(memory_get_usage()/1024/1024,2),' [MiB] - ';
    echo 'querys: ',\sowerphp\core\Model_Datasource_Database_Manager::$querysCount,' - ';
    echo 'cache: ',\sowerphp\core\Cache::$setCount,'/',\sowerphp\core\Cache::$getCount,'</span>',"\n";
}
?>
                </div>
            </div>
        </footer>
    </body>
</html>
