    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo" style='background:#3e454c;'><a href=""></a></div>
    <div class="br-sideleft overflow-y-auto" style='background: #2c3136;'>

        <div style='text-align:center;' class='disapprof'>
            <div class='profileimg'> <img src="{{ asset('images/DSC_5694.jpg') }}"/> </div>
            <p class='profilename'> <?php echo Auth::user()['name']; ?> </p>
            <small class='usertype'> Admin </small>
        </div>
      <?php
        $path_info = $_SERVER["REQUEST_URI"];
        $firstpath = explode("/",$path_info)[1];
      ?>
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">
        <a href="{{route('dashboard')}}" class="br-menu-link <?php echo ($firstpath=="dashboard")?"active":null; ?>"> <!-- active -->
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="{{ route('phonebook') }}" class="br-menu-link <?php echo ($firstpath=="phonebook")?"active":null; ?>">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label">Contacts</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="{{ route('uploaditems') }}" class="br-menu-link <?php echo ($firstpath=="uploaditems")?"active":null; ?>">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
            <span class="menu-item-label">Items</span>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="#" class="br-menu-link <?php echo ($firstpath=="customer")?"active":null; ?>">
          <div class="br-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Customer</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column" <?php echo ($firstpath=="customer")?"style='display:block;'":null; ?>>
          <li class="nav-item"><a href="{{route('customer')}}" class="nav-link">Customer's List</a></li>
        </ul>
        <a href="#" class="br-menu-link <?php echo ($firstpath=="quotes")?"active":null; ?>">
          <div class="br-menu-item">
            <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
            <span class="menu-item-label">Quotation</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- br-menu-link quotes -->
        <ul class="br-menu-sub nav flex-column" <?php echo ($firstpath=="quotes")?"style='display:block;'":null; ?>>
          <li class="nav-item"><a href="{{route('quotes')}}" class="nav-link">All Quotations</a></li>
        </ul>



      </div><!-- br-sideleft-menu -->


      <br>
    </div><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->