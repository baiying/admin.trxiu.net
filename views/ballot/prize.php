<div class="container-fluid">
    <h3>活动奖项设置</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/ballot/index/">活动管理</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a >活动奖项设置</a>
        </li>
    </ul>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 添加奖项</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="25">
                    <input type="checkbox" class="group-checkable checkall" data-set="#sample_1 .checkboxes">
                </th>
                <th>奖项级别</th>
                <th>奖品名称</th>
                <th>Logo</th>
                <th>奖品实物图</th>
                <th>排序</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($prizes)):?>
                <tbody>
                <?php foreach($prizes as $item):?>
                    <tr>
                        <td>
                            <input type="checkbox" class="group-checkable checkitem" value="<?php echo $item['prize_id']?>" />
                        </td>
                        <td><?php echo $item['level']?></td>
                        <td><?php echo $item['title']?></td>
                        <td>
                            <?php if($item['logo'] != ""):?>
                            <img src="<?php echo $item['logo']?>" width="60" />
                            <?php else:?>
                            <?php echo "无";?>
                            <?php endif;?>
                        </td>
                        <td>
                            <?php if($item['image'] != ""):?>
                            <img src="<?php echo $item['image']?>" width="60" />
                            <?php else:?>
                            <?php echo "无";?>
                            <?php endif;?>
                        </td>
                        <td><?php echo $item['sort']?></td>
                        <td>
                            <button type="button" name="button-edit" class="btn green mini button-edit"
                                    data-prize-id="<?php echo $item['prize_id']?>"
                                    data-level="<?php echo $item['level']?>"
                                    data-title="<?php echo $item['title']?>"
                                    data-logo="<?php echo $item['logo']?>"
                                    data-image="<?php echo $item['image']?>"
                                    data-sort="<?php echo $item['sort']?>"
                            ><i class="icon-pencil"></i> 编辑</button>
                            <button type="button" class="btn red mini button-delete" data-prize-id="<?php echo $item['prize_id']?>">
                            <i class="icon-trash"></i> 删除</button>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            <?php endif;?>
        </table>

    </div>
</div>
<!-- 添加/编辑奖项设置弹出层 -->
<div id="editModal" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">奖项级别：</label>
            <div class="controls">	
                <input type="text" class="m-wrap required data-level" data-args="level" placeholder="" value="" />
                <span class="text-error"></span>
			</div>
        </div>
        <div class="control-group">
            <label class="control-label">奖品名称：</label>
            <div class="controls">	
                <input type="text" class="m-wrap required data-title" data-args="title" placeholder="" value="" />
                <span class="text-error"></span>
			</div>
        </div>
        <div class="control-group">
            <label class="control-label">排序：</label>
            <div class="controls">	
                <input type="text" class="m-wrap required data-sort" data-args="sort" placeholder="" value="" />
                <span class="text-error"></span>
			</div>
        </div>
        <div class="control-group">
            <label class="control-label">奖品品牌logo：</label>
            <div class="controls" id="logo_container">
                <img src="" width="200" class="review_logo" style="display:none;" />
                <input type="hidden" class="required data-logo" data-args="logo" value="" />
                <span class="text-error"></span>
                <p>
                    <button type="button" id="btn_logo" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">奖品实物图：</label>
            <div class="controls" id="image_container">
                <img src="" width="200" class="review_image" style="display:none;" />
                <input type="hidden" class="required data-image" data-args="image" value="" />
                <span class="text-error"></span>
                <p>
                    <button type="button" id="btn_image" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中..." >确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="ballot_id" value="<?php echo $ballot_id?>" />
        <input type="hidden" id="prize_id" value="" />
    </div>
</div>






