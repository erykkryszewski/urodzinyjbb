import $ from 'jquery';

$(document).ready(function(){
  let archiveTitle = $('.woocommerce-products-header');
  let breadcrumbs = $('.woocommerce-breadcrumb');
  let filters = $('.product-filters');
  
  if(archiveTitle.length > 0 && breadcrumbs.length > 0) {
    archiveTitle.insertBefore(breadcrumbs);
  } else if(archiveTitle.length > 0 && filters.length > 0 && breadcrumbs.length == 0) {
    archiveTitle.insertBefore(filters);
  }
});