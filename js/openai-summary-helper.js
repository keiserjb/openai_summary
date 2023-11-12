(function ($) {
  Backdrop.behaviors.openaiSummaryHelper = {
    attach: function (context, settings) {
      $('.openai-summary-btn', context).once('openai-summary-helper').each(function () {

        var showThrobber = function() {
          var wrapper = $('#edit-body');
          var existingThrobber = $('.ajax-progress');
          if (existingThrobber.length) {
            wrapper.parent().append(existingThrobber);
          } else {
            var throbber = $('<div class="ajax-progress ajax-progress-throbber"><div class="throbber">&nbsp;</div></div>');
            wrapper.parent().append(throbber);
          }
        };

        var removeThrobber = function() {
          $('.ajax-progress').remove();
        };

        var simulateClick = function(element) {
          var e = new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
          });
          element.dispatchEvent(e);
          showThrobber();
        };

        removeThrobber();

        var buttonElement = $(this);
        var submitBtn = $('#edit-fill-summary');
        submitBtn.addClass('visually-hidden');
        buttonElement.click(function() {
          simulateClick(submitBtn[0]);
        });

        $(document).ajaxError(function () {
          removeThrobber();
        });

        $(document).ajaxComplete(function () {
          removeThrobber();
        });
      });
    }
  };
})(jQuery);
