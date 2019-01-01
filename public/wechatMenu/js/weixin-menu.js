//API
var api='http://member.peipan.com.cn/wechat_menus'
var getMenuAPI=api
var createMenuAPI=api
var clearMenuAPI=api
var getMaterialAPI='test_material_detail.json'
var getMaterialListAPI='test_material.json'
var getNewsListAPI='test_news.json'
var that=this

//列表偏移和总数
var newsListOffset=0;
var materialListOffset=0;
var newsListTotal=0;
var materialListTotal=0;

//Vue
var app = new Vue({
    el: '#app-menu',
    data: {
        weixinTitle: '公众号菜单',
        menu: {'button': []},//当前菜单
        selectedMenuIndex:'',//当前选中菜单索引
        selectedSubMenuIndex:'',//当前选中子菜单索引
		menuNameBounds:false,//菜单长度是否过长
		material:{
            title:'',
            url:'',
            thumb_url:''
        }
    },
    mounted:function(){
        this.getMenu()
    },
    methods: {
        getMenu:function(){
            var _this=this
            $.ajax({
                type: 'GET',
                timeout: 20000,
                url:getMenuAPI,
                async: false,
                dataType: 'json',
                success: function (res) {
                    if (res.errcode == 0) {
                        _this.menu=res.data.menu
                    }
                }
            })
        },
        //选中主菜单
        selectedMenu:function(i,event){
            this.selectedSubMenuIndex=''
            this.selectedMenuIndex=i
            var selectedMenu=this.menu.button[this.selectedMenuIndex]
            //清空选中media_id 防止再次请求
			if(selectedMenu.media_id!=undefined&&selectedMenu.media_id!=''&&this.selectedMenuType()==2){
                this.getMaterial(selectedMenu.media_id)
            }
            //检查名称长度
            this.checkMenuName(selectedMenu.name)
        },
        //选中子菜单
        selectedSubMenu:function(i,event){
            this.selectedSubMenuIndex=i
            var selectedSubMenu=this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex]
            if(selectedSubMenu.media_id!=undefined&&selectedSubMenu!=''&&this.selectedMenuType()==2){
                this.getMaterial(selectedSubMenu.media_id)
            }
            this.checkMenuName(selectedSubMenu.name)
        },
        //选中菜单级别
		selectedMenuLevel: function () {
            if (this.selectedMenuIndex !== '' && this.selectedSubMenuIndex === '') {
                //主菜单
                return 1;
            }else if (this.selectedMenuIndex !== '' && this.selectedSubMenuIndex !== '') {
                //子菜单
                return 2;
            }else {
                //未选中任何菜单
                return 0;
            }
        },
        //获取菜单类型 1. view网页类型，2. media_id类型和view_limited类型 3. click点击类型，4.miniprogram表示小程序类型
        selectedMenuType: function () {
            if (this.selectedMenuLevel() == 1&&this.menu.button[this.selectedMenuIndex].sub_button.length==0) {
                //主菜单
                switch (this.menu.button[this.selectedMenuIndex].type) {
                    case 'view':return 1;
                    case 'media_id':return 2;
                    case 'view_limited':return 2;
                    case 'click':return 3;
                    case 'scancode_push':return 3;
                    case 'scancode_waitmsg':return 3;
                    case 'pic_sysphoto':return 3;
                    case 'pic_photo_or_album':return 3;
                    case 'pic_weixin':return 3;
                    case 'location_select':return 3;
                    case 'miniprogram':return 4;
                }
            } else if (this.selectedMenuLevel() == 2) {
                //子菜单
                switch (this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex].type) {
                    case 'view':return 1;
                    case 'media_id':return 2;
                    case 'view_limited':return 2;
                    case 'click':return 3;
                    case 'scancode_push':return 3;
                    case 'scancode_waitmsg':return 3;
                    case 'pic_sysphoto':return 3;
                    case 'pic_photo_or_album':return 3;
                    case 'pic_weixin':return 3;
                    case 'location_select':return 3;
                    case 'miniprogram':return 4;
                }
            } else {
                return 1;
            }
        },
        //添加菜单
		addMenu:function(level){
			if(level==1&&this.menu.button.length<3){
				this.menu.button.push({
					"type": "view",
					"name": "菜单名称",
					"sub_button": [],
                    "url":""
				})
                this.selectedMenuIndex=this.menu.button.length-1
                this.selectedSubMenuIndex=''
			}
			if(level==2&&this.menu.button[this.selectedMenuIndex].sub_button.length<5){
				this.menu.button[this.selectedMenuIndex].sub_button.push({
					"type": "view",
					"name": "子菜单名称",
                    "url":""
				})
				this.selectedSubMenuIndex=this.menu.button[this.selectedMenuIndex].sub_button.length-1
			}
		},
        //删除菜单
		delMenu:function(){
			if(this.selectedMenuLevel()==1&&confirm('删除后菜单下设置的内容将被删除')){
				if(this.selectedMenuIndex===0){
					this.menu.button.splice(this.selectedMenuIndex, 1);
					this.selectedMenuIndex = 0;
				}else{
					this.menu.button.splice(this.selectedMenuIndex, 1);
					this.selectedMenuIndex -=1;
				}
				if(this.menu.button.length==0){
                    this.selectedMenuIndex = ''
                }
			}else if(this.selectedMenuLevel()==2){
                if(this.selectedSubMenuIndex===0){
                    this.menu.button[this.selectedMenuIndex].sub_button.splice(this.selectedSubMenuIndex, 1);
                    this.selectedSubMenuIndex = 0;
                }else{
                    this.menu.button[this.selectedMenuIndex].sub_button.splice(this.selectedSubMenuIndex, 1);
                    this.selectedSubMenuIndex -= 1;
                }
                if(this.menu.button[this.selectedMenuIndex].sub_button.length==0){
                    this.selectedSubMenuIndex = ''
                }
			}
		},
        //检查菜单名称长度
		checkMenuName:function(val){
			if(this.selectedMenuLevel()==1&&this.getMenuNameLen(val)<=8){
                this.menuNameBounds=false
			}else if(this.selectedMenuLevel()==2&&this.getMenuNameLen(val)<=16){
                this.menuNameBounds=false
			}else{
			    this.menuNameBounds=true
            }
		},
        //获取菜单名称长度
        getMenuNameLen: function (val) {
            var len = 0;
            for (var i = 0; i < val.length; i++) {
                var a = val.charAt(i);
                a.match(/[^\x00-\xff]/ig) != null?len += 2:len += 1;
            }
            return len;
        },
        //选择公众号素材库素材
        selectMaterialId:function(){
            layer.open({
                type: 1,
                title:'选择素材',
                area: ['900px', '600px'], //宽高
                content: $('#material-list'),
                scrollbar: false,
                success:function(){
                    if($('#material-list').find('tbody').children().length==0){
                        getMaterialList()
                    }
                }
            });
        },
        //选择公众号图文链接
        selectNewsUrl:function(){
            layer.open({
                type: 1,
                title:'选择图文',
                area: ['850px', '600px'], //宽高
                content: $('#news-list'),
                scrollbar: false,
                success:function(){
                    if($('#news-list').find('tbody').children().length==0){
                        getNewsList()
                    }
                }
            })
        },
		//设置选择的素材id
		setMaterialId:function(id,title,url){
			if(this.selectedMenuLevel()==1){
				Vue.set(this.menu.button[this.selectedMenuIndex],'media_id',id) 
			}else if(this.selectedMenuLevel()==2){
				Vue.set(this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex],'media_id',id)
			}
			this.material.title=title
            this.material.url=url
			layer.close(layer.index);
		},
		//删除选择的素材id
		delMaterialId:function(){
			if(this.selectedMenuLevel()==1){
				this.menu.button[this.selectedMenuIndex].media_id=''
			}else if(this.selectedMenuLevel()==2){
				this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex].media_id=''
			}
		},
		//设置选择的图文链接
		setNewsUrl:function(url){
			if(this.selectedMenuLevel()==1){
				Vue.set(this.menu.button[this.selectedMenuIndex],'url',url)
			}else if(this.selectedMenuLevel()==2){
				Vue.set(this.menu.button[this.selectedMenuIndex].sub_button[this.selectedSubMenuIndex],'url',url)
			}
			layer.close(layer.index);
		},
		//获取素材信息
        getMaterial:function(id){
			var _this=this
            $.ajax({
                type: 'GET',
                timeout: 20000,
                url:getMaterialAPI,
                data:{
                  'media_id':id
                },
                async: false,
                dataType: 'json',
                success: function (res) {
                    if (res.errcode == 0) {
                        _this.material.title=res.data.news_item[0].title
                        _this.material.url=res.data.news_item[0].url
                    }
                }
            })
        }
    }
})

