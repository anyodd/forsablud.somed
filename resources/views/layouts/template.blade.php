<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FORSA BLUD</title>

  <!-- Google Font: Source Sans Pro -->
 {{-- <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('template')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('template')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{asset('template')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('template')}}/dist/css/adminlte.min.css">
  <!-- daterRangePicker -->
  <link rel="stylesheet" href="{{asset('template')}}/plugins/daterangepicker/daterangepicker.css">
  <!-- loader -->
  <link rel="stylesheet" href="{{asset('css')}}/loader.css">
  <!-- scrollToTop -->
  <link rel="stylesheet" href="{{asset('css')}}/scrollToTop.css">
   <!-- slider -->
  <link rel="stylesheet" href="{{asset('css')}}/slider.css">

  @yield('style')  
  <!-- Custom CSS -->
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    @include('layouts.nav')
    @include('layouts.menu')
    <!-- Content Wrapper. Contains page content -->
    {{-- <div class="content-wrapper" 
      style="background-image: url('{{ asset('template') }}/dist/img/icon_login/BG11.png'); background-repeat:no-repeat; background-size: 100%;background-position:center;">
      @yield('content')
    </div> --}}
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      {{-- <div class="float-right d-none d-sm-block">
        <b>Version</b>1.0.0 --}}
        {{-- <img src="{{asset('template')}}/dist/img/logo_rs/logo_bpkp.png" alt="" style="width: 3%"> --}}
      {{-- </div>
      <strong>Copyright &copy; 2022 <a href="#">BLUD</a>.</strong> All rights reserved. --}}
      <div class="row">
        <div class="col-sm-3">
          <img src="{{asset('template')}}/dist/img/logo_rs/logo_bpkp.png" class="float-left" alt="" style="width: 15%">
        </div>
        <div class="col-sm-6">
          Copyright &copy; 2022 <a href="#">Badan Pengawasan Keuangan dan Pembangunan</a>.</strong>
        </div>
        <div class="col-sm-3">
          <img src="{{asset('template')}}/dist/img/logo_rs/logo_dan.png" class="float-right" alt="" style="width: 10%">
        </div>
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- Chart -->
  <script src="{{asset('template')}}/plugins/src/Chart.min.js"></script>
  
  <!-- jQuery -->
  <script src="{{asset('template')}}/plugins/jquery/jquery.min.js"></script> 
  
  <!-- Bootstrap 4 -->
  <script src="{{asset('template')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="{{asset('template')}}/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="{{asset('template')}}/plugins/jszip/jszip.min.js"></script>
  <script src="{{asset('template')}}/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="{{asset('template')}}/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="{{asset('template')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="{{asset('template')}}/plugins/inputmask/jquery.inputmask.min.js"></script>
  
  <!-- Select2 -->
  <script src="{{asset('template')}}/plugins/select2/js/select2.full.min.js"></script>
  <script src="{{asset('template')}}/dist/js/demo.js"></script>
  <script src="{{asset('template')}}/plugins/moment/moment.min.js"></script>
    
  <!-- Sweetalert 2 -->
  <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

  <script type="text/javascript">
  //Initialize Select2 Elements
  $('.select2').select2()
  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })
  </script>
  <!-- daterRangePicker -->
  <script src="{{asset('template')}}/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- scrollToTop -->
  <script src="{{asset('js')}}/scrollToTop.js"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('template')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('template')}}/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('template')}}/dist/js/demo.js"></script>

  <!-- Page specific script -->
  @yield('script')
  @include('sweetalert::alert')
 
  <!-- Scripts -->
    @stack('scripts_start')
    @include('layouts.script')
    @stack('scripts_end')
	
  <!-- Modal -->
	@include('layouts.modal')
    @stack('modals')
	<!-- Sidebar Menu - Dark Light Mode -->
	<script>
	  var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
	  var currentTheme = localStorage.getItem('theme');
	  var mainHeader = document.querySelector('.main-header');
	  var mainSidebar = document.querySelector('.main-sidebar');

	  if (currentTheme) {
		if (currentTheme === 'dark') {
		  if (!document.body.classList.contains('dark-mode')) {
			document.body.classList.add("dark-mode");
		  }
		  if (mainHeader.classList.contains('navbar-light')) {
			mainHeader.classList.add('navbar-dark');
			mainHeader.classList.remove('navbar-light');
		  }
		  if (mainSidebar.classList.contains('sidebar-light')) {
			mainSidebar.classList.add('sidebar-dark');
			mainSidebar.classList.remove('sidebar-light');
		  }
		  toggleSwitch.checked = true;
		}
	  }

	  function switchTheme(e) {
		if (e.target.checked) {
		  if (!document.body.classList.contains('dark-mode')) {
			document.body.classList.add("dark-mode");
		  }
		  if (mainHeader.classList.contains('navbar-light')) {
			mainHeader.classList.add('navbar-dark');
			mainHeader.classList.remove('navbar-light');
		  }
		  if (mainSidebar.classList.contains('sidebar-light')) {
			mainSidebar.classList.add('sidebar-dark');
			mainSidebar.classList.remove('sidebar-light');
		  }
		  localStorage.setItem('theme', 'dark');
		} else {
		  if (document.body.classList.contains('dark-mode')) {
			document.body.classList.remove("dark-mode");
		  }
		  if (mainHeader.classList.contains('navbar-dark')) {
			mainHeader.classList.add('navbar-light');
			mainHeader.classList.remove('navbar-dark');
		  }
		  if (mainSidebar.classList.contains('sidebar-dark')) {
			mainSidebar.classList.add('sidebar-light');
			mainSidebar.classList.remove('sidebar-dark');
		  }
		  localStorage.setItem('theme', 'light');
		}
	  }

	  toggleSwitch.addEventListener('change', switchTheme, false);
	</script>
</body>

</html>