<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CRM</title>
    <!-- Bootstrap Core CSS -->
    <link href="/public/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/public/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/public/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="/public/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="/public/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/public/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="/public/css/admin.css" rel="stylesheet">
    <!--Bootstrap Datepicker CSS-->
    <link href="/public/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!--Bootstrap Datepicker JavaScript-->
    <script src="/public/js/moment-with-locales.js"></script>
    <script src="/public/js/bootstrap-datetimepicker.js"></script>
    <!--Bootstrap Typeahead JavaScript-->
    <script src="/public/js/bootstrap3-typeahead.min.js"></script>
    <!--Custom JavaScript-->
    <script src="/public/js/admin.js?v=2"></script>
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">
                Admin panel
            </a>
        </div>
        <!-- /.navbar-header -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href=""><i class="fa fa-dashboard fa-fw"></i> Панель управления</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil fa-fw"></i> Редактирование страниц<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="/admin/control_panel/pages_list">Основные страницы</a></li>
                            <li><a href="/admin/control_panel/news_list">Новости</a></li>
                            <li><a href="/admin/control_panel/articles_list">Статьи</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-list fa-fw"></i> Редактирование меню<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="/admin/control_panel/mainmenu_list">Главное меню</a></li>
                            <li><a href="/admin/control_panel/submenu_list">Подменю</a></li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
        <form class="col-sm-1 col-md-1 pull-right logout-form" method="post">
            <button class="btn btn-default"><i class="fa fa-sign-out fa-fw"></i></button>
            <input type="hidden" name="logout">
        </form>
    </nav>
    <div id="page-wrapper">
        <?=$admin_content;?>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="errorModalLabel">Ошибка</h4>
            </div>
            <div class="modal-body" id="errorModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- /#errorModal -->
<!-- Bootstrap Core JavaScript -->
<script src="/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="/public/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="/public/dist/js/sb-admin-2.js"></script>
<!-- DataTables JavaScript -->
<script src="/public/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/public/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>

</html>