//发布菜单
$('#btn-create').click(function(){
    var layerId = layer.load(2);
    $.ajax({
        type: 'POST',
        timeout: 20000,
        url:createMenuAPI,
        data:{
            "menu":JSON.stringify(app.menu)
        },
        async: true,
        dataType: 'json',
        success: function (res) {
            layer.close(layerId);
            if (res.errcode == 0) {
                layer.msg('发布自定义菜单成功')
            }else{
                layer.msg('发布自定义菜单失败：'+res.errmsg)
            }
        },
        error:function(){
            layer.close(layerId);
            layer.msg('网络错误')
        }
    })
})
//清空菜单
$('#btn-clear').click(function(){
    if(!confirm('确定后将清空后公众号自定义菜单')){
        return false;
    }
	var layerId = layer.load(2);
    $.ajax({
        type: 'DELETE',
        timeout: 20000,
        url:clearMenuAPI,
        data:{
            "menu":JSON.stringify(app.menu)
        },
        async: true,
        dataType: 'json',
        success: function (res) {
            layer.close(layerId);
            if (res.errcode == 0) {
                layer.msg('清空成功')
            }else{
                layer.msg('清空失败：'+res.errmsg)
            }
        },
        error:function(){
            layer.close(layerId);
            layer.msg('网络错误')
        }
    })
})
//获取素材列表
function getMaterialList(offset){
    $.ajax({
        type: 'GET',
        timeout: 20000,
        url:getMaterialListAPI,
        data:{
            'type':'news',
            'offset':offset,
            'count':20
        },
        async: false,
        dataType: 'json',
        success: function (res) {
            console.log(res);
            if (res.errcode == 0) {
                var html=template('material-tpl',res.data)
                $('#material-table').find('tbody').append(html)
                that.materialListOffset+=res.data.item_count;
                that.materialListTotal+=res.data.total_count;
            }
        }
    })
}
//获取图文列表
function getNewsList(offset){
    $.ajax({
        type: 'GET',
        timeout: 20000,
        url:getNewsListAPI,
        data:{
            'offset':offset,
            'count':1
        },
        async: false,
        dataType: 'json',
        success: function (res) {
            console.log(res);
            if (res.errcode == 0) {
                var html=template('news-tpl',res.data)
                $('#news-list').find('tbody').append(html)
                that.newsListOffset+=res.data.item_count;
                that.newsListTotal+=res.data.total_count;
            }
        }
    })
}

//滚动加载
$('#material-list').on('scroll',function(){
    var offset=that.materialListOffset+20
    var sum = this.scrollHeight-50;
    if (sum <= $(this).scrollTop() + $(this).height()&&offset<that.materialListTotal) {
        getMaterialList(offset)
    }
})

$('#news-list').on('scroll',function(){
    var offset=that.newsListOffset+20
    var sum = this.scrollHeight-50;
    if (sum <= $(this).scrollTop() + $(this).height()&&offset<that.newsListTotal) {
        getNewsList(offset)
    }
})