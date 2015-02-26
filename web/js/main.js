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
function createMessage(type, text, time, position)
{
    if(type == null) {
        alert("Indica el tipo de mensaje: success, danger, warning, info");
        return;
    }
    switch(type) {
        case "danger":
            if(text == null) {
                text = "Ha ocurrido un error al realizar la operación";
            }
            if(position == null) {
                position = "messages";
            }
            if(time == null) {
                time = 8000;
            }
            icon = '<span class="glyphicon glyphicon-remove-sign"></span><strong> Error</strong> ';
        break;
        
        case "success":
            if(text == null) {
                text = "La operación se realizo con exito";
            }
            if(position == null) {
                position = "messages";
            }
            if(time == null) {
                time = 2000;
            }
            icon = '<span class="glyphicon glyphicon-ok-sign"></span><strong> Exito</strong> ';
        break;
        
        case "warning":
            if(text == null) {
                text = "";
            }
            if(position == null) {
                position = "messages";
            }
            if(time == null) {
                time = 3000;
            }
            icon = '<span class="glyphicon glyphicon-warning-sign"></span><strong> Advertencia</strong> ';
        break;
        
        case "info":
            if(text == null) {
                text = "";
            }
            if(position == null) {
                position = "messages";
            }
            if(time == null) {
                time = 3000;
            }
            icon = '<span class="glyphicon glyphicon-exclamation-sign"></span><strong> Información</strong> ';
        break;
            
    }
    
    msg = '<div class="alert alert-'+type+' alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+icon+text+'</div>';

    $("#"+position).html(msg);  
    if(time !== 0) {
        setTimeout(function(){
            $("#"+position+" .alert").alert("close");    
        }, time);
    }
}

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

