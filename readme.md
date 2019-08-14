  ## 项目概述 
  * 项目名称：faka
  * [演示前台][1] 
  * [演示后台][2]
    演示账号/密码：admin/admin
  
  faka是一个为个人收款而生的发卡系统  
    
  目前对接的payjs支付方式有：  
  微信和支付宝扫码支付,微信jsapi  
  在电脑上会用扫码支付，在微信中会使用jsapi方式支付  
  从邀请链接进去会有奖励https://payjs.cn/ref/DLXXLD
    
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
  - 邮件模板
  
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
  
  
  #### 2. 生成配置文件
  
  ```
  cp .env.example .env
  ```
  
  你可以根据情况修改 `.env` 文件里数据库连接信息和APP_URL为自己的：
  
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
  ```
  
 #### 3. 安装扩展包依赖
    
    	composer install
  本系统对接的是有payjs，不需要企业认证，是个人收款的解决方案

  
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

 #### 7. 软链接存储目录
  
  ```shell
  php artisan storage:link
  ```

 #### 8.给予目录权限,项目根目录下执行
   ```shell
   chmod -R 777 storage/ bootstrap/
   chown -R www:www *
   ```


  [1]: http://faka.51godream.com/
  [2]: http://faka.51godream.com/admin
