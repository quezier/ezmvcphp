<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php require  $adminPublicLinkView;?>
    <title>编辑<?php echo $tableCName;?>_<?php echo SITE_NAME;?></title>
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
                    <div class="breadcrumbs-wrapper">
                        <div class="container">
                            <div class="row no-margin">
                                <div class="col s12">
                                    <h5 class="breadcrumbs-title">编辑<?php echo $tableCName;?>-<?php echo SITE_NAME;?></h5>
                                    <ol class="breadcrumb">
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/adminmain">主页</a>
                                        </li>
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/<?php echo $_GET['last_url'];?>"><?php echo $tableCName;?>列表</a>
                                        </li>
                                        <li class="active">编辑<?php echo $tableCName;?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-heading">
                            <h4>编辑<?php echo $tableCName;?></h4>
                            <ul class="actions">
                                <li>
                                    <a class="waves-effect waves-block waves-light collapse-btn card-a" href="javascript:void(0);">
                                        <i class="mdi-hardware-keyboard-arrow-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form id="validate_form">
                            <input type="hidden" name="id" value="<?php echo $tableObject['id'];?>"/>
                            <div class="card-content">
                                <div class="row hh-add-edit">
                                    <?php foreach ($editFields as $afKey => $afVal){?>
                                        <dl class="col s12 <?php if($afVal['is_one_row']!=1){echo 'm6';}?>">
                                            <dt><b><?php echo $afVal['cn_name'];?></b></dt>
                                            <dd>
                                                <div class="col s10">
                                                    <?php if($afVal['type']=='text'){?>
                                                    <input id="<?php echo $afKey;?>" name="<?php echo $afKey;?>"
                                                           class="<?php if(empty($afVal['no_use'])){ echo ' validate[required] '; }?>"
                                                           <?php if(!empty($afVal['value'])){echo ' value="'.$afVal['value'].'"';}else{echo ' value="'.$tableObject[$afKey].'"';}?>
                                                        <?php if(!empty($afVal['no_use'])){ echo ' readonly="readonly" '; }?>
                                                           type="text" placeholder="<?php echo $afVal['cn_name'];?>">
                                                    <?php }else if($afVal['type']=='select'){?>
                                                        <div class="hh-select  select-wrapper">
                                                            <select id="<?php echo $afKey;?>" name="<?php echo $afKey;?>" class="myselect validate[required] select2-selection--single select2-search--dropdown" >
                                                                <option value="" >请选择</option>
                                                                <?php foreach ($afVal['list'] as $lkey => $lval){?>
                                                                    <option
                                                                        <?php if($lkey == $tableObject[$afKey]){echo "selected='selected'";}?>
                                                                        value="<?php echo $lkey;?>"><?php echo $lval;?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    <?php }else if($afVal['type']=='checkbox'){?>
                                                        <div class="hh-checkbox clearfix">
                                                            <?php foreach ($afVal['list'] as $chkKey => $chkVal){?>
                                                                <input class="filled-in validate[required]"
                                                                       <?php if($chkKey == $tableObject[$afKey]){echo " checked='checked' ";}?>
                                                                       value="<?php echo $chkKey;?>" id="<?php echo $afKey;?>_<?php echo $chkKey;?>" type="checkbox" name="<?php echo $afKey;?>">
                                                                <label for="<?php echo $afKey;?>_<?php echo $chkKey;?>"><?php echo $chkVal;?></label>
                                                            <?php }?>
                                                        </div>
                                                    <?php }else if($afVal['type']=='radio'){?>
                                                        <div class="hh-checkbox clearfix validate[required]">
                                                            <?php foreach ($afVal['list'] as $radioKey => $radioVal){?>
                                                                <input class="with-gap"
                                                                    <?php if($radioKey == $tableObject[$afKey]){echo " checked='checked' ";}?>
                                                                       value="<?php echo $radioKey;?>" id="<?php echo $afKey;?>_<?php echo $radioKey;?>" type="radio" name="<?php echo $afKey;?>">
                                                                <label  for="<?php echo $afKey;?>_<?php echo $radioKey;?>"><?php echo $radioVal;?></label>
                                                            <?php }?>
                                                        </div>
                                                    <?php }else if($afVal['type']=='date'){?>
                                                    <input placeholder="<?php echo $afVal['cn_name'];?>"
                                                           value="<?php echo $tableObject[$afKey];?>"
                                                           name="<?php echo $afKey;?>" id="<?php echo $afKey;?>" type="text" class="validate[required] datepicker">

                                                    <?php }else if($afVal['type']=='editor'){?>

                                                        <!--style给定宽度可以影响编辑器的最终宽度-->
                                                        <DIV id="myEditor" style="width:100%;height:240px;"></DIV>
                                                        <script type="text/javascript">
                                                            var um = UE.getEditor('myEditor', {
                                                                textarea: '<?php echo $afKey;?>',
                                                            });
                                                            um.ready(function() {
                                                                //设置编辑器的内容
                                                                um.setContent('<?php echo html_entity_decode($tableObject[$afKey]);?>');
                                                            });
                                                        </script>
                                                    <?php }?>

                                                </div>
                                            </dd>
                                        </dl>
                                    <?php }?>
                                    <dl class="col s12">
                                        <dd class="text-left">
                                            <a class="waves-effect waves-light btn pink lighten-2" id="validation_btn" href="javascript:void(0);">
                                                <i class="fa fa-spinner fa-spin" style="display: none;"></i>提交</a>
                                            <a class="waves-effect waves-light btn blue-grey lighten-2" href="<?php echo HTTP_DOMAIN; ?>/<?php echo $_GET['last_url'];?>">取消</a>
                                        </dd>
                                    </dl>
                                    <?php if(!empty($html_desc)){?>
                                        <dl class="col s12">
                                            <dd class="text-left">
                                                <?php echo $html_desc;?>
                                            </dd>
                                        </dl>
                                    <?php }?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
<?php require  $adminPublicFooterView;?>
<script type="text/javascript">
    $(function () {
        $('#validate_form').validationEngine();
        $('#validation_btn').on('click',mysubmit);
        if($('.myselect').length && $('.myselect').length>0){
            $('.myselect').select2();
        }
        function mysubmit()
        {

            if ($('#validate_form').validationEngine('validate')) {
                var param=$('#validate_form').serializeObject();
                $('#validation_btn').children('i').css('display','block');
                $('#validation_btn').unbind('click');
                $.ajax({
                    url:"<?php echo $actionUrl;?>",
                    type:'post',
                    dataType:'json',
                    data:param,
                    success:function(data)
                    {
                        $('#modal2').closeModal();
                        if(data.status==1)
                        {
                            swal({
                                title: "提示",
                                text: data.msg,
                                type: "info",
                                showCancelButton: false
                            }, function() {
                                location.href="<?php echo HTTP_DOMAIN; ?>/<?php echo $_GET['last_url'];?>";
                            });
                        }
                        else
                        {
                            swal(data.msg);
                        }
                        $('#validation_btn').children('i').css('display','none');
                        $('#validation_btn').on('click',mysubmit);
                    }
                });
            } else {
                swal("错误!", "表单验证不通过!", "error");
            }

        }
        $('#province_id').change(function(){
            var province_id = $(this).val();
            var html = "";
            if(province_id)
            {
                $('#city_id').empty();
                $('#city_id').append("<option value='' selected=selected>请选择</option>");
                $('#select2-city_id-container').html('请选择');
                $.ajax({
                    url:"<?php echo HTTP_DOMAIN;?>/admin_togetcity/province_id/"+province_id,
                    type:'GET',
                    dataType:'json',
                    success:function(data)
                    {
                        if(data.status==1)
                        {

                            $.each(data.result,function (index,value) {
                                html+="<option value='"+value.city_id+"'>"+value.city_name+"</option>";
                            });
                            $('#city_id').append(html);
                        }
                        else{
                            swal(data.msg);
                        }
                    }

                });
            }
        });

        $('#city_id').change(function(){
            var city_id = $(this).val();
            var html = "";
            if(city_id)
            {
                $('#country_id').empty();
                $('#country_id').append("<option value='' selected=selected>请选择</option>");
                $('#select2-country_id-container').html('请选择');
                $.ajax({
                    url:"<?php echo HTTP_DOMAIN;?>/admin_togetcountry/city_id/"+city_id,
                    type:'GET',
                    dataType:'json',
                    success:function(data)
                    {
                        if(data.status==1)
                        {

                            $.each(data.result,function (index,value) {
                                html+="<option value='"+value.country_id+"'>"+value.country_name+"</option>";
                            });
                            $('#country_id').append(html);
                        }
                        else{
                            swal(data.msg);
                        }
                    }

                });
            }
        });

    });
</script>
</body>

</html>
