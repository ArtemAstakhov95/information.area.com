/**
 * Created by gena on 27.01.2016.
 */

$(document).ready(function(){

    $('.panel-open').click(function(){
        $('.side-bar').animate({
            right:'0px'
        }, 300);
        $('.panel-open').hide();
    });
    $('.close-panel').click(function(){
        $('.panel-open').show();
        $('.side-bar').animate({
            right:'-300px'
        }, 300);
    });

    $('.select-concept-button').click(function(){
        if((window.getSelection || document.getSelection || document.selection) || ($('#concept').val() != '')){
            if(window.getSelection) {
                if(window.getSelection().toString() != ''){
                    txt = window.getSelection().toString();
                }
                else if($('#concept').val() != '')
                    txt = $('#concept').val();
            }
            else if(document.getSelection) {
                if(document.getSelection() != '')
                    txt = document.getSelection();
                else if ($('#concept').val() != '')
                    txt = $('#concept').val();
            }
            else if(document.selection) {
                if(document.selection.createRange().text != '')
                    txt = document.selection.createRange().text;
                else if ($('#concept').val() != '')
                    vtxt = $('#concept').val();
            }
            if(txt.length != 0) {
                $('#concept').val(txt);
                if(! $('.concept-fields').length) {
                    var data = {
                        'method1': 'getConceptClass'
                    };
                    $.ajax({
                        url: '/Redirect.php',
                        data: 'selection=' + JSON.stringify(data),
                        type: 'post',
                        success: function (output) {
                            var selec = JSON.parse(output);
                            var div = '<div class="concept-fields"><select id="conceptClass"><option>Клас поняття</option>';
                            for (var i = 0; i < selec.DBselect[0].ConceptClass.length - 1; i++) {
                                div += '<option>' + selec.DBselect[0].ConceptClass[i].class + '</option>';
                            }
                            div += '<input type="number" placeholder="рік початку" id="year-start">' +
                            '<input type="number" placeholder="місяць початку" id="month-start">' +
                            '<input type="number" placeholder="день початку" id="day-start">' +
                            '<input type="number" placeholder="рік завершення" id="year-end">' +
                            '<input type="number" placeholder="місяць завершення" id="month-end">' +
                            '<input type="number" placeholder="день завершення" id="day-end">';
                            div += '</select><input type="submit" value="Додати поняття" id="add-concept-button"></div>';
                            $('.add-concept').append(div);
                            $('.add-concept').css("border", "1px solid grey");
                            $('.add-concept').css("padding", "6px");
                        }
                    });
                }
            }
        }
    });

    $('.add-concept').on("click", "#add-concept-button", function(){
        if($('#conceptClass').val() != 'Клас поняття') {
            if($('#concept').val() != '') {
                var data = {
                    'method': 'addConcept',
                    'concept': $('#concept').val(),
                    'class': $('#conceptClass').val(),
                    'dayStart': $('#day-start').val(),
                    'monthStart': $('#month-start').val(),
                    'yearStart': $('#year-start').val(),
                    'dayEnd': $('#day-end').val(),
                    'monthEnd': $('#month-end').val(),
                    'yearEnd': $('#year-end').val()
                };

                $.ajax({
                    url:'/Redirect.php',
                    data:'insert='+JSON.stringify(data),
                    type:'post',
                    success:function(output){
                        $('.concept-fields').remove();
                        $('.add-concept').css("border", "none");
                        $('.add-concept').css("padding", "0");
                        $('#concept').val('');
                    }
                })
            }
            else
                alert('Заповніть поле поняття')
        }
        else
            alert('Виберіть клас поняття');
    });


    $('.select-these-button').click(function(){
        if((window.getSelection || document.getSelection || document.selection) || ($('#these').val() != '')){
            if(window.getSelection) {
                if(window.getSelection().toString() != ''){
                    txt = window.getSelection().toString();
                }
                else if($('#these').val() != '')
                    txt = $('#these').val();
            }
            else if(document.getSelection) {
                if(document.getSelection() != '')
                    txt = document.getSelection();
                else if ($('#these').val() != '')
                    txt = $('#these').val();
            }
            else if(document.selection) {
                if(document.selection.createRange().text != '')
                    txt = document.selection.createRange().text;
                else if ($('#these').val() != '')
                    vtxt = $('#these').val();
            }
            if(txt.length != 0) {
                $('#these').val(txt);
                if(! $('.these-fields').length) {
                    var data = {
                        'method1': 'getTheseClass'
                    };
                    $.ajax({
                        url: '/Redirect.php',
                        data: 'selection=' + JSON.stringify(data),
                        type: 'post',
                        success: function (output) {
                            var selec = JSON.parse(output);
                            var div = '<div class="these-fields"><div id="concept-search-div"><input id="concept-search" type="text" placeholder="Поняття..."></div>' +
                                '<select id="theseClass"><option>Клас тези</option>';
                            for (var i = 0; i < selec.DBselect[0].TheseClass.length - 1; i++) {
                                div += '<option>' + selec.DBselect[0].TheseClass[i].class + '</option>';
                            }
                            div += '<input type="number" placeholder="рік початку" id="year-start">' +
                            '<input type="number" placeholder="місяць початку" id="month-start">' +
                            '<input type="number" placeholder="день початку" id="day-start">' +
                            '<input type="number" placeholder="рік завершення" id="year-end">' +
                            '<input type="number" placeholder="місяць завершення" id="month-end">' +
                            '<input type="number" placeholder="день завершення" id="day-end">';
                            div += '</select><input type="submit" value="Додати тезу" id="add-these-button"></div>';
                            $('.add-these').append(div);
                            $('.add-these').css("border", "1px solid grey");
                            $('.add-these').css("padding", "6px");
                        }
                    });
                }
            }
        }
    });

    $('.add-these').on("keyup", "#concept-search",function(e){
        if(e.keyCode == 8) {
            keyListener(e);
        }
    });

    $('.add-these').on("keypress", "#concept-search",function(e){
        keyListener(e);
    });

    function keyListener(e){
        var currentQuery = $('#concept-search').val();
        var latestQuery = '';
        if(e.charCode == 32 || (e.charCode >= 65 && e.charCode <= 90) || (e.charCode >= 48 && e.charCode <= 57) ||
            (e.charCode >= 97 && e.charCode <= 122) || (e.charCode >= 1040 && e.charCode <= 1103) || e.charCode == 1108 ||
            e.charCode == 1110 || e.charCode == 1111 || e.charCode == 1128 || e.charCode == 1130 || e.charCode == 1131 ||
            e.charCode == 1168 || e.charCode == 1169 || e.keyCode == 8){
            if(e.keyCode != 8) {
                latestQuery = currentQuery + String.fromCharCode(e.charCode);
            }
            else
                latestQuery = currentQuery;
            updateResults(latestQuery);
        }
    }

    function updateResults(latestQuery){
        if(latestQuery.length > 0){
            var d = {
                method:'autoComplete',
                str:latestQuery
            };
            $.ajax({
                url: '/Redirect.php',
                data:'autoComp='+JSON.stringify(d),
                type:'post',
                success:function(output){
                    var selec = JSON.parse(output);
                    if($('#search-result')){
                        $('#search-result').remove();
                    }
                    if(selec.SearchResult.length >= 1) {
                        var div = '<div id="search-result"><ul>';
                        for (var i = 0; i < selec.SearchResult.length ; i++) {
                            div += '<li><div class="search-result-li-div"><span>' + selec.SearchResult[i].concept + '</span><input type="hidden" value="'+selec.SearchResult[i].id+'"><input type="hidden" value="'+selec.SearchResult[i].year_start+'"><input type="hidden" value="'+selec.SearchResult[i].year_end+'"></div></li>';
                        }
                        div += '</ul></div>';
                        $('#concept-search-div').append(div);
                    }
                }
            })
        }
        else{
            if($('#search-result')){
                $('#search-result').remove();
            }
        }
    }


    $('.add-these').on('click', '#search-result li', function($this){
        $('#concept-search').val($this.currentTarget.childNodes[0].textContent);
        $('#concept-search').append('<input id="concept-id" type="hidden" value="'+$this.currentTarget.childNodes[0].childNodes[1].value+'">');
        $('#year-start').val($this.currentTarget.childNodes[0].childNodes[2].value);
        $('#year-end').val($this.currentTarget.childNodes[0].childNodes[3].value);
        $('#search-result').remove();
    });


    $('.add-these').on("click", "#add-these-button", function(){
        if($('#concept-search').val() != '') {
            if($('#these').val() != '') {
                if ($('#theseClass').val() != 'Клас тези') {
                    var data = {
                        'method': 'addThese',
                        'these':$('#these').val(),
                        'conceptId': $('#concept-id').val(),
                        'class': $('#theseClass').val(),
                        'page':window.location.href.toString().split(window.location.host)[1],
                        'dayStart': $('#day-start').val(),
                        'monthStart': $('#month-start').val(),
                        'yearStart': $('#year-start').val(),
                        'dayEnd': $('#day-end').val(),
                        'monthEnd': $('#month-end').val(),
                        'yearEnd': $('#year-end').val()
                    };

                    $.ajax({
                        url: '/Redirect.php',
                        data: 'insert=' + JSON.stringify(data),
                        type: 'post',
                        success: function (output) {
                            $('.these-fields').remove();
                            $('.add-these').css("border", "none");
                            $('.add-these').css("padding", "0");
                            $('#these').val('');
                        }
                    })
                }
                else
                    alert('Виберіть клас тези');
            }
            else
                alert('Заповніть поле поняття');
        }
        else
            alert('Виберіть клас поняття');
    });

});
