function spouse_focus(event){
  var modalNumber = event.target.classList[0].substr(-1);
  var id = "#wow-modal-window-"+modalNumber;
  var input = jQuery(id).find('input[type=text]').first();
  setTimeout(function(){
      input.focus();
    },
    1000
  )
}
