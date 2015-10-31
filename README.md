## seejs

A new blog project

### 预览

[http://mailzwj.github.io/seejs/index.html](http://mailzwj.github.io/seejs/index.html)

### 使用方法

* 本地配置Apache+PHP+Mysql环境
* 下载seejs项目或直接clone仓库到本地
* 复制seejs目录中的所有文件到服务器根目录下
* 进入Mysql命令行（或图形管理工具），创建数据库并导入seejs-structure.sql文件
* 修改inc/conn.php中的数据库信息
* 启动Apache服务器，访问：http://localhost/index.php进入首页，此时可能除了警告或错误，其他什么都没有
* 返回数据库管理工具，在managers表中手动添加管理员账号（密码需做MD5加密处理）
* 访问：http://localhost/admin/index.php，使用刚创建的管理员账号登入
* 挨项配置好数据，再次返回首页，界面显示正常
* Over.
