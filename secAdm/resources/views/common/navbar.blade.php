@guest('admin')


@else
<?php $notidata = getNotificationAdmin(); ?>
<div class="top_nav">
    <div class="nav_menu">
        <nav class="">
            <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
            <ul class="nav navbar-nav navbar-expand-sm navbar-right">
                @if(Auth::guard('admin')->user()->admin_role == 1)
                <?php if (count($notidata['notidata'])>0) { ?>
                    <li role="presentation"  class="dropdown nav-item"> 
                        <a href="javascript:;" id="notiCount" class="dropdown-toggle info-number nav-link" data-toggle="dropdown"
                           aria-expanded="false"><i class="fa fa-bell"></i><span class="badge bg-green">{{$notidata['noticount']}}</span> </a>
                        <ul id="menu1" class="dropdown-menu list-unstyled msg_list"role="menu">
                            @foreach($notidata['notidata'] as $key=>$value)

                            <li class="dropdown-item"> <a href="{{ route('order.manage') }}"><i class="fa fa-bell"></i> <span> <span>Rolling Components</span> <span class="time">{{get_time_difference_php($value->req_date)}}</span> </span> <span class="message">{{reduceWords(getUserName($value->cust_nm).' has new order')}} </span> </a> </li>
                            @endforeach
                            <li class="dropdown-item">
                                <div class="text-center"> <a href="{{ route('order.manage') }}"> <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i> </a> </div>
                            </li>
                        </ul>
                    </li>
<?php } else { ?>
                    <li role="presentation"  class="dropdown nav-item"> 
                        <a href="javascript:;" id="notiCount" class="dropdown-toggle info-number nav-link" data-toggle="dropdown"
                           aria-expanded="false"><i class="fa fa-bell"></i> </a>
                        <ul id="menu1" class="dropdown-menu list-unstyled msg_list"role="menu">
                            <li class="dropdown-item">
                                <div class="text-center"> <a> <strong>No Notifications</strong> <i class="fa fa-angle-right"></i> </a> </div>
                            </li>
                        </ul>
                    </li>
<?php } ?>
                    @endif
                <li class="nav-item pl-3 pr-3"> <a href="javascript:;" class="user-profile dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-user"></i> {{Auth::guard('admin')->user()->user_name}}<span class=" fa fa-angle-down"></span> </a>
                    <ul class="dropdown-menu dropdown-usermenu float-right">
                        <li class="dropdown-item"><a href="{{ route('admin.changePwd') }}"> Profile</a></li>
<!--                        <li class="dropdown-item"><a href="javascript:;">Help</a> </li>-->
                        <li class="dropdown-item"><a href="{{ route('admin.auth.logout') }}"
                                                     onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();"><i class="fa fa-sign-out float-right"></i> Log Out</a> </li>
                    </ul>
                </li>
<!--                <li> <a href="#"><img src="{{ URL::asset('images/setting.svg') }}" alt="setting"></a> </li>-->
            </ul>
        </nav>
    </div>
</div>
<form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@endguest