/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Pace.on("start", function(){
    $("div.locked-pace").show();
});

Pace.on("done", function(){
       $("div.locked-pace").hide();
});


optionsDatePicker = {
    language: 'es',
    autoclose: true,
    format: 'dd/mm/yyyy'
};

optionsTimePicker = {
    "defaultTime": "00:00:00",
    "showMeridian": false,
    "showInputs": true
};

$(document).ready(function(){
    
    $("[data-toggle=tooltip]").tooltip({
        container: "body"
    });
    
    $("[data-toggle=popover]").popover({
        container: "body"
    });
   
    
    $(".datepicker").datepicker(optionsDatePicker);
    
});

function initTooltip()
{
    $("[data-toggle=tooltip]").tooltip({
        container: "body"
    });
}

function resetForm(form) {
    $("#"+form)[0].reset();
}

/**
 * Inicia los datepicker 
 *
 */
function initDatePicker(options) {
    if(options == null) {
        settings = optionsDatePicker;
    } else {
        settings = $.extend({}, optionsDatePicker, options);   
    }
    $(".datepicker").datepicker(settings);
}

/**
 * Crea un mensaje
 */
function createAlert(type, title, content, time)
{
   
   if(type == null) {
       alert("Indica el tipo de mensaje: success, danger, warning, info");
       return;
   }
   if(time == null) {
       time = 3000;
   }
   if(content == null) {
       content = "<i class='fa fa-clock-o'></i> <i>Hace 1 segundo...</i>";
   }
   switch(type) {
       case "danger":
           if(title == null) {
               title = "Ha ocurrido un error al realizar la operación";
           }
           optionsMessage = {
               title: title,
               content: content,
               color: "#c26565",
               icon: "fa fa-warning bounce animated",
               timeout: time
           };

       break;

       case "success":
           if(title == null) {
               title = "El proceso se realizo satisfactoriamente.";
           }
           optionsMessage = {
               title: title,
               content: content,
               color: "#5F895F",
               icon: "fa fa-check bounce animated",
               timeout: time
           };
       break;

       case "warning":
           
       break;

       case "info":
           
       break;

   }

    $.bigBox(optionsMessage);
} //Fin crear mensaje

function getParent(element, selector) {
    if(element == null) {
        alert("Indica el elemento");
        return;
    }
    if(selector == null) {
        alert("Indica la propiedad para seleccionar");
        return;
    }
    return element.parents(selector).eq(0);
}

function generateRandom() {
    number =   setInterval(function() {
        var number = 1 + Math.floor(Math.random() * 6);
        return number;
      },
      1000
    );
    
    return number;
}

function loadOptionsSelect(url, data, select) {
    $.ajax({
        type: 'GET',
        url: url,
        data: data,     
        success: function(data){
            $("#"+select).html("");
            $("#"+select).append('<option value="">Seleccione...</option>');
            $.each(data.items, function(i,item){
                $("#"+select).append('<option value="'+item.id+'">'+item.name+'</option>');
                $("#"+select).change();
            });                        
        }
    });
}

