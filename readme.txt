#环境准备
	1.nginx
	2.php7.0+
	3.mariadb 10.0 or mysql
	4.redis
	5.windws集成环境推荐使用UPUPW,下载地址：http://www.upupw.net/,下载php7.0正式版64位，里面已经自带了redis64位版，很方便
        
#环境设置及必须的配置
	1. php需要打开pathinfo模块，并配置好error_log<br>
	2. nginx根据本项目根目录下提供的nginx.conf来配置,测试时建议设置nginx虚拟主机，域名使用www.test.ez
	3. windows下，打开c:/windows/system32/drivers/etc/hosts文件，加入映射:127.0.0.1 www.test.ez
	4. 所有数据表必须设定主键，并且主键名统一是"id"
	5. 所有字段必须有注释，且格式为："字段名|数据类型|详细注释",其中"字段名|数据类型"是必须的，数据类型有8种：
	email,mobile,tel,zip,int,double,str,text其中int就表示mysql中所有的int型,double就包括了mysql中所有的浮点型，str
	表示的是所有字符型,text就对应了text类型。这8种数据类型对应了config/dbfield_rule.php中定义的验证规则，在后面自动生成的model中，有一
	个验证字段方法会用到这些定。
        6. public/index.php里面有关于cookie所在域的设定，请修改为你本地测试用的域名

#项目入口
	项目入口只有根目录/public，这里唯一的入口文件是index.php,所以在nginx里定义项目根目录时，要指定到public目录
		
#项目基本例子说明

	按照上面的说明配置好目录后，访问"http://www.test.ez/"，将会出现"欢迎使用EzMvcPHP"，表示项目部署成功，实际上这里执行了app/Index/Controller/
	
	IndexController类的index方法，路由是根据根目录下的config/router/router.php配置的路由访问到的，在控制器里通过$this-display()方法访问到
	
	app/Index/View/index.php页面。display方法没有带参数的时候，默认会访问同一个模块下的View下面的与控制器类同名的页面
	
#配置文件的读取

	使用PubFuc::config('配置文件名')即可读取位于app/config目录下的配置文件，如读取数据库配置：PubFuc::config('db'),路由的配置写法比较特殊，可以
	参考后面得路由说明部分，其它的配置就可以参考数据库配置的写法。
		
#项目基本结构说明
	基本的流程是入口->路由->控制器->Logic->model
							   |->view
	顺序是：controller调用logic,logic调用model,中间这层主要是当逻辑比较复杂，而且有可能复用的时候，封住在logic类里，利于controller的重复调用。当然
	如果程序逻辑很简答的话，可能连model,logic都不需要，直接在controller里面用PdoHelper类操作数据库就行了，更甚至不需要controller，在路由的闭包函数
	里面直接写代码（参考后面得路由说明部分）
	
	app目录:放置了controller,model,logic,view相关的程序文件，还有一个inject目录，这个目录放置的是在控制器执行
	或执行后运行的代码app下的目录除了Model,Logic,Inject目录外，剩下的都是模块目录，都对应了路由的设置，比如当前
	app下面就有Index和Test两个模块目录，路由配置里面的'call'=>'Index/Index/index',call的值对应的是:
	模块/控制器类名(不带Controller)/方法。
	
	config目录: 放置了配置文件，其中:
	
		1. router目录里放置路由相关的配置,
			(1)main.php里面用于记录配置了那些路由，每新增一个路由文件，都要在这里添加一下，比如当前目录下还有两个路由文件
				   router.php和test.php，所以在main.php里面定义了两个元素。
			(2)router.php文件记录了基本的路由规则
			(3)test.php文件记录了用于测试的一些路由规则
			
		2. db.php定义了数据库配置
		
		3. dbfield_rule.php定义了表字段验证正则表达式
		
		4. inject.php定义了控制器执行前和执行后需要运行的程序的位置
                        
	public目录：放置入口文件，还有js,css,图片。
	
	boot.php: 核心文件，主要是进行路由的处理，还有一些常量，配置的定义
	
	db_demo_ezmvcphp.sql:测试用的数据库
	
	nginx.conf: 配置例子
        
#路由说明
	
	注意：当前路由都放在app/config/router,请不要修改这个目录名,只需要在其下增加路由规则即可，main.php也不需要做任何修改，只需要增加现有数组的元素即可。
	
	main.php:
	return array(
		'router',
		'test'
	);
	
	router.php:
	return array(
		'/'=>array(
			'method'=>'GET',
			'call'=>array(
				'www'=>'Index/Index/index'
			)//针对子域名的设置，默认子域名是www,只有首页需要这样配置
		),
		'createmodel'=>array(
			'method'=>'GET',
			'call'=>'Test/CreateModel/createModel'
		),
		'testcall'=>array(
			'method'=>'GET',
			'call'=>function(){
				echo '回调函数测试';exit;
			}
		)
	);
	main.php文件主要用于记录配置了哪些路由文件，当前项目中配置了router.php和test.php两个路由文件，如果新增一个user.php配置文件，那么就新增
	一个元素：

	 return array(
		'router',
		'test',
		'user'
	);
	同时，main.php文件也是为了合并多个路由文件而存在的，比如在多人合作项目中，每个人可以定义各自的路由文件，而不会冲突。
	
	router.php记录了具体的路由规则。
	'/',表示首页，method表示请求的方式，包括GET,POST,PUT,DELETE，用大写，如果定义的是POST请求，而实际请求用的是GET方式，是会请求不到数据的
	，相当于restful的简单实现。
	
	call表示路由要执行的逻辑，有3种情况:
	
	1.数组，只有默认的router.php文件中的"/"配置会出现数组，这是为了实现子域名的配置，默认是匹配www,假如你有一个子域名user.test.ez需要访问到app/User模块，那么就要在www
	  后面增加一个元素'user'=>'User/Index/index',那么当你访问user.test.ez时就会执行User模块下的IndexController的indx方法。
	  '/'=>array(
			'method'=>'GET',
			'call'=>array(
				'www'=>'Index/Index/index',//www.test.ez
				'user'=>'User/Index/index'//user.test.ez
			)//针对子域名的设置，默认子域名是www,只有首页需要这样配置
		),
	  
	2.字符串，这种是最常用的，比如本例中的createmodel里面的call,格式是：模块名/控制器名/方法名
	
	3.回调函数,比如本例中的testcall，它的call直接赋值了一个function,当访问www.test.ez/testcall的时候，将会直接输出"回调函数测试"这6个字。
	
	路由的URL地址解析规则，如：
	http://www.test.ez/user/id/10,这个地址中，user表示路由标记，/id/10相当于?id=10,会保存到$_GET中，使用$_GET['id'],可以取到10，在本框架中
	,只有user这个位置是作为路由标记的，也是路由配置匹配的根据，不能出现多个"/",user后面的位置默认是用来传参的，数量必须是偶数的，比如:
	http://www.test.ez/user/id/10/name,这样是不行的，会报错，正确的应该是:http://www.test.ez/user/id/10/name/test，这时就向$_GET中保存了
	两个参数。
	
	路由可配置看起来有点繁琐，但是实际上有它的灵活性，比如：假如某个请求要换一个控制器来处理 ，那么只要在路由修改相应的配置，而不需要去修改页面上的请求url地址。
		
