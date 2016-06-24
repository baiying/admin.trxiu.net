<div class="container-fluid">
    <h3>主播动态</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/anchor/index/">主播管理</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a >主播动态</a>
        </li>
    </ul>
    <div class="span12 blog-page">
    	<div class="row-fluid">
    		<div class="span9 article-block">
    		    <h3><button type="button" class="btn green button-add" ><i class="icon-plus"></i> 发布动态</button></h3>
    		    <?php if(isset($news)):?>
    		    <?php foreach($news as $item):?>
    		    <hr>
                <div class="media" id="news_<?php echo $item['news_id']?>">
                	<a class="pull-left">
                	<img alt="" src="<?php echo $anchor['thumb']?>" class="media-object">
                	</a>
                	<div class="media-body">
                		<h4 class="media-heading"><?php echo $anchor['anchor_name']?>
                            <span><?php echo Yii::$app->utils->formatTime($item['create_time'])?>
                                /
                                <a href="javascript:;" class="button-edit" data-news-id="<?php echo $item['news_id']?>">
                                    编辑
                                </a>
                                /
                                <a href="javascript:;" class="button-del" data-news_id="<?php echo $item['news_id']?>" data-anchor_id="<?php echo $item['anchor_id']?>">
                                    删除
                                </a>
                            </span>
                        </h4>
                		<p class="content"><?php echo $item['content']?></p>
                		<?php if($item['images'] != ""):?>
                		<ul class="unstyled blog-images">
                		    <?php foreach(json_decode($item['images'], true) as $img):?>
            				<li ><a href="<?php echo $img?>" target="_blank"><img alt="" src="<?php echo $img?>"></a></li>
            				<?php endforeach;?>
            			</ul>
            			<?php endif;?>
            			<?php if(!empty($item['comment'])):?>
            			<?php foreach($item['comment'] as $cmt):?>
                		<hr>
                		<div class="media">
                			<a href="#" class="pull-left">
                			<img alt="" src="<?php echo $cmt['fans']['wx_thumb']?>" class="media-object">
                			</a>
                			<div class="media-body">
                				<h4 class="media-heading">
                                    <?php echo $cmt['fans']['wx_name']?>
                                    <span>
                                        <?php echo Yii::$app->utils->formatTime($cmt['create_time'])?>
                                        /
                                        <a href="javascript:;" class="button-comment_del" data-comment_id="<?php echo $cmt['comment_id']?>" data-fans_id="<?php echo $cmt['fans_id']?>">
                                            删除
                                        </a>
                                    </span>
                                </h4>
                				<p><?php echo $cmt['content']?></p>
                			</div>
                		</div>
                		<?php endforeach;?>
                		<?php endif;?>
                	</div>
                </div>
                <?php endforeach;?>
                <?php endif;?>
                <!--end media-->
            </div>
        </div>
        <?php if($pageBar != ""):?>
            <div class="row-fluid">
                <div class="span6">&nbsp;</div>
                <div class="span6">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php echo $pageBar;?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>
<!-- 动态内容编辑弹出层 -->
<div id="editModal" class="modal hide fade" tabindex="-1" data-backdrop="static" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <textarea rows="5" class="m-wrap span12 news-content" placeholder="填写主播动态内容"></textarea>
        </div>
        <div class="control-group">
            <ul class="unstyled blog-images"></ul>
            <div id="image_container">
                <button type="button" id="button-upload" data-loading-text="上传中..." class="btn green button-upload">上传图片</button>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-publish" data-loading-text="提交中...">发布动态</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="anchor_id" value="<?php echo $anchor_id?>" />
        <input type="hidden" id="news_id" value="" />
    </div>
</div>