<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanalsettings*')||request()->is('admin/treasuries*'))?'menu-open':'' }}">
                <a href="#" class="nav-link {{ (request()->is('admin/adminpanalsettings*')||request()->is('admin/treasuries*'))?'active':'' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   الضبط العام
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.panalsettings.index') }}" class="nav-link {{ (request()->is('admin/adminpanalsettings*'))?'active':'' }} ">
                      <i class="far fa-circle nav-icon"></i>
                      <p>الضبط العام</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.treasuries.index') }}" class="nav-link {{ (request()->is('admin/treasuries*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>الخزن</p>
                    </a>
                  </li>
                </ul>
              </li>




              <li class="nav-item has-treeview {{ (request()->is('admin/accountTypes*')||request()->is('admin/accounts*')||request()->is('admin/customers*'))?'menu-open':'' }}">
                <a href="#" class="nav-link {{ (request()->is('admin/accountTypes*')||request()->is('admin/accounts*')||request()->is('admin/customers*'))?'active':'' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   الحسابات
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             
                  <li class="nav-item">
                    <a href="{{ route('admin.accountTypes.index') }}" class="nav-link {{ (request()->is('admin/accountTypes*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>انواع الحسابات</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="{{ route('admin.accounts.index') }}" class="nav-link {{ (request()->is('admin/accounts*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p> كل الحسابات المالية </p>
                    </a>
                  </li>



                  <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ (request()->is('admin/customers*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p> حسابات العملاء</p>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="nav-item has-treeview {{ (request()->is('admin/sales_matrial_types*')||request()->is('admin/stores*')||request()->is('admin/uoms*')||request()->is('admin/inv_itemcard_categories*')   ) ?'menu-open':'' }}">
                <a href="#" class="nav-link {{ (request()->is('admin/sales_matrial_types*')||request()->is('admin/stores*')||request()->is('admin/uoms*')||request()->is('admin/inv_itemcard_categories*')   ) ?'active':'' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                  ضبط المخازن
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.sales_matrial_types.index') }}" class="nav-link {{ (request()->is('admin/sales_matrial_types*'))?'active':'' }} ">
                      <i class="far fa-circle nav-icon"></i>
                      <p>بيانات فئات الفواتير</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.stores.index') }}" class="nav-link {{ (request()->is('admin/stores*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p> المخازن</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('admin.uoms.index') }}" class="nav-link {{ (request()->is('admin/uoms*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p> الوحدات</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="{{ route('inv_itemcard_categories.index') }}" class="nav-link {{ (request()->is('admin/inv_itemcard_categories*'))?'active':'' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p> فئات الاصناف</p>
                    </a>
                  </li>


                </ul>
              </li>


              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   حركات مخزنية
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>


              
              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                  حركات مخزنية
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>


              
              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   المبيعات
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>




              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   خدمات داخلية وخارجية
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>




              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   حركة شفت الخزينة
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>


              
              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link>
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   الصلاحيات والمستخدمين
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>


              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   التقارير
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>



              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link >
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                   الملراقبة والدعم الفني
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
             



                </ul>
              </li>





          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.panalsettings.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الضبط العام</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.treasuries.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الخزن</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.sales_matrial_types.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>فئات الفواتير</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.stores.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>المخازن</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.uoms.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الوحدات</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('inv_itemcard_categories.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>فئات الاصناف</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.itemcard.index') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>الفئات</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>