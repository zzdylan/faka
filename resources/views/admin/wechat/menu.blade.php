{{--<link href="{{asset('wechatMenu/css/bootstrap.min.css')}}" rel="stylesheet">--}}
<link href="{{asset('wechatMenu/css/menu.css')}}" rel="stylesheet">
<div class="content" style="width:900px;margin:0 auto;">
    <div id="app-menu">
        <!-- 预览窗 -->
        <div class="weixin-preview">
            <div class="weixin-hd">
                <div class="weixin-title">@{{weixinTitle}}</div>
            </div>
            <div class="weixin-bd">
                <ul class="weixin-menu" id="weixin-menu" >
                    <li v-for="(btn,i) in menu.button" class="menu-item" :class="{current:selectedMenuIndex===i&&selectedMenuLevel()==1}" @click="selectedMenu(i,$event)">
                        <div class="menu-item-title">
                            <i class="icon_menu_dot"></i>
                            <span>@{{ btn.name }}</span>
                        </div>
                        <ul class="weixin-sub-menu" v-show="selectedMenuIndex===i">
                            <li v-for="(sub,i2) in btn.sub_button" class="menu-sub-item" :class="{current:selectedSubMenuIndex===i2&&selectedMenuLevel()==2}"  @click.stop="selectedSubMenu(i2,$event)">
                                <div class="menu-item-title">
                                    <span>@{{sub.name}}</span>
                                </div>
                            </li>
                            <li v-if="btn.sub_button.length<5" class="menu-sub-item" @click.stop="addMenu(2)">
                                <div class="menu-item-title">
                                    <i class="icon14_menu_add"></i>
                                </div>
                            </li>
                            <i class="menu-arrow arrow_out"></i>
                            <i class="menu-arrow arrow_in"></i>
                        </ul>
                    </li>
                    <li class="menu-item" v-if="menu.button.length<3" @click="addMenu(1)"> <i class="icon14_menu_add"></i></li>
                </ul>
            </div>
        </div>
        <!-- 主菜单 -->
        <div class="weixin-menu-detail" v-if="selectedMenuLevel()==1">
            <div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
                <div class="menu-name">@{{menu.button[selectedMenuIndex].name}}</div>
                <div class="menu-del" @click="delMenu">删除菜单</div>
            </div>
            <div class="menu-input-group">
                <div class="menu-label">菜单名称</div>
                <div class="menu-input">
                    <input type="text" name="name" placeholder="请输入菜单名称" class="menu-input-text" v-model="menu.button[selectedMenuIndex].name" @input="checkMenuName(menu.button[selectedMenuIndex].name)">
                    <p class="menu-tips" style="color:#e15f63" v-show="menuNameBounds">字数超过上限</p>
                    <p class="menu-tips">字数不超过4个汉字或8个字母</p>
                </div>
            </div>
            <template v-if="menu.button[selectedMenuIndex].sub_button.length==0">
                <div class="menu-input-group">
                    <div class="menu-label">菜单内容</div>
                    <div class="menu-input">
                        <select v-model="menu.button[selectedMenuIndex].type" name="type" class="menu-input-text">
                            <option value="view">跳转网页(view)</option>
                            <option value="media_id">发送消息(media_id)</option>
                            <!--<option value="view_limited">跳转公众号图文消息链接(view_limited)</option>-->
                            <option value="miniprogram">打开指定小程序(miniprogram)</option>
                            <option value="click">自定义点击事件(click)</option>
                            <option value="scancode_push">扫码上传消息(scancode_push)</option>
                            <option value="scancode_waitmsg">扫码提示下发(scancode_waitmsg)</option>
                            <option value="pic_sysphoto">系统相机拍照(pic_sysphoto)</option>
                            <option value="pic_photo_or_album">弹出拍照或者相册(pic_photo_or_album)</option>
                            <option value="pic_weixin">弹出微信相册(pic_weixin)</option>
                            <option value="location_select">弹出地理位置选择器(location_select)</option>
                        </select>
                    </div>
                </div>
                <div class="menu-content" v-if="selectedMenuType()==1">
                    <div class="menu-input-group">
                        <p class="menu-tips">订阅者点击该子菜单会跳到以下链接</p>
                        <div class="menu-label">页面地址</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].url">
                            <p class="menu-tips cursor" @click="selectNewsUrl">从公众号图文消息中选择</p>
                        </div>
                    </div>
                </div>
                <div class="menu-msg-content" v-else-if="selectedMenuType()==2">
                    <div class="menu-msg-head"><i class="icon_msg_sender"></i>图文消息</div>
                    <div class="menu-msg-panel">
                        <div class="menu-msg-select" v-if="menu.button[selectedMenuIndex].media_id==''||menu.button[selectedMenuIndex].media_id==undefined" @click="selectMaterialId">
                            <i class="icon36_common add_gray"></i>
                            <strong>从素材库中选择</strong>
                        </div>
                        <div class="menu-msg-select" v-else>
                            <div class="menu-msg-title"><i class="icon_msg_sender"></i>@{{material.title}}</div>
                            <a :href="material.url" target="_blank" class="btn btn-sm btn-info">查看</a>
                            <div class="btn btn-sm btn-danger" @click="delMaterialId">删除</div>
                        </div>
                    </div>
                </div>
                <div class="menu-content" v-else-if="selectedMenuType()==3">
                    <div class="menu-input-group">
                        <p class="menu-tips">用于消息接口推送，不超过128字节</p>
                        <div class="menu-label">菜单KEY值</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].key">
                        </div>
                    </div>
                </div>
                <div class="menu-content" v-else-if="selectedMenuType()==4">
                    <div class="menu-input-group">
                        <p class="menu-tips">订阅者点击该子菜单会跳到以下小程序</p>
                        <div class="menu-label">小程序APPID</div>
                        <div class="menu-input">
                            <input type="text" placeholder="小程序的appid（仅认证公众号可配置）" class="menu-input-text" v-model="menu.button[selectedMenuIndex].appid">
                        </div>
                    </div>
                    <div class="menu-input-group">
                        <div class="menu-label">小程序路径</div>
                        <div class="menu-input">
                            <input type="text" placeholder="小程序的页面路径 pages/Index/index" class="menu-input-text" v-model="menu.button[selectedMenuIndex].pagepath">
                        </div>
                    </div>
                    <div class="menu-input-group">
                        <div class="menu-label">备用网页</div>
                        <div class="menu-input">
                            <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].url">
                            <p class="menu-tips">旧版微信客户端无法支持小程序，用户点击菜单时将会打开备用网页。</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <!-- 子菜单 -->
        <div class="weixin-menu-detail" v-if="selectedMenuLevel()==2">
            <div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
                <div class="menu-name">@{{menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name}}</div>
                <div class="menu-del" @click="delMenu">删除子菜单</div>
            </div>
            <div class="menu-input-group">
                <div class="menu-label">子菜单名称</div>
                <div class="menu-input">
                    <input type="text" placeholder="请输入子菜单名称" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name" @input="checkMenuName(menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].name)">
                    <p class="menu-tips" style="color:#e15f63" v-show="menuNameBounds">字数超过上限</p>
                    <p class="menu-tips">字数不超过8个汉字或16个字母</p>
                </div>
            </div>
            <div class="menu-input-group">
                <div class="menu-label">子菜单内容</div>
                <div class="menu-input">
                    <select v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].type" name="type" class="menu-input-text">
                        <option value="view">跳转网页(view)</option>
                        <option value="media_id">发送消息(media_id)</option>
                        <!--<option value="view_limited">跳转公众号图文消息链接(view_limited)</option>-->
                        <option value="miniprogram">打开指定小程序(miniprogram)</option>
                        <option value="click">自定义点击事件(click)</option>
                        <option value="scancode_push">扫码上传消息(scancode_push)</option>
                        <option value="scancode_waitmsg">扫码提示下发(scancode_waitmsg)</option>
                        <option value="pic_sysphoto">系统相机拍照(pic_sysphoto)</option>
                        <option value="pic_photo_or_album">弹出拍照或者相册(pic_photo_or_album)</option>
                        <option value="pic_weixin">弹出微信相册(pic_weixin)</option>
                        <option value="location_select">弹出地理位置选择器(location_select)</option>
                    </select>
                </div>
            </div>
            <div class="menu-content" v-if="selectedMenuType()==1">
                <div class="menu-input-group">
                    <p class="menu-tips">订阅者点击该子菜单会跳到以下链接</p>
                    <div class="menu-label">页面地址</div>
                    <div class="menu-input">
                        <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].url">
                        <p class="menu-tips cursor" @click="selectNewsUrl">从公众号图文消息中选择</p>
                    </div>
                </div>
            </div>
            <div class="menu-msg-content" v-else-if="selectedMenuType()==2">
                <div class="menu-msg-head"><i class="icon_msg_sender"></i>图文消息</div>
                <div class="menu-msg-panel">
                    <div class="menu-msg-select" v-if="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].media_id==''||menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].media_id==undefined" @click="selectMaterialId">
                        <i class="icon36_common add_gray"></i>
                        <strong>从素材库中选择</strong>
                    </div>
                    <div class="menu-msg-select" v-else>
                        <i class="icon_msg_sender"></i>@{{material.title}}
                        <a :href="material.url" target="_blank" class="btn btn-sm btn-info">查看</a>
                        <div class="btn btn-sm btn-danger" @click="delMaterialId">删除</div>
                    </div>
                </div>
            </div>
            <div class="menu-content" v-else-if="selectedMenuType()==3">
                <div class="menu-input-group">
                    <p class="menu-tips">用于消息接口推送，不超过128字节</p>
                    <div class="menu-label">菜单KEY值</div>
                    <div class="menu-input">
                        <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].key">
                    </div>
                </div>
            </div>
            <div class="menu-content" v-else-if="selectedMenuType()==4">
                <div class="menu-input-group">
                    <p class="menu-tips">订阅者点击该子菜单会跳到以下小程序</p>
                    <div class="menu-label">小程序APPID</div>
                    <div class="menu-input">
                        <input type="text" placeholder="小程序的appid（仅认证公众号可配置）" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].appid">
                    </div>
                </div>
                <div class="menu-input-group">
                    <div class="menu-label">小程序路径</div>
                    <div class="menu-input">
                        <input type="text" placeholder="小程序的页面路径 pages/Index/index" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].pagepath">
                    </div>
                </div>
                <div class="menu-input-group">
                    <div class="menu-label">备用网页</div>
                    <div class="menu-input">
                        <input type="text" placeholder="" class="menu-input-text" v-model="menu.button[selectedMenuIndex].sub_button[selectedSubMenuIndex].url">
                        <p class="menu-tips">旧版微信客户端无法支持小程序，用户点击菜单时将会打开备用网页。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="weixin-btn-group">
        <div id="btn-create" class="btn btn-success">发布</div>
        <div id="btn-clear" class="btn btn-danger">清空</div>
    </div>
