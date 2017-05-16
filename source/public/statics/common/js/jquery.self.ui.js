var UiSelector = function(el,option){
        var _this = this;
        var obj= $(el); //容器
        var api = obj.attr('api'); //api名
        var limit = obj.attr('limit')?obj.attr('limit'):10; //每页显示
        var value = obj.attr('value'); //已选择值
        var filter = obj.attr('filter'); //过滤条件
        var pk = obj.attr('pk'); //主键


        if(!globalBaseurl){
            alert('缺少globalBaseurl');
            return;
        }
        var url = globalBaseurl+"adminUi/selector";

        _this.postData = 'api='+api+'&limit='+limit+'&request_uri='+url+'&'+filter;
//        if(pk && value){
//            _this.postData += '&value='+value+'&pk='+pk;
//        }
        

        _this.init = function(postData){
            if(!postData){
                postData = _this.postData+'&value='+value+'&pk='+pk;
            }else{
                postData += '&value='+value+'&pk='+pk;
            }

            $.post(url,postData,
            function(rs){
                obj.html(rs);
            },'html');
        }

        //分页按钮点击事件
        $(obj).on('click','.j_pager',function(e){
            var postData = _this.postData+"&pageno="+$(e.target).attr('pageno');
            _this.init(postData);
        });

        //右移按钮点击事件
        $(obj).on('click','.j_toright',function(e){
             var right_group = $(obj).find('.j_right_group');
             $(obj).find('.j_left_li').each(function(i,o){
                  if($(o).hasClass('active')){
                        value += ','+$(o).attr('value');

                        obj.value = value;

                        $(o).removeClass('j_left_li');
                        $(o).removeClass('active');
                        $(o).addClass('j_right_li');
                        right_group.append($(o));
                  }
             });
        });

    };
