(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      if (this.files.length > 0) {
        var filename = [];
        $.each(this.files , (i , v) => {
          filename[i] = v.name;
        });
        $(this).parent().find('.form-control').val(filename.concat());
        // $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
      }
    });
  });
})(jQuery);