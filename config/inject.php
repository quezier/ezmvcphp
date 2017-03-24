<?php
/**
 * @package        EzMvcPHP
 * @author         quezier
 * @email          33590896@qq.com
 */
return array(
    'pre_controller'=>array(
        'class'=>'App\Inject\PreController',
        'action'=>'action'
    ),
    'after_controller'=>array(
        'class'=>'App\Inject\AfterController',
        'action'=>'action'
    )
);