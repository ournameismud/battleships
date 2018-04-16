/**
 * Battleships plugin for Craft CMS
 *
 * BattleshipsField Field JS
 *
 * @author    @cole007
 * @copyright Copyright (c) 2018 @cole007
 * @link      http://ournameismud.co.uk/
 * @package   Battleships
 * @since     0.0.1BattleshipsBattleshipsField
 */

 ;(function ( $, window, document, undefined ) {

    var pluginName = "BattleshipsBattleshipsField",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    function buildClicks(wrapper) {
        // buildBlobs(wrapper);        
        var rows = $(wrapper).find('tbody tr');
        // need to make target more flexible
        var target = $('#fields-ex1');
        $(wrapper).find('tr').each(function() {
            var row = this;
            var rowIndex = $( rows ).index( row );
            $(row).find('td').each(function() {
                if ($(this).hasClass('picker')) {
                    
                    var input = $(this).find('input');
                    var title = $(rows[rowIndex]).find('.title').find('input, textarea').val();
                    
                    $(input).on('click',function(e) {
                        
                        e.preventDefault();
                        
                        $( wrapper ).find('tr').css('border','1px solid red').removeClass('wibble');
                        
                        var modal = $(target).modal({ modalClass: 'bs-modal' });
                        // $(target).on($.modal.OPEN, function(event, modal) {
                            buildBlobs(wrapper);
                            var targetImg = $(target).find('img')[0];
                            
                            $( targetImg ).nextAll('p').text(title);
                            var srcHt = targetImg.naturalHeight;
                            var actHt = targetImg.clientHeight;
                            var ht = actHt/srcHt;
                            
                            var srcWt = targetImg.naturalWidth;
                            var actWt = targetImg.clientWidth;
                            var wt = actWt/srcWt;                        

                            var blob = $('#fields-blob');
                            var fields = $( row ).find('td.coord').find('textarea, input');
                            $(blob).css({
                                top: ($(fields[1]).val() * ht) + 'px',
                                left: ($(fields[0]).val() * wt) + 'px'
                            });

                            $( targetImg ).off().on('click', function(e) {
                                var elm = $(this);
                                var xPos = e.pageX - elm.offset().left;
                                // var xPos = xPos / wt; 
                                var yPos = e.pageY - elm.offset().top;
                                // var yPos = yPos / ht; 
                                $(blob).css({
                                    display: 'block',
                                    left: (xPos) + 'px',
                                    top: (yPos) + 'px'
                                });
                                
                                $(fields[0]).val(Math.round(xPos / wt));
                                $(fields[1]).val(Math.round(yPos / ht));
                                // $.modal.close();
                                buildBlobs(wrapper);
                                // alert("The image is located at: " + xPos + ", " + yPos);    
                            });
                        // });
                        
                        
                    });
                } else if ($(this).hasClass('coord')) {
                    $(this).find('input, textarea').prop('readonly', true);
                }
            });
        });
    }
    function buildBlobs(wrapper) {
        // need to make target more flexible
        var target = $('#fields-ex1');

        var img = $(target).find('img')[0];
        
        var srcHt = img.naturalHeight;
        var actHt = img.clientHeight;
        var srcWt = img.naturalWidth;
        var actWt = img.clientWidth;

        var ht = actHt/srcHt;
        var wt = actWt/srcWt;

        $(target).find('.blobs').remove();
        $(wrapper).find('tr').each(function() {
            var row = this;
            var fields = $( row ).find('td.coord').find('textarea, input');
            var img = $(target).find('img')[0];
            var left = ($(fields[0]).val() * wt);
            var top = ($(fields[1]).val() * ht);
            if (typeof top !== 'undefined' && top !== '' && typeof left !== 'undefined' && left !== '') $(img).after('<div class="blobs" style="top:'+top+'px;left:'+left+'px;"></div>');
        });
    }    
    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {
                
                // TO DO: bind callback to element selection
                // TO DO: hide table if no element selected
                var assetField = $('.bs-selecta .elementselect');
                $(assetField).data('elementSelect').on('selectElements', function(elements) {
                    if (elements.elements.length > 0) {
                        $('.battleship-wrapper').removeClass('hidden');
                        var element = elements.elements[0];
                        var img = $('#fields-ex1').find('img').attr('src','/' + element.url );
                        $(img).attr('width',img.naturalWidth);
                        $(img).attr('width',img.naturalHeight);                        
                    } else {
                        $('.battleship-wrapper').addClass('hidden');
                    }
                });
                $(assetField).data('elementSelect').on('removeElements', function(elements) {
                    $('.battleship-wrapper').addClass('hidden');
                });
                
                $('.battleship-wrapper').each(function() {
                    var wrapper = $(this);
                    
                    buildClicks(wrapper);
                    $('.btn.add.icon').on('click', function() {
                        buildClicks(wrapper);                        
                    });
                });

                $('[rel=close-modal]').on('click',function(e) {
                    e.preventDefault();
                    $.modal.close();
                });
            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
