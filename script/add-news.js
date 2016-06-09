/**
 * Created by artem on 08.11.2015.
 */

$(document).ready(function(){
    $('#date').datetimepicker({
        inline: true
    });


    $('input[type=range]').nativeMultiple({
        stylesheet: "slider",
        onChange: function(first_value, second_value) {
            var input = $('input[type=range]');
            $('#date1 .date').val(input[0].value);
            $('#date2 .date').val(input[1].value);

        },
        onSlide: function(first_value, second_value) {
            var input = $('input[type=range]');
            $('#date1 .date').val(input[0].value);
            $('#date2 .date').val(input[1].value);

        }
    });



    $("#date1 .date").change(function(){
        var min = $('#min-year').val();
        var max = $('#max-year').val();
        var input = $('input[type=range]');
        var value1=$('#date1 .date').val();
        if(value1=='' || parseInt(value1) < parseInt(min)) {
            value1 = min;
            $('#date1 .date').val(value1);
        }
        var value2=$("#date2 .date").val();
        if(value2=='' || parseInt(value2) > parseInt(max)) {
            value2 = max;
            $("#date2 .date").val(value2);
        }
        if(parseInt(value1) > parseInt(value2)){
            value1 = value2;
            $("#date1 .date").val(value1);
        }
        input[0].value=value1;//,value2);
        input[1].value=value2;
    });


    $("#date2 .date").change(function(){
        var min = $('#min-year').val();
        var max = $('#max-year').val();
        var input = $('input[type=range]');
        var value1=$("#date1 .date").val();
        if(value1=='' || parseInt(value1) < parseInt(min)) {
            value1 = min;
            $("#date1 .date").val(value1);
        }
        var value2=$("#date2 .date").val();
        if(value2=='' || parseInt(value2) > parseInt(max)) {
            value2 = max;
            $("#date2 .date").val(value2);
        }

        //if (value2 > 1000) { value2 = 1000; $("#date2 .date").val(1000)}

        if(parseInt(value1) > parseInt(value2)){
            value2 = value1;
            $("#date2 .date").val(value2);
        }
        input[0].value=value1;
        input[1].value=value2;
    });



    $('#image').change(function(){
        if (this.value.lastIndexOf('\\')){
            var i = this.value.lastIndexOf('\\')+1;
        }
        else{
            var i = this.value.lastIndexOf('/')+1;
        }
        var filename = this.value.slice(i);
        var upload = document.getElementById('fileformlabel');
        upload.innerHTML = filename;
        $('#hidden-image').val(filename);
    });

    $('#options').on('click', '#view-range-btn' ,function(){
        if(parseInt($('#date1 .date').val()) != parseInt($('#current-min-year').val()) || parseInt($('#date2 .date').val()) != parseInt($('#current-max-year').val())){
            $('#current-min-year').val($('#date1 .date').val());
            $('#current-max-year').val($('#date2 .date').val());
            var json = {
                'method':'getPeriodData',
                'year_start':$('#current-min-year').val(),
                'year_end':$('#current-max-year').val()
            }

            $.ajax({
                url:'/Redirect.php',
                data:'insert='+JSON.stringify(json),
                type:'post',
                success:function(output){
                    if($('#range-title')){
                        $('#range-title').remove();
                    }
                    $('.range-title-div').append('<h2 id="range-title">Обраний період: '+$('#current-min-year').val()+' - '+$('#current-max-year').val()+'</h2>');
                    var result = JSON.parse(output);
                    if($('.intro-article')){
                        $('.intro-article').remove();
                    }
                    var p = '';
                    for(var i=0; i < result.pages.length; i++){
                        var v = '';
                        if(result.pages[i].year_end!="" || result.pages[i].year_end!=0){v=' - '+result.pages[i].year_end}
                        p += '<div class="intro-article"><a href="'+result.pages[i].code+'">' + result.pages[i].caption + '</a> <sub>('+result.pages[i].year_start+v+')</sub></div>';
                    }
                    $('.articles').append(p);
                    if($('.concepts-container .concept')){
                        $('.concepts-container .concept').remove();
                    }
                    for(var j = 0; j<result.concepts.length;j++){
                        var vv = '';
                        if(result.concepts[j].year_end!="" || result.concepts[j].year_end!=0){vv=' - '+result.concepts[j].year_end}
                        $('.concepts #'+result.concepts[j].class).append('<div class="concept"><a href="/concept/'+result.concepts[j].id+'">'+result.concepts[j].concept+'</a> <sub>('+result.concepts[j].year_start+vv+')</sub></div>');
                    }
                }
            })
        }
    });

    CKEDITOR.replace('content');

















































    $("#add-news-button").click(function(event){
        event.stopPropagation();
        event.preventDefault();
        var form = document.getElementById('upload-form');
        formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            contentType: false,
            processData: false,
            data: formData,
            success: function(output){
            }
        });
        var fileName = form[0].files[0].name;

        var tet = document.createElement('textarea');
        tet.innerHTML = CKEDITOR.instances.content.getData();
        var t = tet.value;

        var m = {
            'method':'exec_create',
            'code':$('#code').val(),
            'caption':$('#caption').val(),
            'intro':$('#intro').val(),
            'content':t,
            'date':$('#date').val(),
            'image':fileName,
            'main':$('#main-news').is(':checked') ? 1 : 0,
            'parentCode':$('#parentCode').val(),
            'aliasOf':$('#aliasOf').val()
        };

        var data ='crud='+JSON.stringify(m);
        $.ajax({
            url: '/Redirect.php',
            data: data,
            type: 'post',
            success: function(output){
                window.location.href='/';
            }
        });
    });

    $("#edit-news-button").click(function(event){
        event.stopPropagation();
        event.preventDefault();
        var form = document.getElementById('upload-form');
        formData = new FormData(form);
        $.ajax({
            url: form.action,
            type: form.method,
            contentType: false,
            processData: false,
            data: formData,
            success: function(output){
            }
        });
        var fileName = '';
        if(form[0].files[0])
            fileName = form[0].files[0].name;
        else
            fileName = form.childNodes[1].childNodes[1].textContent;

        var tet = document.createElement('textarea');
        tet.innerHTML = CKEDITOR.instances.content.getData();
        var t = tet.value;
        var m = {
            'method':'exec_edit',
            'code':$('#code').val(),
            'caption':$('#caption').val(),
            'intro':$('#intro').val(),
            'content':t,
            'date':$('#date').val(),
            'image':fileName,
            'main':$('#main-news').is(':checked') ? 1 : 0,
            'parentCode':$('#parentCode').val(),
            'aliasOf':($('#aliasOf').val() == '') ? null : $('#aliasOf').val()
        };
        $.ajax({
            url: '/Redirect.php',
            data: 'crud='+JSON.stringify(m),
            type: 'post',
            async: false,
            success: function(output){
                window.location.assign('/admin-view');
                $('.admin-view-tabel-div').append('<div class="pop-up-msg"><span>Стаття успішно відредагована</span></div>');
                setTimeout(function(){$('.pop-up-msg').fadeOut('fast')},2000);
            }
        });
    });




});
