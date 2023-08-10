
$(document).ready(function () {
   
   var menu_mobile_toogle = false;
   var menu_mobile = $('#nav-items-mobile');
   var submenu_mobile = $('#nav-submenu-mobile');
   menu_mobile.click(function(){
      if(menu_mobile_toogle == false){
         submenu_mobile.slideDown();
      }
      else{
         submenu_mobile.slideUp();
      }
      menu_mobile_toogle = !menu_mobile_toogle;
   })
  
   //scroll down animation
   var win = $(window);
   var allMods = $(".module");
   allMods.each(function (i, el) {
      var el = $(el);
      if (el.visible(true)) {
         el.addClass("already-visible");
      }
   });

   win.scroll(function (event) {

      allMods.each(function (i, el) {
         var el = $(el);
         if (el.visible(true)) {
            el.addClass("come-in");
         }
      });

   });
   //scroll to top event
   var btn = $('#back-to-top-button');

   $(window).scroll(function () {
      if ($(window).scrollTop() > 300) {
         btn.addClass('show');
      } else {
         btn.removeClass('show');
      }
   });

   btn.on('click', function (e) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: 0 }, '300');
   });

   //zoom event
   const zoomableImages = document.querySelectorAll('.zoom');
   zoomableImages.forEach(zoomableImage => {
      let isZoomed = false;
      zoomableImage.addEventListener('click', function () {
         if (isZoomed) {
            zoomableImage.style.transform = 'scale(1)';
            isZoomed = false;
         } else {
            zoomableImage.style.transform = 'scale(1.2)';
            isZoomed = true;
         }
      });
   });

   
    //scroll top at load


   //get all menu
   var menu = $('.menu');
   var submenu = $('.nav-submenu');
   var submenu_active;
   var menu_active;
   //get active menu
   for (let i = 0; i < menu.length; i++) {
      let item = $(menu[i]);
      let submenu_id = item.data('navsubmenuid');
      if (submenu_id != undefined) {
         let item_submenu = $('#' + submenu_id);
         if ((item_submenu.attr('class')).includes('active')) {
            //should have only 1 active menu 
            submenu_active = item_submenu;
            menu_active = item;
            break;
         }
      }
   }
   //add event on hover
   for (i = 0; i < menu.length; i++) {
      let item = $(menu[i]);
      let submenu_id = item.data('navsubmenuid');
      let item_submenu = $('#' + submenu_id);
      //if menu active then continue
      if ((item.attr('class')).includes('active')) {
         continue;
      }
      item.hover(function () {
         setTimeout(function () {
            if (menu_active.is(':hover')) {
               submenu_active.css("display", "block");
            } else {
               //check if none submenu item menu is hovered
               if (submenu_id != undefined) {
                  for (let y = 0; y < submenu.length; y++) {
                     let item = $(submenu[y]);
                     if (item.is(item_submenu) || item.is(submenu_active)) {
                        continue;
                     }
                     item.css("display", "none")
                  }
                  submenu_active.css("display", "none");
                  item_submenu.css("display", "block");
               } else {
                  submenu_active.css("display", "block");
               }
            }
         }, 200);
      }, function () {
         //set timeout
         setTimeout(function () {
            let isOtherMenuHovered = false;
            let isMenuActiveHovered = false;
            if (menu_active.is(':hover')) {
               isMenuActiveHovered = true;
            }
            //check if other menu is hovered
            for (i = 0; i < menu.length; i++) {
               let item_menu = $(menu[i]);
               if (item_menu.is(menu_active)) {
                  continue;
               }
               if (item_menu.is(item)) {
                  continue;
               }
               if (item_menu.is(':hover')) {
                  isOtherMenuHovered = true;
                  break;
               }
            }
            if (isOtherMenuHovered == true && isMenuActiveHovered == true) {
               if (submenu_id != undefined) {
                  item_submenu.css("display", "none");
                  submenu_active.css("display", "block");
               } else {
                  submenu_active.css("display", "block");
               }
            }
            if (isOtherMenuHovered == true && isMenuActiveHovered == false) {
               if (submenu_id != undefined) {
                  item_submenu.css("display", "none");
               } else {
                  submenu_active.css("display", "block");
               }
            }
            if (isOtherMenuHovered == false && (isMenuActiveHovered == false || isMenuActiveHovered == true)) {
               //check if submenu is being hovered
               if (submenu_id != undefined) {
                  if (!item_submenu.is(':hover')) {
                     item_submenu.css("display", "none");
                     submenu_active.css("display", "block");
                  }
               } else {
                  submenu_active.css("display", "block");
               }
            }
         }, 200)
      })
   }
});
