//表单验证插件 by yindingsheng
//vtype
var LANG_Validate={
    'required':'本项必填',
    'number':'请录入数值',
    'digits':'请录入整数',
    'unsignedint':'请录入正整数',
    'unsigned':'请输入大于等于0的数值',
    'positive':'请输入大于0的数值',
    'alpha':'请输入英文字母',
    'alphaint':'请输入英文字母或数字',
    'alphanum':'请输入英文字母,中文及数字',
    'date':'请录入日期，格式yyyy-mm-dd',
    'email':'请录入正确的Email地址',
    'url':'请录入正确的网址',
    'mobile':'请录入正确的手机号码',
    'tel':'请录入正确的固定电话',
    'phone':'请录入正确的电话或手机',
    'zip':'请录入正确的邮编',
    'area':'请选择完整的地区',
    'greater':'不能小于前一项',
    'requiredonly':'必须选择一项'
};

var validatorMap = {
    'required': {
        'msg':LANG_Validate['required'], 
        'func': function(element, v) {
                    return v != null && v != '' && v.trim() != '';
                }
    },
    'number': {
        'msg':LANG_Validate['number'], 
        'func': function(element, v) {
                    return v == null || v == '' || ! isNaN(v) && ! /^\s+$/.test(v);
                }
    },
    'digits': {
        'msg':LANG_Validate['digits'], 
        'func': function(element, v) {
                    return v == null || v == '' || ! /[^\d]/.test(v);
                }
    },
    'unsignedint': {
        'msg':LANG_Validate['unsignedint'], 
        'func': function(element, v) {
                    return v == null || v == '' || (!/[^\d]/.test(v) && v > 0);
                }
    },
    'unsigned': {
        'msg':LANG_Validate['unsigned'], 
        'func': function(element, v) {
                    return v == null || v == '' || (!isNaN(v) && ! /^\s+$/.test(v) && v >= 0);
                }
    },
    'positive': {
        'msg':LANG_Validate['positive'], 
        'func': function(element, v) {
                    return v == null || v == '' || (!isNaN(v) && ! /^\s+$/.test(v) && v > 0);
                }
    },
    'alpha': {
        'msg':LANG_Validate['alpha'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^[a-zA-Z]+$/.test(v);
                }
    },
    'alphaint': {
        'msg':LANG_Validate['alphaint'], 
        'func': function(element, v) {
                    return v == null || v == '' || ! /\W/.test(v) || /^[a-zA-Z0-9]+$/.test(v);
                }
    },
    'alphanum': {
        'msg':LANG_Validate['alphanum'], 
        'func': function(element, v) {
                    return v == null || v == '' || ! /\W/.test(v) || /^[\u4e00-\u9fa5a-zA-Z0-9]+$/.test(v);
                }
    },
    'date': {
        'msg':LANG_Validate['date'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^(19|20)[0-9]{2}-([1-9]|0[1-9]|1[012])-([1-9]|0[1-9]|[12][0-9]|3[01])$/.test(v);
                }
    },
    'email': {
        'msg':LANG_Validate['email'], 
        'func': function(element, v) {
                    return v == null || v == '' || /(\S)+[@]{1}(\S)+[.]{1}(\w)+/.test(v);
                }
    },
    'mobile': {
        'msg':LANG_Validate['mobile'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^0?1[3458]\d{9}$/.test(v);
                }
    },
    'tel': {
        'msg':LANG_Validate['tel'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^(0\d{2,3}-?)?[23456789]\d{5,7}(-\d{1,5})?$/.test(v);
                }
    },
    'phone': {
        'msg':LANG_Validate['phone'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^0?1[34578]\d{9}$|^(0\d{2,3}-?)?[23456789]\d{5,7}(-\d{1,5})?$/.test(v);
                }
    },
    'zip': {
        'msg':LANG_Validate['zip'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^\d{6}$/.test(v);
                }
    },
    'url': {
        'msg':LANG_Validate['url'], 
        'func': function(element, v) {
                    return v == null || v == '' || /^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*)(:(\d+))?\/?/i.test(v);
                }
    },
};

$.fn.svalidate = function(is_self) {

    if(is_self){
        var felements = this;
    }else{
        var felements = this.find('[vtype]');
    }
    var flag = 1; //1:成功 0:失败
    felements.each(function(i,obj){
		if(flag == 0 ){
			return false;
		}
        obj = $(obj);
        var vtype = obj.attr('vtype');
        
        var valiteArr = vtype.split('&&');

        var _notice;

        $(valiteArr).each(function(vi,element){
            _notice = obj.next('.error_validate');

            if (validatorMap[element]['func'](obj, obj.val())) {
                if (_notice && _notice.hasClass('error_validate')) {
                    _notice.remove();
                }
                return true;
            }else{
                flag = 0;
                if(_notice && _notice.hasClass('error_validate')) return false;
                var err_span = document.createElement("span");
                $(err_span).attr('class','error_validate glyphicon glyphicon-remove-sign');

                if($('#alert-danger')){
                    $('#alert-danger').html(validatorMap[element]['msg']);
                    $('#alert-danger').removeClass('hide');
                }

                $(err_span).insertAfter(obj);

                obj.blur( function(){
                    var op ={'self':true};
                    obj.svalidate(op);
                });

                return false;
            }
        });

        
        

    });

    if(flag ===0){
        $(this).attr('validate','false');
        return false;
    }

    $(this).attr('validate','true');
    return true;
    
}