<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <?php require  $adminPublicLinkView;?>
    <title>上传文件_<?php echo $tableCName;?>_<?php echo SITE_NAME; ?></title>
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
                                    <h5 class="breadcrumbs-title">上传文件_<?php echo $tableCName;?>-<?php echo SITE_NAME; ?></h5>
                                    <ol class="breadcrumb">
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/adminmain">主页</a>
                                        </li>
                                        <li><a href="<?php echo HTTP_DOMAIN; ?>/<?php echo $_GET['last_url'];?>"><?php echo $tableCName;?>列表</a>
                                        </li>
                                        <li class="active">上传文件_<?php echo $tableCName;?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-heading">
                            <h4></h4>上传文件_<?php echo $tableCName;?></h4>
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
                                        <dt><b>上传</b></dt>
                                        <dd>
                                            <div class="col s10">
                                                <div class="dz-wrapper clearfix">
                                                    <div class="dz-notice">
                                                        <p>图片格式只能为.jpg,.jpeg,.png</p>
                                                    </div>
                                                    <div id="photo-list1" class="dz-photo-list dropzone"></div>
                                                    <div id="myDropzone" class="dropzone">
                                                        <div class="dz-default dz-message">
                                                            <div class="dz-btn-wrap">
                                                                <a class="dz-btn" href="javascript:;" title="">
                                                                    <i class="mdi-content-add"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
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
<script type="text/javascript">
    $(function () {
        
        $('#myDropzone').dropzone({
            url: "<?php echo $option['server'];?>",
            previewsContainer: $('#photo-list1')[0],
            maxFiles: <?php echo $option['file_count'];?>,
            maxFilesize:2,
            addRemoveLinks: true,
            acceptedFiles: "<?php echo $option['mime_types'];?>",
            sending: function(file, xhr, formData) {
                formData.append("uid", <?php echo $option['id'];?>);
            },
            maxfilesreached: function() {
                $('#myDropzone').addClass('hide');
            },
            reset: function() {
                $('#myDropzone').removeClass('hide');
            },
            error: function(file, errorMessage) {

                this.removeFile(file);
                swal("错误!", errorMessage, "error");
            },
            removedfile: function(a) {
                $('#myDropzone').removeClass('hide');
                if (a.status == 'success') {
                    $("#Cover").val('');
                }
                $.ajax({
                    url:"<?php echo $option['del_server'];?>",
                    dataType:"json",
                    data:{'uid':<?php echo $option['id'];?>,'agid':a.previewElement.id},
                    type:'POST',
                    success:function (data) {
                        swal(data);
                    }
                });
                var b;
                return a.previewElement && null != (b = a.previewElement) && b.parentNode.removeChild(a.previewElement),
                    this._updateMaxFilesReachedClass()
            },
            success: function(obj, Response) {
                Response = $.parseJSON(Response);
                if (Response.status != 1) {
                    swal("错误!", Response.msg, "error");
                } else {
                    obj.previewElement.id = Response.result;
                    swal(Response.msg);
                    $("#Cover").val(Response.msg);
                }
            }
        });
    });
</script>
</body>

</html>
