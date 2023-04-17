(function($) {
    $.entwine("ss", function($) {
        /**
         * GridFieldRefreshButton
         */

        $(".ss-gridfield").entwine({
            reload: function(ajaxOpts, successCallback)
            {
                this._super(ajaxOpts, successCallback);

                var refreshButton = $(this).find(".gridfield-refresh-button");
                if (typeof refreshButton !== 'undefined' && refreshButton !== null)
                {
                    var otherGridsToReload = $.parseJSON(refreshButton.attr('data-reloads'));
                    if (typeof otherGridsToReload !== 'undefined' && otherGridsToReload !== null)
                    {
                        $.each(otherGridsToReload, function(i, gridName) {
                            var otherGrid = $('.ss-gridfield[data-name="' + gridName + '"]');
                            if (typeof otherGrid !== 'undefined' && otherGrid !== null) {
                                otherGrid.reload();
                            }
                        });
                    }
                }
            }
        });

        $(".ss-gridfield .gridfield-refresh-button").entwine({
            onclick: function() {
                var thisGrid = this.closest(".ss-gridfield");
                thisGrid.reload();
                return false;
            }
        });
    });
})(jQuery);
