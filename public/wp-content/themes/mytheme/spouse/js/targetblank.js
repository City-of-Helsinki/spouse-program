// Accessibility needs this.
jQuery('document').ready(function(){
  jQuery('a[target=_blank]').each(function(){
    jQuery(this).append(' <span class="spouse-visually-hidden">opens in new tab</span>')
  });
})
