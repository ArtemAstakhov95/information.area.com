/**
 * Created by artem on 25.04.2016.
 */

$(document).ready(function(){
   $('.search-field-div').on('click', '#search', function ($this) {
        var fld = $this.currentTarget.previousElementSibling;
        window.location.href = '?'+fld.name+'='+fld.value;
   });
});