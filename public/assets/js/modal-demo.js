(function($) {
  'use strict';
  $('#exampleModal-4').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    var id = button.data('id') // Extract info from data-* attributes
    var value = button.data('value')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(recipient)
    if(id){
      modal.find('.modal-body input[name="id"]').val(id)
    }
    if (value) {
      modal.find('.modal-body input[name="name"]').val(value)
    }
  })
  $('#EditRoleModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    var id = button.data('id') // Extract info from data-* attributes
    var value = button.data('value') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(recipient)
    if(id){
      modal.find('.modal-body input[name="id"]').val(id)
    }if (value) {
      modal.find('.modal-body input[name="name"]').val(value)
    }
  })
})(jQuery);