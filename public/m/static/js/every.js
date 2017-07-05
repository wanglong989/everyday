(function (w) {
    var vp = document.createElement("meta");
    vp.setAttribute("name", "viewport");
    vp.setAttribute("content", "width=" + (/ip(?=od|ad|hone)/i.test(navigator.userAgent) ? w : w + ",target-densitydpi=" + (w / (navigator.appVersion.indexOf("GT-I9100G") > -1 ? 480 : screen.width) * devicePixelRatio * 160)) + ",user-scalable=no");
    document.getElementsByTagName("head")[0].appendChild(vp);
})(750);


/**
 * 初始化
 */
var init = function () {

    var date = new Date();
    var lunar = calendar.solar2lunar(date.getFullYear(), date.getMonth() + 1, date.getDate());
    var gz = lunar.gzYear + '年' + '\&nbsp;\&nbsp;\&nbsp;' + lunar.IMonthCn + lunar.IDayCn;

    /**
     * 左 农历
     */
    $('#left').html(gz);

    /**
     * 右 日期
     */
    var yy = date.getFullYear(),
        mm = (date.getMonth() + 1) > 10 ? (date.getMonth() + 1) : '0' + (date.getMonth() + 1),
        dd = date.getDate() > 10 ? date.getDate() : '0' + date.getDate();
    var yearHtml = yy + '.' + mm;

    $('#year').html(yearHtml);
    $('#day').html(dd);


    //
    window.onload = function () {
        $(".js-generate").trigger("click");
    };
};
//初始化 日期
init();



$(document).on('click', '.js-generate', function () {

    var t = $(this);

    if(!t.hasClass('disabled')){
        t.addClass('disabled');

        var template = $('#template'),
            sectionWrap = $('.section-wrap'),
            mask = $('.mask');

        /**
         * 判断输入框中是否有自己的内容 如果有生成自己的内容
         */
        if($('#content').val() != ''){
            $('#contentP').html($('#content').val());
        }

        // 显示遮罩层
        mask.stop().show().animate({'opacity': '1'}, 0, function () {});

        //clone html处理生成图片
        sectionWrap.show();
        var wrapHtml = sectionWrap.clone();
        template.append(wrapHtml);

        var width = template.width(),
            height = template.height();

        //html2canvas HTML生成canvas；
        html2canvas(document.getElementById('template'), {
            width: width,
            height: height,
            useCORS: true,
            onrendered: function (canvas2) {

                // 通过 canvas 转化成 img base64 编码；
                var imgData = canvas2.toDataURL("image/jpeg", 1);
                var modal = $('.pic-modal'),
                    template = $('#template');
                mask.animate({'opacity': '0'}, 500, function () {
                    mask.hide();
                });
                // 处理
                template.empty();
                $('#templateImg').attr('src', imgData);
                sectionWrap.hide();


                if($('#content').val() != ''){
                    /**
                     * 上传图片
                     */
                    submitImageFile(imgData,t);
                }else{
                    t.removeClass('disabled');
                }
            }
        });
    }

});


/**
 * @param base64Codes
 * 图片的base64编码
 */
function submitImageFile(base64Codes,t){
    // var form = document.forms[0];

    //这里连带form里的其他参数也一起提交了,如果不需要提交其他参数可以直接FormData无参数的构造函数
    var formData = new FormData();

    //convertBase64UrlToBlob函数是将base64编码转换为Blob
    //append函数的第一个参数是后台获取数据的参数名,和html标签的input的name属性功能相同
    formData.append("userfile",convertBase64UrlToBlob(base64Codes));

    //ajax 提交form
    $.ajax({
        url : '/tool/imageUpload',
        type : "POST",
        data : formData,
        dataType:"text",
        processData : false,         // 告诉jQuery不要去处理发送的数据
        contentType : false,        // 告诉jQuery不要去设置Content-Type请求头
        success:function(data){

            /**
             * 成功之后处理事件
             * 存储数据库信息
             */
            addEveryDay(t,data);
        },
        xhr:function(){            //在jquery函数中直接使用ajax的XMLHttpRequest对象
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                    console.log("正在提交."+percentComplete.toString() + '%');        //在控制台打印上传进度
                }
            }, false);
            return xhr;
        }

    });
}

/**
 * 将以base64的图片url数据转换为Blob
 * @param urlData
 * 用url方式表示的base64图片数据
 */
function convertBase64UrlToBlob(urlData){

    var bytes=window.atob(urlData.split(',')[1]);        //去掉url的头，并转换为byte

    //处理异常,将ascii码小于0的转换为大于0
    var ab = new ArrayBuffer(bytes.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < bytes.length; i++) {
        ia[i] = bytes.charCodeAt(i);
    }

    return new Blob( [ab] , {type : 'image/jpg'});
}


function addEveryDay(t,result) {

    result = eval('('+ result +')');
    /**
     * 添加信息
     */
    var content = $('#content');

    $.ajax({
        type: 'post',
        url: '/add',
        data: {
            'content': content.val(),
            'pic':result.data.pic
        },
        dataType: 'json',
        async: true,
        success: function (data) {
            console.log(data);
            if(data.success){
                content.val('');
            }
            t.removeClass('disabled');
        }
    });
}

