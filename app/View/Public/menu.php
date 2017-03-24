<aside id="left-sidebar-nav">
    <div id="slide-out" class="z-depth-1 leftside-navigation">
        <!-- <div class="clearfix toggle-wrapper">
            <button id="toggleNav" class="btn-floating waves-effect waves-light pink accent-2 right"><i class="material-icons">lock_open</i></button>
        </div> -->
        <?php if(!empty($rank_privileges)&&count($rank_privileges)>0){?>
        <ul id="main-menu">
               <?php foreach ($rank_privileges as $rpkey => $rpVal){?>

                    <li class="first_menu has-sub">
                        <a href="javascript:void(0)" class="first_menu_btn">
                            <div class="gui-icon">
                                <i class="<?php echo $rpVal['privilege_css'];?>"></i>
                            </div>
                            <span class="nav-text"><?php echo $rpVal['privilege_name'];?>
                            </span>
                        </a>
                        <?php if(!empty($rpVal['sub_pri'])){?>
                        <ul class="sub-menu">
                            <?php foreach ($rpVal['sub_pri'] as $subkey => $subVal){?>
                                <li>
                                    <a href="<?php echo HTTP_DOMAIN;?>/<?php echo $subVal['privilege_url'];?>">
                                        <span class="nav-text"><?php echo $subVal['privilege_name'];?></span>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                        <?php }?>
                    </li>

                <?php }?>
        </ul>
        <?php }?>
    </div>
</aside>
