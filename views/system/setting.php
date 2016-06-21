<div class="container-fluid">
    <h3>系统设置</h3>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="/">首页</a>
            <span class="icon-angle-right"></span>
        </li>
        <li>
            <a href="/system/setting/">系统设置</a>
        </li>
    </ul>
    <div class="tabbable tabbable-custom tabbable-custom-profile">
        <table class="table table-hover">
            <thead>
            <tr>
                <th width="90">系统参数</th>
                <th></th>
                <th width="100"></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>红包手续费</td>
                    <td><?php echo $setting['fee']?>%</td>
                    <td>
                        <button type="button" class="btn mini green button-edit-fee"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
                <tr>
                    <td>投票规则</td>
                    <td><?php echo $setting['rule_vote']?></td>
                    <td>
                        <button type="button" class="btn mini green button-edit-vote"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
                <tr>
                    <td>抢红包规则</td>
                    <td><?php echo $setting['rule_red']?></td>
                    <td>
                        <button type="button" class="btn mini green button-edit-red"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<!-- 红包手续费编辑弹出层 -->
<div id="feeModal" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>红包手续费</h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">红包手续费：</label>
            <div class="controls">
                <input type="text" class="m-wrap fee" placeholder="" value="<?php echo $setting['fee']?>"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm-fee" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
    </div>
</div>

<!-- 投票规则编辑弹出层 -->
<div id="voteModal" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>编辑投票规则</h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <div class="">
                <textarea class="span12 wysihtml5 m-wrap rule-vote" rows="6"><?php echo $setting['rule_vote']?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm-vote" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
    </div>
</div>

<!-- 抢红包规则编辑弹出层 -->
<div id="redModal" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3>编辑抢红包规则</h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <div class="">
                <textarea class="span12 wysihtml5 m-wrap rule-red" rows="6"><?php echo $setting['rule_red']?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm-red" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
    </div>
</div>






