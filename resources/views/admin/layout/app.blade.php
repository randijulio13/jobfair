<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="/assets/ico/favicon.ico" rel="icon">
    <link href="/assets/sbadmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/assets/sbadmin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="/assets/summernote/summernote-bs4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    @yield('style')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin.layout.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.layout.navbar')
                <div class="container-fluid pb-4">
                    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
                    @yield('content')
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @yield('modal')
    <div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="formPassword">
                            <div class="form-group">
                                <label for="old_password">Password Lama</label>
                                <input type="password" name="old_password" id="old_password" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Ulangi Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="formPassword" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/assets/sbadmin/js/sb-admin-2.min.js"></script>
    <script src="/assets/DataTables/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/summernote/summernote-bs4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/js/my.js"></script>
    @yield('script')
</body>

</html>