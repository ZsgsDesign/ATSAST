# ATSAST
Auxiliary Teaching for SAST

## Installation

Here is detailed step about deploying ATSAST:

1. You need to have a server and installed the following:
    - [PHP ^7.1.3(recommend 7.3.4)](http://php.net/downloads.php)
    - [Composer ^1.8.5(recommend 1.8.5)](https://getcomposer.org)
    - [MySQL ^5.5.3(recommend 8.0)](https://www.mysql.com/)

2. Clone ATSAST to your website folder;

```
cd /path-to-ATSAST/
git clone https://github.com/ZsgsDesign/ATSAST ./
```

3. Change your website root to `public` folder and then, if there is a `open_basedir` restriction, remove it;

4. Now run the following commands at the root folder of ATSAST;

```
composer install
```

> Notice: you may find this step(or others) fails with message like "func() has been disabled for security reasons", it means you need to remove restrictions on those functions, basically Laravel and Composer require proc_open and proc_get_status to work properly.

5. Almost done, you still got to modify a few folders and give them permission to write;

```
chmod -R 775 storage/
chmod -R 775 bootstrap/
```

6. OK, right now we still need to configure environment, a typical `.env` just like the `.env.example`, you simply need to type the following codes;

```
cp .env.example .env
vim .env
```

7. Now, we need to configure the database, thankfully Laravel have migration already;

```
php artisan migrate
```

8. ATSAST's up-and-running, enjoy!

## To-Do List

- [X] 发现
- [ ] 课程
    - [X] 报名
    - [X] 签到
    - [X] 授课笔记
    - [ ] 查看作业
    - [X] 课程反馈
    - [X] 视频地址
    - [X] 课程管理
    - [X] 新增课程
    - [ ] 查看作业提交
    - [ ] 查看作业提交详情
    - [X] 查看签到情况
    - [X] 查看报名情况
    - [X] 新增课时
    - [ ] 设置签到 //
    - [ ] 设置视频 //
    - [ ] 编辑课时信息 //
    - [ ] 编辑课程信息 //
    - [ ] 编辑授课笔记
    - [ ] 设置反馈 //
    - [ ] 新建作业
    - [ ] 设置作业
    - [ ] 查看反馈 //
- [ ] 活动
    - [X] 首页
    - [X] 活动详情
    - [ ] 活动报名
- [X] PasteBin
- [X] 报销
- [X] 借还
    - [X] 首页
    - [X] 物品详情
    - [X] 发布物品
    - [X] 购物车
    - [X] 创建订单
    - [X] 订单管理
- [ ] 网盘
- [ ] 博客
- [X] 账号相关
    - [X] 个人主页
    - [X] 报名活动
    - [X] 更多设置
    - [ ] 激活账号
    - [ ] 找回密码
    - [ ] 修改密码
    - [ ] 用户信息
- [ ] 系统相关
    - [ ] 管理工具
    - [X] 版本日志
    - [X] 汇报BUG
    - [ ] 系统信息
    - [ ] 身份验证
    - [ ] 调色板
    - [ ] 新建课程
    - [ ] SAST课程表工具