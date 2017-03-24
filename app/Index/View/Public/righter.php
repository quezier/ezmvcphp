<?php
$articleTypeLogic = new \App\Logic\ArticleTypeLogic();
$articleTypeResult = $articleTypeLogic->getAllArticleType();
$article_types = $articleTypeResult['result'];

?>
<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <?php if(!empty($_SESSION['user_name'])){?>
    <div class="sidebar-module sidebar-module-inset">
        <h4>欢迎你，<?php echo $_SESSION['user_name'];?></h4>
    </div>
    <?php }?>
    <div class="sidebar-module sidebar-module-inset">
        <h4>分类</h4>
        <ol class="list-unstyled">
            <?php foreach ($article_types as $atKey => $atVal){?>
                <li><a href="<?php echo HTTP_DOMAIN;?>/atid/<?php echo $atVal['id'];?>"><?php echo $atVal['type_name'];?></a></li>
            <?php }?>
        </ol>
    </div>
    <div class="sidebar-module">
        <h4>Elsewhere</h4>
        <ol class="list-unstyled">
            <li><a target="_blank" href="https://github.com/quezier/ezmvcphp">GitHub</a></li>
        </ol>
    </div>
</div><!-- /.blog-sidebar -->
