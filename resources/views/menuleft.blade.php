<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <div class="user-details">
            <div class="text-center">
                <img src="/assets/images/users/logo.jpeg" alt="" class="img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    	{{ auth()->user()->getFullName() }} 
                    </a>
                    	@include('menulink')
<!--                     <ul class="dropdown-menu"> -->
<!--                         <li><a href="javascript:void(0)"> Profile</a></li> -->
<!--                         <li><a href="javascript:void(0)"> Settings</a></li> -->
<!--                         <li><a href="javascript:void(0)"> Lock screen</a></li> -->
<!--                         <li class="divider"></li> -->
<!--                         <li><a href="javascript:void(0)"> Logout</a></li> -->
<!--                     </ul> -->
                </div>

                <p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>
            </div>
        </div>
        <!--- Divider -->


        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('panel') }}" class="waves-effect"><i class="mdi mdi-home"></i><span>Inicio</span></a>
                </li>
				@if(auth()->user()->isSuperAdmin() )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account"></i> <span> General </span> <span class="pull-right"><i class="mdi mdi-plus"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="">Clientes</a></li>
                    </ul>
                </li>
				@endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>