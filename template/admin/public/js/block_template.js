/**
 * 板块楼层模板
 * @type {{data: {text: {}, adv: {}, product: {}, product_category: {}, brand: {}}, curr_field_type: string, curr_field_name: string, layer_open_index: number, init: block.init, refreshHtml: block.refreshHtml, bindEdit: block.bindEdit, setData: block.setData}}
 */
var block = {
    data: {
        text: {},
        adv: {},
        product: {},
        product_category: {},
        brand: {}
    },
    curr_field_type: "",
    curr_field_name: "",
    layer_open_index : 0,
    is_open_pop_up : false,//是否已打开弹出框，防止重复弹出
    init : function(){
        if(session_data) {
            this.data = session_data;
        }else{
            var self = this;
            //找到模板中可编辑的元素，并且标记
            $("[data-block-type]").each(function (i) {
                var type = $(this).attr("data-block-type");
                var name = $(this).attr("data-block-name");
                self.data[type][name] = {};
            });
        }
        this.bindEdit();
    },

    //刷新界面
    refreshHtml : function () {
        var self = this;
        console.log($("select[name='block_template']").val());
        if($("select[name='block_template']").val()) {
            $.ajax({
                type: "post",
                url: ADMINMAIN+'/block/loadBlock',
                dataType: 'json',
                data: {data: JSON.stringify(block.data), block_template: $("select[name='block_template']").val() },
                success: function (res) {
                    $(".block-main").html(res).show();
                    self.bindEdit();
                }
            });
        }else{
            $(".block-main").hide();
        }
    },

    //绑定编辑监听
    bindEdit: function () {

        var self = this;

        //找到模板中可编辑的元素，并且标记
        $("[data-block-type]").each(function (i) {
            var type = $(this).attr("data-block-type");
            var name = $(this).attr("data-block-name");
            var width = $(this).outerWidth();
            var height = $(this).outerHeight();
            var top = $(this).position().top;
            var left = $(this).position().left;
            var position = $(this).css("position");
            var margin_left = parseFloat($(this).css("margin-left").toString());
            var span_width = 100;
            var span_height = 22;
            var xy = "";
            var type_edit_text = "";
            if(type == "text"){
				type_edit_text = "编辑文本";
            }else if(type == "product_category"){
				type_edit_text = "编辑商品分类";
            }else if(type == "product"){
				type_edit_text = "编辑商品";
			}else if(type == "adv"){
				type_edit_text = "编辑广告图";
			}else if(type == "brand"){
				type_edit_text = "编辑品牌";
			}

            if(/^(relative|absolute)$/.test(position)){
                xy = "top:" + 0 + "px;right:" + 0 + "px;";
            }else{
                var l = width + margin_left - span_width;//公式：可编辑的宽度 + 左外边距 - 编辑按钮宽度
                xy = "top:" + (top-0) + "px;left:" + l + "px;";
            }

            var style = "style=" + xy + "width:" + span_width + "px;height:" + span_height + "px;";
            var html = '<div class="edit-block" ' + style + ' data-block-name="' + name + '" data-block-type="' + type + '">';
            html += '<span><i class="layui-icon layui-icon-edit"></i>' + type_edit_text + '</span>';
            html += '</div>';
            // console.log($(this).position(),$(this).offset(),$(this).css("position"));

            $(this).append(html);
        });

        //加载文本、产品分类、产品、广告、品牌等编辑弹出框
        $(".edit-block span").click(function () {
            var type = $(this).parent().attr("data-block-type");
            var name = $(this).parent().attr("data-block-name");
            self.curr_field_type = type;
            self.curr_field_name = name;
            //console.log("当前编辑的字段：", type, name);

            if(!self.is_open_pop_up) {
                self.is_open_pop_up = true;
                switch (type) {
                    case "text":
                        $.post(ADMINMAIN+"/Block/textPopUp", {data: JSON.stringify(self.data[type][name])}, function (str) {
                            self.layer_open_index = layer.open({
                                title: "文本编辑",
                                type: 1,
                                content: str,
                                skin: 'text-pop-up',
                                area: '350px',
                                resize: false,
                                success: function () {
                                    self.is_open_pop_up = false;
                                }
                            });
                        });
                        break;

                    case "product_category":
                        $.post(ADMINMAIN+"/Block/productCategoryPopUp", {data: JSON.stringify(self.data[type][name])}, function (str) {
                            self.layer_open_index = layer.open({
                                title: "选择产品分类",
                                type: 1,
                                content: str,
                                skin: 'product-category-pop-up',
                                area: '350px',
                                resize: false,
                                success: function () {
                                    self.is_open_pop_up = false;
                                }
                            });
                        });
                        break;

                    case "product":
                        var area = ["510px", "237px"];
                        if (self.data[type][name] && self.data[type][name].product_source == "product_diy") area = ["900px", "710px"];
                        $.post(ADMINMAIN+"/Block/productPopUp", {data: JSON.stringify(self.data[type][name])}, function (str) {
                        	self.layer_open_index = layer.open({
                                title: "选择产品",
                                type: 1,
                                content: str,
                                skin: 'product-pop-up',
                                area: area,
                                resize: false,
                                success: function () {
                                    self.is_open_pop_up = false;
                                }
                            });
                        });
                        break;

                    case "adv":
                        self.layer_open_index = layer.open({
                            title: "编辑图片",
                            type: 2,
                            content: ADMINMAIN + "/Block/advPopUp?data="+JSON.stringify(self.data[type][name]),
                            skin: 'text-pop-up',
                            area: ['750px', '550px'],
                            resize: false,
                            success: function () {
                                self.is_open_pop_up = false;
                            }
                        });
                        break;

                    case "brand":
                        $.post(ADMINMAIN + "/Block/brandPopUp", {data: JSON.stringify(self.data[type][name])}, function (str) {
                            self.layer_open_index = layer.open({
                                title: "选择品牌",
                                type: 1,
                                content: str,
                                skin: 'brand-pop-up',
                                area: '350px',
                                resize: false,
                                success: function () {
                                    self.is_open_pop_up = false;
                                }
                            });
                        });
                        break;
                }
            }
        });
    },

    //设置数据，刷新界面
    setData : function(obj){
        this.data[this.curr_field_type][this.curr_field_name] = obj;
        this.refreshHtml();
    }

};

block.init();