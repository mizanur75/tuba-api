<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>@yield('title')</title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="assets/img/admin/favicon.ico" type="image/x-icon"/>

  <!-- Fonts and icons -->
  <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
  <script>
    WebFont.load({
      google: {"families":["Public Sans:300,400,500,600,700"]},
      custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("assets/css/fonts.min.css")}}']},
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/plugins.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/admin.min.css')}}">
  @stack('css')
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End Sidebar -->

    <div class="main-panel">
      @include('layouts.header')      
      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Admin Dashboard</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
              <a href="#" class="btn btn-primary btn-round">Add Customer</a>
            </div>
          </div>
          
          @yield('body')

        </div>
      </div>
      
      <footer class="footer">
        <div class="container-fluid">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="https://www.devmizanur.com">
                  Mizanur Rahman
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/mizanur.ccr">
                  Facebook
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://www.linkedin.com/in/mizanur75/">
                  Linkedin
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright ms-auto">
            {{date('d M Y')}}, Developed <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.devmizanur.com">Mizanur Rahman</a>
          </div>        
        </div>
      </footer>
    </div>

  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/jquery-3.7.1.min.js')}}"></script>
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

  <!-- Moment JS -->
  <script src="{{asset('assets/js/plugin/moment/moment.min.js')}}"></script>

  <!-- Chart JS -->
  <script src="{{asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

  <!-- jQuery Sparkline -->
  <script src="{{asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

  <!-- Chart Circle -->
  <script src="{{asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

  <!-- Datatables -->
  <script src="{{asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

  <!-- Bootstrap Notify -->
  <script src="{{asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

  <!-- jQuery Vector Maps -->
  <script src="{{asset('assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugin/jsvectormap/world.js')}}"></script>

  <!-- Dropzone -->
  <script src="{{asset('assets/js/plugin/dropzone/dropzone.min.js')}}"></script>

  <!-- Fullcalendar -->
  <script src="{{asset('assets/js/plugin/fullcalendar/fullcalendar.min.js')}}"></script>

  <!-- DateTimePicker -->
  <script src="{{asset('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js')}}"></script>

  <!-- Bootstrap Tagsinput -->
  <script src="{{asset('assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>

  <!-- jQuery Validation -->
  <script src="{{asset('assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>

  <!-- Summernote -->
  <script src="{{asset('assets/js/plugin/summernote/summernote-lite.min.js')}}"></script>

  <!-- Select2 -->
  <script src="{{asset('assets/js/plugin/select2/select2.full.min.js')}}"></script>

  <!-- Sweet Alert -->
  <script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

  <!-- Owl Carousel -->
  <script src="{{asset('assets/js/plugin/owl-carousel/owl.carousel.min.js')}}"></script>

  <!-- Magnific Popup -->
  <script src="{{asset('assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js')}}"></script>

  <!-- admin JS -->
  <script src="{{asset('assets/js/admin.min.js')}}"></script>

  <!-- admin DEMO methods, don't include it in your project! -->
  <script src="{{asset('assets/js/setting-demo.js')}}"></script>
  <script src="{{asset('assets/js/demo.js')}}"></script>
  <script>
    $('#lineChart').sparkline([102,109,120,99,110,105,115], {
      type: 'line',
      height: '70',
      width: '100%',
      lineWidth: '2',
      lineColor: '#177dff',
      fillColor: 'rgba(23, 125, 255, 0.14)'
    });

    $('#lineChart2').sparkline([99,125,122,105,110,124,115], {
      type: 'line',
      height: '70',
      width: '100%',
      lineWidth: '2',
      lineColor: '#f3545d',
      fillColor: 'rgba(243, 84, 93, .14)'
    });

    $('#lineChart3').sparkline([105,103,123,100,95,105,115], {
      type: 'line',
      height: '70',
      width: '100%',
      lineWidth: '2',
      lineColor: '#ffa534',
      fillColor: 'rgba(255, 165, 52, .14)'
    });
  </script>
  @stack('scripts')
</body>
</html>