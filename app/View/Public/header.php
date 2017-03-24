<div id="loader-wrapper">
  <div id="loader"></div>
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
</div>
<header id="header" class="page-topbar">
  <div class="navbar-fixed">
    <nav class="cyan">
      <div class="nav-wrapper">
        <ul class="left">
          <li class="no-hover" id="toggleNav"> <a href="javascript:void();" data-activates="slide-out" class="menu-sidebar-collapse btn-floating btn-flat btn-medium waves-effect waves-light cyan tooltipped" data-beloworigin="true" href="#!" data-activates="dropdown-switch" data-position="bottom" data-delay="0" data-tooltip="导航切换"><i class="mdi-navigation-menu"></i> </a> </li>
          <li>
            <h1 class="logo-wrapper"> <a href="http://<?php echo HTTP_HOST;?>/adminmain" class="brand-logo darken-1"> <span class="logo-text"><?php echo SITE_NAME;?>后台管理</span> </a> </h1>
          </li>
        </ul>
        <ul class="right">
          <li> <a class="dropdown-button waves-effect waves-block waves-light card-a" data-hover='true' data-beloworigin="true" href="#!" data-activates="dropdown1"> <i class="mdi-social-person"><span><?php $adminInfo = \Core\PubFunc::adminInfo();if(!empty($adminInfo['admin_name'])){echo $adminInfo['admin_name'];}else{echo '无';}?></span></i></a>
            <ul id='dropdown1' class='dropdown-content'>
              <li><a href="javascript:void(0)" id="modifyPwd">修改密码</a></li>
            </ul>
          </li>
          <li><a id="logout" href="http://<?php echo HTTP_HOST;?>/adminlogout" data-tooltip="退出" class="waves-effect waves-block waves-light tooltipped" > <i class="mdi-action-settings-power"></i> </a> </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
