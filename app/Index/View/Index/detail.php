<?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'header.php';?>
<div class="container">

    <div class="blog-header">
        <h4 class="blog-title" style="font-size: 36px;font-weight: bold;"><?php echo $article['title'];?></h4>
        <p class="blog-post-meta"><?php echo date('Y-m-d H:m:s',$article['pub_date']);?></p>
    </div>

    <div class="row">

        <div class="col-sm-8 blog-main">
            <?php echo html_entity_decode($article['content']);?>
        </div><!-- /.blog-main -->

        <?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'righter.php';?>

    </div><!-- /.row -->

</div><!-- /.container -->

<?php require_once PROJECT_ROOT.DIR_SP.'app'.DIR_SP.'Index'.DIR_SP.'View'.DIR_SP.'Public'.DIR_SP.'footer.php';?>