</div>

<!-- 弹出层 -->
<div id="news-list" style="display: none;">
    <table id="news-table" class="table table-bordered">
        <thead>
        <tr>
            <th>图文标题</th>
            <th width="130">日期</th>
            <th width="130">操作</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div id="material-list" style="display: none;">
    <table id="material-table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>素材名称</th>
            <th width="130">操作</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="{{asset('wechatMenu/js/vue.js')}}"></script>
<script src="{{asset('wechatMenu/js/template-web.js')}}"></script>
<script src="{{asset('wechatMenu/js/layer/layer.js')}}"></script>
<script src="{{asset('wechatMenu/js/weixin-menu.js')}}"></script>

<script id="material-tpl" type="text/html">
    @{{each item v k}}
    <tr>
        <td>
            <ul>
                @{{each v.content.news_item v2 k2}}
                <li><a href="@{{v2.url}}" target="_blank">@{{k2+1}}. @{{v2.title}}</a></li>
                @{{/each}}
            </ul>
        </td>
        <td>
            <button onclick="app.setMaterialId('@{{v.media_id}}','@{{v.content.news_item[0].title}}','@{{v.content.news_item[0].url}}')" class="btn btn-primary">选择</button>
        </td>
    </tr>
    @{{/each}}
</script>

<script id="news-tpl" type="text/html">
    @{{each item v k}}
    <tr>
        <td>@{{v.title}}</td>
        <td>@{{v.update_time}}</td>
        <td>
            <a href="@{{v.url}}" target="_blank" class="btn btn-info">查看</a>
            <button onclick="app.setNewsUrl('@{{v.url}}')" class="btn btn-primary btn-material-id">选择</button>
        </td>
    </tr>
    @{{/each}}
</script>