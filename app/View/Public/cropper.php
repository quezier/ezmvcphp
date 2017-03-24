<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php require  $adminPublicLinkView;?>
    <title>上传文件_<?php echo $tableCName;?>_<?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo HTTP_DOMAIN; ?>/css/cropper.min.css">
    <link rel="stylesheet" href="<?php echo HTTP_DOMAIN; ?>/css/usecropper.css">
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
                                    <h5 class="breadcrumbs-title">上传头像_<?php echo $tableCName;?>-<?php echo SITE_NAME; ?></h5>
                                    <ol class="breadcrumb">
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/adminmain">主页</a>
                                        </li>
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/<?php echo $_GET['last_url'];?>"><?php echo $tableCName;?>列表</a>
                                        </li>
                                        <li class="active">上传头像_<?php echo $tableCName;?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-heading">
                            <h4></h4>上传头像_<?php echo $tableCName;?></h4>
                            <ul class="actions">
                                <li>
                                    <a class="waves-effect waves-block waves-light collapse-btn card-a"
                                       href="javascript:void(0);">
                                        <i class="mdi-hardware-keyboard-arrow-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                            <div class="card-content">
                                <div class="row hh-add-edit">
                                    <dl class="col s12">
                                    <dt><b>预览</b></dt>
                                    <dd class="col s10">
                                        <img src="<?php if(!empty($img)){echo $img;}?>" class="imgpreview" style="width: 120px;height: 120px;"/>
                                    </dd>
                                    </dl>
                                </div>
                                <div class="row hh-add-edit">

                                    <dl class="col s12">
                                        <dt><b>上传</b></dt>
                                        <dd>
                                            <div class="col s10">
                                                <div class="container" id="crop-avatar">

                                                    <!-- Cropping modal -->
                                                    <div class="" id="avatar-modal" aria-labelledby="avatar-modal-label">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <form class="avatar-form" action="<?php echo HTTP_DOMAIN;?>/admin_docropper" enctype="multipart/form-data" method="post">
                                                                    <input type="hidden" value="<?php echo $id;?>" name="id">
                                                                    <!--<div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                                                    </div>-->
                                                                    <div class="modal-body">
                                                                        <div class="avatar-body">

                                                                            <!-- Upload image and data -->
                                                                            <div class="avatar-upload">
                                                                                <input type="hidden" class="avatar-src" name="avatar_src">
                                                                                <input type="hidden" class="avatar-data" name="avatar_data">
                                                                                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                                                            </div>

                                                                            <!-- Crop and preview -->
                                                                            <div class="row">
                                                                                <div class="col s6">
                                                                                    <div class="avatar-wrapper"></div>
                                                                                </div>
                                                                                <div class="col s2">
                                                                                    <!--<div class="avatar-preview preview-lg"></div>-->
                                                                                    <div class="avatar-preview preview-md"></div>
                                                                                    <!--<div class="avatar-preview preview-sm"></div>-->
                                                                                </div>
                                                                            </div>

                                                                            <div class="row avatar-btns">
                                                                                <!--<div class="col-md-9">
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                                                                                    </div>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                                                                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                                                                                    </div>
                                                                                </div>-->
                                                                                <div class="col-md-3">
                                                                                    <button type="submit" class="btn btn-primary btn-block avatar-save">提交</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="modal-footer">
                                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div> -->
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal -->

                                                    <!-- Loading state -->
                                                    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                    
                                </div>
                            </div>

                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
<?php require  $adminPublicFooterView;?>
<script src="<?php echo HTTP_DOMAIN; ?>/js/cropper.min.js"></script>
<script src="<?php echo HTTP_DOMAIN; ?>/js/usecropper.js"></script>

<script type="text/javascript">
    $(function () {

    });
</script>
</body>

</html>
