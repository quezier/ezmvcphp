<script>
    $('#modifyPwd').on('click', function () {
        var _content = "";
        _content = '<div style="background:#f2f2f2;width:700px;"><form id="form-mpwd"><div class="card-content" style="margin-left:100px"><div class="row hh-add-edit">'
            + '<dl class="col s12 m10"><dt><b>新密码</b></dt><dd><div class="col s10 m8"><input id="password" name="password" class="validate[required,minSize[6],maxSize[20]]" type="password"></div> </dd></dl>'
            + '<dl class="col s12 m10"><dt><b>确认密码</b></dt><dd><div class="col s10 m8"><input id="password1" name="password1" class="validate[required,minSize[6],maxSize[20]]" type="password"></div></dd></dl>'
            + '<dl class="col s12"><dd><a class="waves-effect waves-light btn pink lighten-2"  style="margin-left:100px" id="modify_btn" href="javascript:void(0);"><i class="fa fa-spinner fa-spin" style="display: none;"></i>提交</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="cancle" class="waves-effect waves-light btn blue-grey lighten-2" href="javascript:void(0);">取消</a></dd></dl></div></div></form></div>';
        var d = dialog({title: '修改密码', content: _content});
        d.showModal();
        $('.ui-dialog-close').css('display', 'none');
        $('#cancle').on('click', function () {
            setTimeout(function () {
                d.close().remove();
            }, 500);
        });

        $('#form-mpwd').validationEngine();
        $('#modify_btn').on('click', submitAdd);
        function submitAdd() {
            var pwd = $('#password').val();
            var repwd = $('#password1').val();
            if (pwd && repwd && pwd != repwd) {
                $('#password1').val('');
                swal("错误!", "两次输入的密码不一致", "error");
                return false;
            }
            if ($('#form-mpwd').validationEngine('validate')) {
                $('#modify_btn').children('i').css('display', 'block');
                $('#modify_btn').unbind('click');
                var param = $('#form-mpwd').serialize();
                $.ajax({
                    url: "<?php echo HTTP_DOMAIN . '/admin_modifyuserpwd';?>?" + param,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 1) {
                            swal("提示!", data.msg, "success");
                            location.href = "<?php echo HTTP_DOMAIN . '/'.MANAGE_ACCESS_NAME;?>";
                        }
                        else {
                            swal(data.msg);
                        }
                        $('#modify_btn').children('i').css('display', 'none');
                        $('#modify_btn').on('click', submitAdd);
                    }
                });
            } else {
                swal("错误!", "表单验证不通过!", "error");
            }
        }


    });
</script>
<script>

    $(function () {
        $.fn.serializeObject = function()
        {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
        $('#main-menu .first_menu .first_menu_btn').on('click', function (e) {
            if (!$(this).parent().hasClass('active'))
            {
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
            }
        });
        $('.sub-menu li').removeClass('active');
        $('.sub-menu li').each(function () {
            var eleHref = $(this).children('a').attr('href');
            var pathName = location.pathname;
            var pathNameArray = pathName.split('/');
            var matchPathName = pathNameArray[1];

            if("<?php echo !empty($_GET['last_url'])?$_GET['last_url']:'';?>")
            {
                matchPathName = "http://"+location.host+"/"+"<?php echo $_GET['last_url'];?>";
            }
            else {
                matchPathName = location.origin+'/'+matchPathName;
            }
            if (eleHref === matchPathName)
            {
                $(this).addClass('active');
                $(this).parent('ul').parent('li').addClass('expanded');
                $(this).parent('ul').parent('li').addClass('active');
            }

        });
        $('#btn_reset').on('click', function () {
            clearForm($('.search-form'));
            //location.reload();
        });
        function clearForm(form) {
              // iterate over all of the inputs for the form
              // element that was passed in
              $(':input', form).each(function () {
                    var type = this.type;
                    var tag = this.tagName.toLowerCase(); // normalize case
                    // it's ok to reset the value attr of text inputs,
                    // password inputs, and textareas
                    if (type == 'text' || type == 'password' || tag == 'textarea')
                          this.value = "";
                    // checkboxes and radios need to have their checked state cleared
                    // but should *not* have their 'value' changed
                    else if (type == 'checkbox' || type == 'radio')
                          this.checked = false;
                    // select elements need to have their 'selectedIndex' property set to -1
                    // (this works for both single and multiple select elements)
                    else if (tag == 'select')
                          this.selectedIndex = -1;
              });

            $('select', form).each(function () {
                var selectname = $(this).attr("name");
                $("#select2-" + selectname + "-container").text("请选择");
            });
        }
        $('.paginationjs-go-input').css('vertical-align','middle');
    });


</script>
