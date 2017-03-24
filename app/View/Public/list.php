<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php require  $adminPublicLinkView;?>
    <title><?php echo $tableCName;?>列表_<?php echo SITE_NAME;?></title>
</head>

<body class=" ">
<!-- Docs master nav -->
<?php require  $adminPublicHeaderView;?>
<!-- Page content of course! -->
<div id="main">
    <div class="wrapper">
        <?php require  $adminPublicMenuView;?>
        <section id="content" class="hh-min-width">
            <div class="breadcrumbs-wrapper">
                <div class="container">
                    <div class="row no-margin">
                        <div class="col s12">
                            <h5 class="breadcrumbs-title"><?php echo $tableCName;?>列表-<?php echo SITE_NAME;?></h5>
                            <ol class="breadcrumb">
                                <li><a href="http://<?php echo HTTP_HOST; ?>/adminmain">主页</a>
                                </li>
                                <li class="active"><?php echo $tableCName;?>列表</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
            <?php if(!empty($searchInputs)){?>
                <form class="card search-form hh-search-form toggled" id="search_form">
                    <div class="card-heading">
                        <h4>查询条件</h4>
                        <ul class="actions">

                            <li>
                                <a class="waves-effect waves-block waves-light collapse-btn card-a" href="#">
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <?php $index=0; foreach ($searchInputs as $siKey => $siVal){ ++$index;?>
                            <div class="input-field col <?php if ($siVal['type']!='checkbox'&&$siVal['type']!='radio'){echo 's6 m4';}else{echo 's12 hh-h3rem';}?>">
                                <?php if($siVal['type']=='text'){?>
                                    <input id="input_<?php echo $siKey;?>" type="text" name="<?php echo $siKey;?>" placeholder="<?php echo $siVal['name'];?>" class="search_input">
                                <?php }else if($siVal['type']=='select'){?>
                                    <div class="hh-select  select-wrapper">
                                    <select id="input_<?php echo $siKey;?>" name="<?php echo $siKey;?>" class="myselect select2-selection--single select2-search--dropdown" >
                                        <option value="" >请选择</option>
                                        <?php foreach ($siVal['list'] as $lkey => $lval){?>
                                            <option value="<?php echo $lkey;?>"><?php echo $lval;?></option>
                                        <?php }?>
                                    </select>
                                    </div>
                                <?php }else if($siVal['type']=='checkbox'){?>
                                    <div class="hh-checkbox clearfix">
                                        <?php foreach ($siVal['list'] as $chkKey => $chkVal){?>
                                            <input class="filled-in"
                                                   value="<?php echo $chkKey;?>" id="<?php echo $siKey;?>_<?php echo $chkKey;?>" type="checkbox" name="<?php echo $siKey;?>">
                                            <label for="<?php echo $siKey;?>_<?php echo $chkKey;?>"><?php echo $chkVal;?></label>
                                        <?php }?>
                                    </div>
                                <?php }else if($siVal['type']=='radio'){?>
                                    <div class="hh-checkbox clearfix">
                                    <?php foreach ($siVal['list'] as $radioKey => $radioVal){?>
                                        <input class="with-gap"
                                           value="<?php echo $radioKey;?>" id="<?php echo $siKey;?>_<?php echo $radioKey;?>" type="radio" name="<?php echo $siKey;?>">
                                        <label  for="<?php echo $siKey;?>_<?php echo $radioKey;?>"><?php echo $radioVal;?></label>
                                    <?php }?>
                                    </div>
                                <?php }else if($siVal['type']=='date'){?>
                                    <input placeholder="<?php echo $siVal['name'];?>" name="<?php echo $siKey;?>" id="input_<?php echo $siKey;?>" type="text" class="datepicker">

                                <?php }?>
                                <label for="<?php echo $index;?>"><?php echo $siVal['name'];?></label>
                            </div>
                            <?php }?>
                        </div>
                        <div class="card-action">
                            <a class="waves-effect waves-light btn pink lighten-2" href="javascript:void(0)" onclick="doSearch()">查询</a>
                            <a class="waves-effect waves-light btn blue-grey lighten-2" href="javascript:void(0);" id="btn_reset">重置</a>
                        </div>
                    </div>
                </form>
                <?php }?>
                <!-- 查询条件 结束 -->
                <!-- 订单列表 开始 -->
                <div class="card table-form ">

                    <div class="card-heading">
                        <?php foreach ((array)$tableTitleButtons as $ttbKey => $ttbVal){?>
                        <a class="waves-effect waves-light btn cyan" href="<?php echo $ttbVal?>">
                            <?php echo $ttbKey?><!--<small class="count teal">999</small>-->
                        </a>
                        <?php }?>
                        <!--<a class="waves-effect waves-light btn cyan" href="javascript:void(0);">
                        编辑管理员--><!--<small class="count teal">999</small>-->
                        <!--</a>-->
                    </div>
                    <div class="card-heading">
                        <h4><?php echo $tableCName;?>列表</h4>
                        <ul class="actions">

                            <li>
                                <a class="waves-effect waves-block waves-light collapse-btn card-a" href="javascript:void(0);">
                                    <i class="mdi-hardware-keyboard-arrow-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <table class="highlight hh-table-bordered ">
                            <thead>
                            <tr>
                                <?php foreach ($titleNames as $key => $val){?>
                                <th><?php echo $val;?></th>
                                <?php }?>
                                <?php if(!empty($dropDownMenus)){?><th class="width-130">管理操作</th><?php }?>
                            </tr>
                            </thead>
                            <tbody name="list"> </tbody>
                            <script id="list" type="text/html">
                                {{each result.list as v i}}
                                <tr>
                                    <?php foreach ($displayFields as $dfKey => $dfVal){?>
                                    <td class="text-left width-230">
                                        <?php if(substr($dfVal,-6)=='is_del'){?>
                                            {{if v.<?php echo $dfVal;?>==1}}可用{{/if}}
                                            {{if v.<?php echo $dfVal;?>==2}}禁用{{/if}}
                                        <?php }else if(substr($dfVal,-3)=='sex'){?>
                                            {{if v.<?php echo $dfVal;?>==1}}男{{/if}}
                                            {{if v.<?php echo $dfVal;?>==2}}女{{/if}}
                                        <?php }else{?>
                                            {{if v.<?php echo $dfVal;?>!=0}}
                                            {{v.<?php echo $dfVal;?><?php if(substr($dfVal,-4)=='date'){echo " | date:'Y-m-d H:i:s'";}?>}}
                                            {{/if}}
                                            {{if v.<?php echo $dfVal;?>==0}}
                                            {{v.<?php echo $dfVal;?>}}
                                            {{/if}}
                                        <?php }?>
                                    </td>
                                    <?php }?>
                                    <?php if(!empty($dropDownMenus)){?>
                                    <td>
                                        <button class="dropdown-button waves-effect waves-light btn btn-small cyan darken-1" data-beloworigin="true" data-activates="hh-dropdown-{{i+1}}">管理操作<i class="mdi-navigation-arrow-drop-down right"></i></button>
                                        <ul id='hh-dropdown-{{i+1}}' class='dropdown-content'>
                                            <?php foreach ($dropDownMenus as $ddmKey => $ddmVal){?>
                                            <li>
                                                <a href="<?php echo $ddmVal;?>" ><?php echo $ddmKey;?></a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </td>
                                    <?php }?>
                                </tr>
                                {{/each}}
                            </script>
                        </table>
                        <div class="search-empty-wrap"  style="display: none;">
                            <p><i class="fa fa-frown-o"></i><span>搜索结果为空</span></p>
                        </div>
                        <!-- 翻页 开始 -->
                        <div class="pag-wrap  right-align ">
                        </div>
                        <!-- 翻页 结束 -->
                    </div>
                </div>
                <!-- 弹窗-线路详情 开始 -->

                <!-- 订单列表 结束 -->
            </div>
        </section>
    </div>
</div>
<?php require  $adminPublicFooterView;?>
<script type="text/javascript">
    var ACTION = "<?php echo $actionUrl;?>"; //列表接口地址
    var PAGESIZE = <?php echo $defaultPageSize;?>; //每页显示数量
    $(function () {
        if ($('.myselect').length && $('.myselect').length > 0) {
            $('.myselect').select2();
        }
    });
</script>
<script src="http://<?php echo HTTP_HOST; ?>/js/admin/common/pageList.js"></script>
<script src="http://<?php echo HTTP_HOST; ?>/js/admin/common/reset_enterkeyevent_onlist.js"></script>

</body>

</html>
