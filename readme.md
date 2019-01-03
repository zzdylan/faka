  ## 项目概述 
  * 项目名称：faka
  * [演示前台][1] 
  * [演示后台][2]
    演示账号/密码：admin/admin
  
  faka是一个简洁的后台管理系统基础框架  
  qq交流群：707730731
  
  ## 后台功能如下
  - 菜单管理
  - 后台用户管理
  - 角色管理
  - 权限管理
  - 商品分类管理
  - 商品管理
  - 卡密管理
  - 订单管理
  
  ## 运行环境建议
  
  - Nginx 1.8+
  - PHP 7.1+
  - Mysql 5.6+
  
  ## 开发环境部署/安装
  
  本项目代码使用php框架laravel5.5开发
  
  ### 基础安装
  
  #### 1. 克隆源代码
  
  克隆 `faka` 源代码到本地：
  
      git clone https://github.com/zzDylan/faka
  
  
  #### 2. 安装扩展包依赖
  
  	composer install
  
  #### 3. 生成配置文件
  
  ```
  cp .env.example .env
  ```
  
  你可以根据情况修改 `.env` 文件里的内容，如数据库连接、缓存、邮件设置、七牛云存储等：
  
  ```
  APP_URL=http://localhost
  
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=XXX
  DB_USERNAME=XXX
  DB_PASSWORD=XXX
  ...
  ...
  YOUZAN_CLIENT_ID=XXX
  YOUZAN_CLIENT_SECRET=XXX
  YOUZAN_KDT_ID=XXX
  ```
  本系统对接的是有赞支付，不需要企业认证，是个人收款的解决方案（申请教程见最下方）  
  申请完之后把三个参数填入到.env的最后三个参数中（YOUZAN_CLIENT_ID、YOUZAN_CLIENT_SECRET、YOUZAN_KDT_ID），  
  三个参数的意思分别为有赞的client_id、client_secret、授权店铺id
  
  #### 4. 生成数据表
  
  在网站根目录下运行以下命令
  
  ```shell
  php artisan migrate
  ```
  
  #### 5.生成菜单数据以及初始管理员数据
  
  ```shell
  php artisan db:seed
  ```
  
  
  #### 6. 生成秘钥
  
  ```shell
  php artisan key:generate
  ```
  
  #### 7.申请有赞微小店
  * [教程链接][3]  
  整体流程  
  第一步：开通微小店
  
  去这里注册并开通小店：https://h5.youzan.com/v2/index/wxdpc (手机下载客户端开通哦，不是微商城！是微小店，免费的！)
  
  第二步：注册有赞云
  创建自用型应用，填写应用名称，下一步，选择你上面开通的小店名称并完成授权绑定。
  

  [1]: http://118.89.190.171:8080/
  [2]: http://118.89.190.171:8080/admin
  [3]: http://118.89.190.171:8080/youzan.html