#Model说明
	
	使用默认的http://www.test.ez/createmodel访问项目，将会自动在app/Model下生成对应数据库表对应的model,也可以指定只生成指定表的model，每个model都继承自Basemodel，里面封装了常用的
	数据操作方法，BaseModel又调用了PdoHelper来进行数据操作，PdoHelper就是直接操作数据表的代码的封住，在controller,logic里面都是可以直接调用的，只是不建议这么做。
	
	生成的model，内容包括当前的字段，主键，字段验证规则，用于测试的插入数据$testData，以及用于测试的插入方法insertTest()。
	
	同时在BaseModel中还定义了自动按照数据库字段规则验证数据数组的方法validateDbField()，在insertTest()方法中，在数据插入之前就调用了这个方法，以保证数据字段值的正确性。主要是通过
	数据表注释中标识的数据类型与app/config/dbfield_rule.php中定义的规则关联起来，对需要验证的数据库字段进行检查。要实现这个功能，请记得说明文档一开始"环境设置及必须的配置"中提到
	的注释的规则，请严格按照规则创建表字段。可以参考model类中的insertTest可以参考model类中的insertTest()方法。
	
	事务操作，可以参考app/Model目录下的TransactionDemoModel类，这是一个事务操作的示例。
	
	PdoHelper类主要是对PDO操作数据库的封住，逻辑都比较简单，可以直接看看代码，都有注释。
	
	可以参考当前项目下面的app/Model下的3个Model类，写了一些示例。
	
#Logic说明
	
	这相当于是model与controller的中间层，其实也是可以在controller直接使用model的，不过，建议逻辑比较复杂，且重用性高的时候，还是封住一层logic类，这样controller就可以重复利用
	
#Controller说明
	主要负责各种请求的接受参数的处理，负责页面的接入，及请求跳转，复杂逻辑可以封住到logic。
	
	使用$this->setVariable()方法注入变量到模板。
	
	使用$this->display()方法接入模板，控制器需要载入的模板请都放在与当前控制器同级目录下View目录下，再用控制器名作为目录名来区分。
	1.当display不传参数的时候，表示：
	路由规则是User/Index/login,表示User模块的IndexController类的login方法，其中调用了$this->display()方法，那么模板文件应该放在User/View/Index目录下，模板名应与方法名同名:login.php,目录结构就像这样:
	User/View/Index/login.php
	
	2.当display传参数的时候，如 $this->display('User/index'),这种情况一般是用于需要接入与方法名不同名的模板,注意目录名的大小写,表示:
	路由规则是User/Index/login,表示User模块的IndexController类的login方法，其中调用了$this->display('User/index')方法，那么模板文件应该放在User/View/User目录下，模板名应与方法名同名:index.php,目录结构就像这样:
	User/View/User/index.php
	
	使用$this->redirect(string $url)方法可以实现url请求，传入的参数就是要请求的url地址，如:$this->redirect('http://www.test.ez')。
	
	在app/Inject目录下，还有两个控制器，一个是预处理器PreController,一个是后置处理器AfterController,用于在一个控制器流程的前后插入程序，比如权限控制的时候，可以在PreController里面判断当前访问的是哪个模块哪
	哪个控制器，并加以控制。
	
	当前项目下的Index模块和Test模块有一些控制器示例，可以参考一下。
	
#View说明

	模板直接使用php原生的用法，没什么特别需要说明的，可以参考app/Index/View/Index/index.php
	
#demo说明

	首页demo: http://www.test.ez
	
	事务插入数据: http://www.test.ez/testuser  这个示例可以用于向示例数据库添加测试数据，两个表连续插入数据，并使用了事务
	
	多表查询: http://www.test.ez/testusu
	
	分页: http://www.test.ez/testpage
	
#返回值统一说明
	
	本项目中，所有的数据返回值都采用了数组的方式，array('status'=>'1.成功 2.失败','result'=>'结果集：字符，数字，数组等','msg'=>'提示信息'),可以通过PubFunc::returnArray($status,$result,$msg)来封住一个
	返回信息。主要是为了统一返回的信息，并且方便转换为json字符串，最终返回到前端页面处理。