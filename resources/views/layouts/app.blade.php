<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> @yield('title') </title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

                    <!-- vendor css -->
        <link href="{{ asset('lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
        
            <!-- Bracket CSS -->
        <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">

        <!-- data tables -->
        <link href="{{ asset('lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">

        <!-- wysiwyg -->
        <link href="{{ asset('lib/summernote/summernote-bs4.css') }}" rel="stylesheet">
        <!-- end wysiwyg -->

        <!-- Scripts -->
        <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased collapsed-menu">
          <div class="alert alert-info hidethis" id='loadinginformation' role="alert" style='z-index: 1000000000000000;'>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-flex align-items-center justify-content-start">
                  <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                  <span id='loadinginfo_span'></span>
              </div>
          </div>

          <div class="alert alert-success hidethis" id='successfulinformation' role="alert" style='z-index: 1000000000000000;'>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-flex align-items-center justify-content-start">
                  <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                  <span id='successinfo_span'></span>
              </div>
          </div>

        <div class="min-h-screen bg-gray-100">
          
            @include('layouts.leftnav')
            @include('layouts.navigation')
            @include('layouts.rightnav')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    <script src="{{asset('lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('lib/moment/moment.js')}}"></script>
    <script src="{{asset('lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
    <script src="{{asset('lib/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('lib/d3/d3.js')}}"></script>
     <!-- <script src="{{asset('lib/chartist/chartist.js')}}"></script> -->
    <!-- <script src="{{asset('lib/rickshaw/rickshaw.min.js')}}"></script> -->

    <!-- data tables -->
    <script src="{{asset('lib/datatables/jquery.dataTables.js')}}"></script>
    <!-- end of data tables -->

    <!-- wysiwyg -->
    <script src="{{asset('lib/summernote/summernote-bs4.min.js')}}"></script>
    <!-- end wysiwyg -->

    <!-- wysiwyg -->
    <script src="{{asset('lib/summernote/summernote-bs4.min.js')}}"></script>
    <!-- end wysiwyg -->

    <!-- wysiwyg -->
    <script src="{{asset('js/select2.min.js')}}"></script>
    <!-- end wysiwyg -->
    
    <script src="{{asset('js/bracket.js')}}"></script>
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
    <script> 
        var url = "{{url('')}}";
    </script>
    <script src="{{asset('jsdsi/dsifrontprocs.js')}}"></script>
    <script src="{{asset('jsdsi/process.js')}}"></script>

    <?php
        $path_info = $_SERVER["PATH_INFO"];
        $firstpath = explode("/",$path_info)[1];
        
        if ($firstpath == "quotes") {
    ?>
      <script src="{{asset('jsdsi/quotation.js')}}"></script>
<?php } ?>

<?php if ($firstpath == "orders" || $firstpath == "processed") { ?>
  <script src="{{asset('jsdsi/orders.js')}}"></script>
<?php } ?>

    <script>
      $(function(){
        'use strict'

        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });

      $('#datatable1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
     });

     $(document).find("#datatable1_length select").addClass("form-control")
    </script>

    </body>
</html>
