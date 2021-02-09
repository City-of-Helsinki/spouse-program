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

// if link has class wow-modal-id-x, add spouse focus event to it automatically.
(jQuery('document').ready(function(){
  jQuery("[class*=wow-modal-id-]").each(function(index, value){
    if(jQuery(this).closest('a').length){
      jQuery(this).on('click', spouse_focus);
    }
  })
}))

