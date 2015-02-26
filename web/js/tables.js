var responsiveHelper_dt_basic = undefined;
var responsiveHelper_datatable_fixed_column = undefined;
var responsiveHelper_datatable_col_reorder = undefined;
var responsiveHelper_datatable_tabletools = undefined;

var breakpointDefinition = {
        tablet : 1024,
        phone : 480
};


function getDataRowDT(dataTable, element) {
    if(dataTable == null) {
        alert("Indica el dataTable");
        return;
    }
    
    if(element == null ) {
        alert("Indica el elemento");
        return;
    }
    
    row = element.parents("tr").eq(0);
    index = dataTable.row(row).index();
    data = dataTable.row(row).data();
    
    return {"index": index, "data": data };
}

optionsDTLanguaje = {
    
    "sZeroRecords": "<i class='fa fa-warning text-warning'></i> No se encontraron registros.",
    "sInfo": "<span class='badge'>_START_</span> - <span class='badge'>_END_</span> de <span class='badge'>_TOTAL_</span>",
    "sInfoEmpty": "<span class='badge'>0</span>",
    "sInfoFiltered": "(de <span class='badge'>_MAX_</span>)",
    "sProcessing": "Actualizando..."
};

function getOptionsResponsive(table) {
  
    options = {

        "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#'+table), breakpointDefinition);
                }
        },
        "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
        },
        "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
        }
    }
    
    return options;
}



optionsDTComplete = {
    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>l>>r"+
        "t"+
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
    "autoWidth" : true,
    "bJQueryUI": false,
    "bSort": true,
    "bBootstrap": true,
    "aaSorting": [],
    "bInfo": true,
    "bPaginate": true,
    //"sPaginationType": "full_numbers",
    "oLanguage": optionsDTLanguaje,
    
};

optionsDTMinimal = {
    "bJQueryUI": false,
    "bSort": false,
    "aaSorting": [],
    "bInfo": false,
    "bPaginate": false,
    "bFilter": true,
    //"sPaginationType": "full_numbers",
    "oLanguage": optionsDTLanguaje,
    //"sDom": "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>"
};

optionsDTMedium = {
    "bJQueryUI": false,
    "bSort": true,
    "aaSorting": [],
    "bInfo": true,
    "bPaginate": false,
    "bFilter": true,
    //"sPaginationType": "full_numbers",
    "oLanguage": optionsDTLanguaje,
    //"sDom": "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>"
};

function createDataTable(type, table, options)
{
    if(type == null) {
        alert("Indica el tipo DataTable complete,medium o minimal.");
        return;
    }
    
    if(table == null) {
        alert("Indica el id de la tabla.");
        return;
    }
    optionsResponsive = getOptionsResponsive(table);
    
    switch(type) {
        case "complete": 
            if(options == null) {
                settings = optionsDTComplete;
            } else {
                settings = $.extend({}, optionsDTComplete, options);
            }
            //dataTable =  $("#"+table).dataTable(settings);
            break;
        case "medium":
            if(options == null) {
                settings = optionsDTMedium;
            } else {
                settings = $.extend({}, optionsDTMedium, options);
            }
            
            break;
        case "minimal":
            
            if(options == null) {
                settings = optionsDTMinimal;
            } else {
                settings = $.extend({}, optionsDTMinimal, options);
            }
            
            break;
    }
    settings = $.extend({}, settings, optionsResponsive)
    
    dataTable =  $("#"+table).DataTable(settings);
    
    return dataTable;
}

jQuery.fn.dataTableExt.oApi.fnSetFilteringDelay = function ( oSettings, iDelay ) {
    var _that = this;
 
    if ( iDelay === undefined ) {
        iDelay = 250;
    }
 
    this.each( function ( i ) {
        $.fn.dataTableExt.iApiIndex = i;
        var
            $this = this,
            oTimerId = null,
            sPreviousSearch = null,
            anControl = $( 'input', _that.fnSettings().aanFeatures.f );
 
            anControl.unbind( 'keyup search input' ).bind( 'keyup search input', function() {
            var $$this = $this;
 
            if (sPreviousSearch === null || sPreviousSearch != anControl.val()) {
                window.clearTimeout(oTimerId);
                sPreviousSearch = anControl.val();
                oTimerId = window.setTimeout(function() {
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter( anControl.val() );
                }, iDelay);
            }
        });
 
        return this;
    } );
    return this;
};

jQuery.fn.dataTableExt.oApi.fnFilterClear  = function ( oSettings )
{
    var i, iLen;
 
    /* Remove global filter */
    oSettings.oPreviousSearch.sSearch = "";
 
    /* Remove the text of the global filter in the input boxes */
    if ( typeof oSettings.aanFeatures.f != 'undefined' )
    {
        var n = oSettings.aanFeatures.f;
        for ( i=0, iLen=n.length ; i<iLen ; i++ )
        {
            $('input', n[i]).val( '' );
        }
    }
 
    /* Remove the search text for the column filters - NOTE - if you have input boxes for these
     * filters, these will need to be reset
     */
    for ( i=0, iLen=oSettings.aoPreSearchCols.length ; i<iLen ; i++ )
    {
        oSettings.aoPreSearchCols[i].sSearch = "";
    }
 
    /* Redraw */
    oSettings.oApi._fnReDraw( oSettings );
};