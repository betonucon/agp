    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        <li class="treeview @if(Request::is('barang/*')==1 || Request::is('barang')==1 || Request::is('supplier')==1 || Request::is('employe')==1) menu-open @endif">
          <a href="#">
            <i class="fa fa-dashboard text-white"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display:@if(Request::is('barang/*')==1 || Request::is('barang')==1 || Request::is('supplier')==1 || Request::is('employe')==1) block @endif">
            <li><a href="{{url('barang')}}">&nbsp;<i class="fa fa-minus"></i> Barang</a></li>
          </ul>
        </li>
        
        <li><a href="#"><i class="fa fa-circle-o text-white"></i> <span>Information</span></a></li>
      </ul>