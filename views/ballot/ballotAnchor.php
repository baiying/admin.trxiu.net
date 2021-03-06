
<div class="container-fluid">
    <h3>活动管理</h3>
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
            <a href="#"><?php echo $_GET['ballot_name']?></a>
        </li>
    </ul>
    <div class="row-fluid">
        <button class="btn green button-add" ><i class="icon-plus"></i> 关联活动主播</button>
    </div>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-striped table-bordered table-hover dataTable">
            <thead>
            <tr>
                <th width="70px">活动主播关联ID</th>
                <th>主播ID</th>
                <th>主播昵称</th>
                <th>得票数</th>
                <th>票数修正值</th>
                <th>票数总计</th>
                <th>主播头像地址</th>
                <th>宣传底图</th>
                <th>微信二维码名片地址</th>
                <th>所属平台</th>
                <th>直播间地址</th>
                <th>主播描述</th>
                <th class="span3">操作</th>
            </tr>
            </thead>
            <?php if(!empty($ballotAnchor)):?>
                <tbody>
                <?php foreach($ballotAnchor as $item):?>
                    <tr>
                        <td style="text-align: center;"><?php echo $item['ballot_anchor_id']?></td>
                        <td style="text-align: center;"><?php echo $item['anchor_id']?></td>
                        <td style="text-align: center;"><?php echo $item['Information']['anchor_name']?></td>
                        <td style="text-align: center;"><?php echo $item['votes']?></td>
                        <td style="text-align: center;"><?php echo $item['votes_amend']?>
                            <button type="button" name="votes_amend" class="btn white mini votes_amend"
                                    data-ballot_anchor_id="<?php echo $item['ballot_anchor_id']?>"
                                    data-votes="<?php echo $item['votes']?>"
                                    data-votes_amend="<?php echo $item['votes_amend']?>"
                                    data-votes_total="<?php echo $item['votes_total']?>"
                            ><i class="icon-pencil"></i></button>
                        </td>
                        <td style="text-align: center;"><?php echo $item['votes_total']?></td>
                        <td style="text-align: center;">
                            <?php if(isset($item['Information']['thumb']) && $item['Information']['thumb'] != ""):?>
                                <img width="80" src="<?php echo $item['Information']['thumb']?>" />
                            <?php else:?>
                                <?php echo "无"?>
                            <?php endif;?>
                        </td>
                        <td style="text-align: center;">
                            <?php if($item['Information']['backimage'] != ""):?>
                                <img width="80" src="<?php echo $item['Information']['backimage']?>" />
                            <?php else:?>
                                <?php echo "无"?>
                            <?php endif;?>
                        </td>
                        <td style="text-align: center;">
                            <?php if($item['Information']['qrcode'] != ""):?>
                                <img width="80" src="<?php echo $item['Information']['qrcode']?>" />
                            <?php else:?>
                                <?php echo "无"?>
                            <?php endif;?>
                        </td>
                        <td style="text-align: center;"><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['Information']['platform']?></p></td>
                        <td style="text-align: center;"><a href="<?php echo $item['Information']['broadcast']?>" target="_blank">前往直播间</a></td>
                        <td style="text-align: center;"><p style="width:80px;height:auto;white-space:nowrap;overflow-x:auto;"><?php echo $item['Information']['description']?></p></td>
                        <td style="text-align: center;">
                            <button type="button" name="button-edit" class="btn red mini button-remove"
                                    data-ballot_anchor_id="<?php echo $item['ballot_anchor_id']?>"
                                    data-ballot_id="<?php echo $item['ballot_id']?>"
                                    data-anchor_id="<?php echo $item['anchor_id']?>"
                            ><i class="icon-remove"></i> 退赛</button>
                            <button type="button" name="button-vote" class="btn green mini button-vote" 
                                    data-ballot-id="<?php echo $item['ballot_id']?>"
                                    data-anchor-id="<?php echo $item['anchor_id']?>"
                            ><i class="icon-bar-chart"></i> 投票</button>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            <?php endif;?>
        </table>

        <!--分页-->
        <?php if(!empty($pageBar)):?>
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
        <!-- 分页结束-->
    </div>
</div>
<!-- 管理员信息编辑弹出层 -->
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
            <label class="control-label">选择主播：</label>
            <select name="sel" id="anchorSelect">
                <option value="0">--下拉选择主播--</option>
            </select>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中..." data-ballot_id="<?php echo $ballotId?>">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="ballot_id" value="" />
    </div>
</div>



<!-- 主播票数修正弹出层 -->
<div id="votes-edit" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">总票数：</label>
            <div class="controls">
                <input type="text" class="m-wrap votes-edit-votes_total" placeholder="" value="" disabled="disabled" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">粉丝投票数：</label>
            <div class="controls">
                <input type="text" class="m-wrap votes-edit-votes" placeholder="" value="" readonly="readonly" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">修正票数：</label>
            <div class="controls">
                <input type="text" class="m-wrap votes-edit-votes_amend" placeholder="" value="" />
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-votes_amend" data-loading-text="提交中..." data-ballot_id="<?php if(!empty($item['ballot_anchor_id'])){ echo $item['ballot_anchor_id'];}?>">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="ballot_anchor_id" value="" />
    </div>
</div>





