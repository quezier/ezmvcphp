<?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'header.php';?>
<div class="container">

    <div class="blog-header">
        <h1 class="blog-title">搜索结果</h1>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">
            <?php foreach ($articles as $aKey => $aVal){?>
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="<?php echo HTTP_DOMAIN;?>/indexdetail/id/<?php echo $aVal['id'];?>"><?php echo $aVal['title'];?></a></h2>
                <p class="blog-post-meta"><?php echo date('Y-m-d H:m:s',$aVal['pub_date']);?></p>
            </div><!-- /.blog-post -->
            <?php }?>
        </div><!-- /.blog-main -->

        <?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'righter.php';?>

    </div><!-- /.row -->

</div><!-- /.container -->

<?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'footer.php';?>
