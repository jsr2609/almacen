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
function initDatePicker(options, element) {
    if(options == null) {
        settings = optionsDatePicker;
    } else {
        settings = $.extend({}, optionsDatePicker, options);   
    }
    if(element == null) {
        $(".datepicker").datepicker(settings);
    } else {
        $("#"+element).datepicker(settings);
    }
    
}

/**
 * Crea una alerta
 */
function createAlert(type, title, content, time, size)
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
               title = "El proceso se realizó satisfactoriamente.";
           }
           optionsMessage = {
               title: title,
               content: content,
               color: "#5F895F",
               icon: "fa fa-thumbs-up bounce animated",
               iconSmall : "fa fa-thumbs-up bounce animated",
               timeout: time
           };
       break;

       case "warning":
           if(title == null) {
               title = "Advertencia.";
           }
           optionsMessage = {
               title: title,
               content: content,
               color: "#C79121",
               icon: "fa fa-warning bounce animated",
               iconSmall : "fa fa-warning bounce animated",
               timeout: time
           };
       break;

       case "info":
           if(title == null) {
               title = "Información.";
           }
           optionsMessage = {
               title: title,
               content: content,
               color: "#3276B1",
               icon: "fa fa-bell bounce animated",
               iconSmall : "fa fa-bell bounce animated",
               timeout: time
           };
       break;

    }
    if(size == "big") {
        $.bigBox(optionsMessage);
    } else {
        $.smallBox(optionsMessage);
    }
    
} //Fin crear alerta

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

function isEmpty(txt) {
    
    
    txt = txt.trim();
    l = txt.length;
    
    if(l === 0) {
        return true;
    } else {
        return false;
    }
    
}

