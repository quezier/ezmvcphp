# ezmvcphp
简单高效易用安全的phpmvc框架，基于php5.3+,支持php7.0。
简单: 主要文件5个，其中最核心的入口文件包括空行换行只有200多行，相当精简。
高效：采用composer自动加载机制，结构清晰，加载速度快。支持php7,运行速度是php5的两倍以上
易用：根据数据表可以自动生成路由配置，数据模型类，逻辑类，控制器类，大大提高开发效率。
     完全面向对象设计，遵循mvc分层，结构清晰，易于升级，维护，扩展。同时，通过路由配置，
     也可以实现restful资源接口设计。提供了一套管理后台UI，直接可以使用。
安全：采用pdo操作数据库，从底层杜绝sql注入，并且预编译sql语句，加快语句执行效率，输入参数
     做了过滤，防止xss攻击。360安全卫士检测，本框架开发的项目可以达到100分。


#环境准备
        1.nginx
        2.php7.0+
        3.mariadb 10.0 or mysql
        
#环境设置及必须的配置
        1. php需要打开pathinfo模块，并配置好error_log<br>
        2. nginx根据本项目根目录下提供的nginx.conf来配置,测试时建议设置nginx虚拟主机，域名使用www.test.ez
        3. windows下，打开c:/windows/system32/drivers/etc/hosts文件，加入映射:127.0.0.1 www.test.ez
        4. 所有数据表必须设定主键，并且主键名统一是"id"
        5. 所有字段必须有注释，且格式为："字段名|数据类型|详细注释",其中"字段名|数据类型"是必须的，数据类型有7种：
        email,mobile,tel,zip,int,double,str,其中int就表示mysql中所有的int型,double就包括了mysql中所有的浮点型，str
        表示的是所有字符型，这7种数据类型对应了config/dbfield_rule.php中定义的验证规则，在后面自动生成的model中，有一
        个验证字段方法会用到这些规则。

#项目入口
        项目入口只有根目录/public，这里唯一的入口文件是index.php,所以在nginx里定义项目根目录时，要指定到public目录
		
更详细的内容请参考项目根目录下的readme.txt
