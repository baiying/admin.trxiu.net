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
                    <td>0.15%</td>
                    <td>
                        <button type="button" class="btn mini green"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
                <tr>
                    <td>投票规则</td>
                    <td></td>
                    <td>
                        <button type="button" class="btn mini green"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
                <tr>
                    <td>抢红包规则</td>
                    <td></td>
                    <td>
                        <button type="button" class="btn mini green"><i class="icon-pencil"></i> 修改</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<!-- 主播信息编辑弹出层 -->
<div id="addAnchor" class="modal hide fade in" tabindex="-1" data-width="760" aria-hidden="false">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3></h3>
    </div>
    <div class="modal-body form-horizontal">
        <div class="alert alert-error hide">
            <span></span>
        </div>
        <div class="control-group">
            <label class="control-label">粉丝ID：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-fans_id" placeholder="" value="" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">粉丝昵称：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-wx_name" placeholder="" value="" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">宣传底图：</label>
            <div class="controls" id="container">
                <img src="" width="200" class="bgimg" style="display:none;" />
                <input type="hidden" class="anchor-backimage" value="" />
                <p>
                    <button type="button" id="pickfiles" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">微信二维码名片地址：</label>
            <div class="controls" id="container_qrcode">
                <img src="" width="200" class="qrcode" style="display:none;" />
                <input type="hidden" class="anchor-qrcode" value="" />
                <p>
                    <button type="button" id="btn_qrcode" data-loading-text="上传中..." class="btn mini green">上传图片</button>
				</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">所属平台：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-platform" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">直播间地址：</label>
            <div class="controls">
                <input type="text" class="m-wrap anchor-broadcast" placeholder="" value="" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">主播描述：</label>
            <div class="controls">
                <textarea class="m-wrap anchor-description" rows="3"></textarea>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button"  class="btn blue button-confirm" data-loading-text="提交中...">确定</button>
        <button type="button" data-dismiss="modal" class="btn">取消</button>
        <input type="hidden" id="managerid" value="" />
    </div>
</div>






