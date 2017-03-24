# ezmvcphp
简单高效易用的phpmvc框架，基于php7.0，效率更高，使用了函数参数及返回值的强类型定义，所以不向下兼容，完全面向对象。

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