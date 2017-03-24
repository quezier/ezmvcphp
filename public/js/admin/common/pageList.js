//拼接搜索条件
function getParam(curPage){
    if(typeof(curPage) == 'undefined' || curPage == '' || curPage == null){
        curPage = 1;
    }
    var str = $("form").serialize()+"&p="+curPage;
    return filterParam(str);
}

//过滤请求参数,主要去掉空参数,合并checkbox多先参数
function filterParam(param){
 
    var checkboxName = [];
    $("form :checkbox").each(function(){
        var attrName = $(this).attr('name');
        if(jQuery.inArray(attrName,checkboxName)<0){
            checkboxName.push($(this).attr('name'));
        }
    });

    var checkboxStr ='';
    $.each(checkboxName,function(k,v){
        var obj = $("input[name="+v+"]");
        var st = []
        for(var i=0; i < obj.length ; i++){
            if(obj.eq(i).prop("checked")){
                st.push(obj.eq(i).val());
            }
        }
        if(st.length > 0){
            checkboxStr += '&' + v +"=" + st;
        }
    })

    //console.log(checkboxName);
    
    var result = '';
    var string = param.split('&');
    for(i in string){
        var str1 = string[i].split('=');
        if(str1[1]!='' && jQuery.inArray(str1[0],checkboxName) < 0 && str1[0].indexOf('_submit') < 0){        
            result = str1[0]+'=' + str1[1] + '&' + result;
        }
    }
    return result+checkboxStr;
}

//获取数据
function getData(strParam){
    var action = ACTION;  //填写接口地址
    var result = {};
    if( typeof(strParam) != 'undefined'){
        action = action+"?"+strParam;
    }
    $.ajax({
        url:action,
        async:false,
        type:'get',
        dataType:'json',
        data:{},
        success:function(data){
            if(data.status<0){
                swal(data.errorMsg,'','error');
            }
            result = data;
        }
    });
    return result;
}

//执行搜索
function doSearch(is){
    var str = getParam();
    var json = getData(str,is);
    if(json.status < 0){
        paging(0,PAGESIZE,turnPage,true);
        $("tbody[name=list]").html('');
        return false;
    }
    if(json.result==0)
    {
        $('.search-empty-wrap').show();
    }
    else {
        $('.search-empty-wrap').hide();
    }
    showTab(json);
    if(is){
        paging(json.result.total,PAGESIZE,turnPage,true);

    }else{
        $('.modal-trigger').leanModal();  //再次加载弹框效果
        paging(json.result.total,PAGESIZE,turnPage,false);
    }
    cancelCheckAll();
}doSearch(1);

//渲染表格列表
function showTab(list){
    var html = template("list",list);
    $("tbody[name=list]").html(html);
    $('.dropdown-button').dropdown();
}

//渲染分页
function generateData(number) {
        var result = [];
        for (var i = 1; i < number + 1; i++) {
            result.push(i);
        }
        return result;
};

function paging(total,size,func,isCallBack,pageNum){
    var isFirst = 0;
    if($('.pag-wrap').length) {
        if(!isCallBack){ $('.pag-wrap').pagination('destroy');}
        $('.pag-wrap').pagination({
            dataSource: generateData(parseInt(total)),
            pageSize: size,
            showGoInput: true,
            showGoButton: true,
            pageNumber:pageNum,
            header:'<div class="pagination-info">共<%= totalNumber %>条记录，<%= currentPage %>/<%= totalPage %>页</div>',
            formatGoButton:"<button class='waves-effect waves-light btn btn-small cyan J-paginationjs-go-button'>Go</button>",
            go:function(number, callback)
            {
                alert(number);
            },
            callback: function(data, pagination) {
                var p = $(".pag-wrap .active").attr('data-num');
                if(isFirst != 0){
                    func(p);
                }
                isFirst++;
            }
        });
    }
}

//分页按钮效果   
function turnPage(p){
    var str = getParam(p);
    var json = getData(str);
    if(json.result==0)
    {
        $('.search-empty-wrap').show();
    }
    else {
        $('.search-empty-wrap').hide();
    }
    showTab(json);
    cancelCheckAll();
}

//取消全靠状态
function cancelCheckAll(){
    if($("#checkAll").length > 0){
        $("#checkAll").prop("checked",false);
    }
}