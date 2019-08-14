<?php

use Illuminate\Database\Seeder;

class AdminConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_config')->delete();
        
        \DB::table('admin_config')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '__configx__',
                'value' => 'do not delete',
                'description' => '{"base.site_open":{"options":[],"element":"yes_or_no","help":"\\u7f51\\u7ad9\\u662f\\u5426\\u5f00\\u542f","name":"\\u7f51\\u7ad9\\u5f00\\u542f","order":5},"base.site_name":{"options":[],"element":"normal","help":"\\u7f51\\u7ad9\\u540d\\u79f0","name":"\\u7f51\\u7ad9\\u540d\\u79f0","order":10},"base.site_logo":{"options":[],"element":"image","help":"\\u7f51\\u7ad9logo","name":"\\u7f51\\u7ad9logo","order":15},"mail.driver":{"options":{"smtp":"smtp"},"element":"normal","help":"\\u90ae\\u4ef6\\u9a71\\u52a8","name":"\\u90ae\\u4ef6\\u9a71\\u52a8","order":5},"mail.host":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u4e3b\\u673a,\\u5982smtp.163.com","name":"\\u90ae\\u4ef6\\u4e3b\\u673a","order":10},"mail.port":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u7aef\\u53e3","name":"\\u90ae\\u4ef6\\u7aef\\u53e3","order":15},"mail.from.address":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u53d1\\u4ef6\\u4eba\\u5730\\u5740","name":"\\u90ae\\u4ef6\\u53d1\\u4ef6\\u4eba\\u5730\\u5740","order":20},"mail.from.name":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u53d1\\u4ef6\\u4eba\\u59d3\\u540d","name":"\\u90ae\\u4ef6\\u53d1\\u4ef6\\u4eba\\u59d3\\u540d","order":25},"mail.username":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u7528\\u6237\\u540d","name":"\\u90ae\\u4ef6\\u7528\\u6237\\u540d","order":30},"mail.password":{"options":[],"element":"normal","help":"\\u90ae\\u4ef6\\u5bc6\\u7801","name":"\\u90ae\\u4ef6\\u5bc6\\u7801","order":35},"notice.open":{"options":[],"element":"yes_or_no","help":"\\u662f\\u5426\\u5f00\\u542f\\u516c\\u544a","name":"\\u662f\\u5426\\u5f00\\u542f\\u516c\\u544a","order":5},"notice.content":{"options":[],"element":"editor","help":"\\u516c\\u544a\\u5185\\u5bb9","name":"\\u516c\\u544a\\u5185\\u5bb9","order":10},"notice.button_title":{"options":[],"element":"normal","help":"\\u516c\\u544a\\u6309\\u94ae\\u6807\\u9898","name":"\\u516c\\u544a\\u6309\\u94ae\\u6807\\u9898","order":15},"notice.button_url":{"options":[],"element":"normal","help":"\\u516c\\u544a\\u94fe\\u63a5","name":"\\u516c\\u544a\\u94fe\\u63a5","order":20},"payjs.mchid":{"options":[],"element":"normal","help":"payjs\\u5546\\u6237\\u53f7","name":"payjs\\u5546\\u6237\\u53f7","order":5},"payjs.key":{"options":[],"element":"normal","help":"payjs\\u901a\\u4fe1\\u5bc6\\u94a5","name":"payjs\\u901a\\u4fe1\\u5bc6\\u94a5","order":10},"payjs.wechat":{"options":[],"element":"yes_or_no","help":"\\u662f\\u5426\\u5f00\\u542f\\u5fae\\u4fe1\\u652f\\u4ed8","name":"\\u662f\\u5426\\u5f00\\u542f\\u5fae\\u4fe1\\u652f\\u4ed8","order":15},"payjs.alipay":{"options":[],"element":"yes_or_no","help":"\\u662f\\u5426\\u5f00\\u542f\\u652f\\u4ed8\\u5b9d\\u652f\\u4ed8","name":"\\u662f\\u5426\\u5f00\\u542f\\u652f\\u4ed8\\u5b9d\\u652f\\u4ed8","order":20}}',
                'created_at' => '2019-08-13 11:29:31',
                'updated_at' => '2019-08-15 01:13:48',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'base.site_open',
                'value' => '1',
                'description' => '网站名称',
                'created_at' => '2019-08-13 11:31:06',
                'updated_at' => '2019-08-13 11:36:27',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'base.site_name',
                'value' => 'dylan发卡系统',
                'description' => '网站名称',
                'created_at' => '2019-08-13 11:36:48',
                'updated_at' => '2019-08-13 11:52:14',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'base.site_logo',
                'value' => 'images/130635c367a2eb6bbc8c2398e234832f.png',
                'description' => '网站logo',
                'created_at' => '2019-08-13 11:37:08',
                'updated_at' => '2019-08-14 23:30:59',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'mail.driver',
                'value' => 'smtp',
                'description' => '邮件驱动',
                'created_at' => '2019-08-13 11:38:59',
                'updated_at' => '2019-08-13 11:38:59',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'mail.host',
                'value' => 'smtp.163.com',
                'description' => '邮件主机',
                'created_at' => '2019-08-13 11:39:51',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'mail.port',
                'value' => '465',
                'description' => '邮件端口',
                'created_at' => '2019-08-13 11:40:24',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'mail.from.address',
                'value' => '13075534552@163.com',
                'description' => '邮件发件人地址',
                'created_at' => '2019-08-13 11:40:49',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'mail.from.name',
                'value' => '发卡系统',
                'description' => '邮件发件人姓名',
                'created_at' => '2019-08-13 11:41:04',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'mail.username',
                'value' => '13075534552@163.com',
                'description' => '邮件用户名',
                'created_at' => '2019-08-13 11:41:25',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'mail.password',
                'value' => 'zz123456',
                'description' => '邮件密码',
                'created_at' => '2019-08-13 11:41:38',
                'updated_at' => '2019-08-13 11:53:41',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'notice.open',
                'value' => '1',
                'description' => '是否开启公告',
                'created_at' => '2019-08-13 11:42:17',
                'updated_at' => '2019-08-14 23:29:43',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'notice.content',
                'value' => '<p style="text-align: center;">去github上给个star呗，小弟感激不尽</p>',
                'description' => '公告内容',
                'created_at' => '2019-08-13 11:42:40',
                'updated_at' => '2019-08-14 23:29:43',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'notice.button_title',
                'value' => '火速围观',
                'description' => '公告按钮标题',
                'created_at' => '2019-08-13 11:43:06',
                'updated_at' => '2019-08-14 23:29:43',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'notice.button_url',
                'value' => 'https://github.com/zzDylan/faka',
                'description' => '公告链接',
                'created_at' => '2019-08-13 11:43:28',
                'updated_at' => '2019-08-14 23:29:43',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'payjs.mchid',
                'value' => '1550362101',
                'description' => 'payjs商户号',
                'created_at' => '2019-08-13 18:40:10',
                'updated_at' => '2019-08-13 18:41:20',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'payjs.key',
                'value' => 'JirS4Oo6uX0hsIij',
                'description' => 'payjs通信密钥',
                'created_at' => '2019-08-13 18:40:29',
                'updated_at' => '2019-08-13 18:41:20',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'payjs.wechat',
                'value' => '1',
                'description' => '是否开启微信支付',
                'created_at' => '2019-08-15 01:12:16',
                'updated_at' => '2019-08-15 01:18:20',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'payjs.alipay',
                'value' => '1',
                'description' => '是否开启支付宝支付',
                'created_at' => '2019-08-15 01:12:32',
                'updated_at' => '2019-08-15 01:18:05',
            ),
        ));
        
        
    }
}