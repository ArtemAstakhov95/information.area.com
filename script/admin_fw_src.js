/**
 * Created by artem on 08.03.2016.
 */

$(document).ready(function() {
    $('#edit_date').datetimepicker({
        inline: true
    });


    $('#delete-news-icon').click(function(){
        if(confirm("Ви дійсно бажаєте видалити цю сторінку?")){
            location.href = $('#delete-href').val();
        }
    });
});