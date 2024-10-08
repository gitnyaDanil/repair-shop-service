<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->person->name ?? "" }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Master Data</li>
            <x-nav-item :icon="'fas fa-users'" :text="'Customer'" :href="route('customer.index')"/>

            <x-nav-item :icon="'fas fa-tools'" :text="'Service'" :href="route('service.index')"/>

            <x-nav-item :icon="'fas fa-users'" :text="'Customer Interaction'" :href="route('customer_interaction.index')"/>

            <x-nav-item :icon="'fas fa-file-invoice'" :text="'Repair Order'" :href="route('repair_order.index')"/>

            <x-nav-item :icon="'fas fa-file-invoice-dollar'" :text="'Invoice'" :href="route('invoice.index')"/>

            <x-nav-item :icon="'fas fa-credit-card'" :text="'Payment'" :href="route('payment.index')"/>

            {{-- <i class="fa-solid fa-screwdriver-wrench"></i> --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
