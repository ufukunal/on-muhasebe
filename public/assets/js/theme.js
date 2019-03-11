/*
* Name:        Oscar
* Written by: 	Unifato - (http://unifato.com)
* Version:     1.0.0
*/

(function($) {
  'use strict';

  var initBodyClass = "";
  if($("body").hasClass("sidebar-collapse")) {
    initBodyClass = "sidebar-collapse";
  } else if ($("body").hasClass("sidebar-expand")) {
    initBodyClass = "sidebar-expand";
  }

  var Unifato = {
    init: function() {
      this.collapseNavbar();
      $(window).scroll(this.collapseNavbar);
      this.contentHeight();

      this.header();
      this.sidebar();
      this.content();
      this.enableScrollbar();
      this.inputFocus();
      this.enableTooltip();
      this.enableMailbox();
      this.enableRadioCheckbox();
      this.enableValidation();
      this.enablePace();
      this.enablePlugins();
    },

    enablePace: function() {
      Pace.on('done', function() {
        $(document).trigger('PACE_DONE');
      });
    },

    enablePlugins: function() {
      this.enableSweetAlert();
      this.enableTodo();
      this.enableTwitterWidget();
      this.enableFacebookWidget();
      this.enableVectorMaps();
      this.enableGoogleMaps();
      this.enableFullCalendar();
      this.enableClndr();
      this.enableDataTables();
      this.enableFootable();
      this.enableTableEditable();
      this.enableCountUp();
      this.enableRangeSlider();
      this.enableSortable();
      this.enableNestedSortable();
      this.enableTimelineLoadMoreBtn();
      this.enableCarousel();
      this.enableMedia();
      this.enableInputMask();
      this.enableDropify();
      this.enableDropzone();
      this.enableClockPicker();
      this.enableColorPicker();
      this.enableDateRangePicker();
      this.enablePredefinedDateRangePicker();
      this.enableDatePicker();
      this.enableSelect2();
      this.enableSwitchery();
      this.enableTouchspin();
      this.enableMultiSelect();
      this.enableTinyMCE();
      this.enableBootstrapWysiwyg();
      this.enableCircleProgress();
      this.enableSparkline();
    },

    collapseNavbar: function() {
      if( $(window).scrollTop() > 30 ) {
        $("#wrapper").addClass("fix-top");
      }
      else {
        $("#wrapper").removeClass("fix-top");
      }
    },

    header: function() {

    },

    contentHeight: function() {
      var width = window.innerWidth > 0 ? window.innerWidth:screen.width;
      var l;

      if ( width > 720 && $("body").hasClass("collapse-collapse") ) {
        l = $(".site-sidebar").outerHeight() - 1;
        $(".main-wrapper").css("min-height", l + "px");
      }
      if ( width > 720 && $("body").hasClass('sidebar-horizontal') ) {
        l = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1 - $(".navbar").outerHeight() - $('.site-sidebar').outerHeight();
        $(".main-wrapper").css("min-height", l + "px");
      }
      else if (width > 720) {
        l = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1 - $(".navbar").outerHeight();
        $(".main-wrapper").css("min-height", l + "px");
      }
    },

    content: function() {
      $(".card-expandable .card-header").on("click",function(e) {
        $(this).parents(".card").toggleClass("card-expanded");
      });

      this.enableMagnificPopup();

      var scrollToBottom = document.getElementsByClassName('scroll-to-bottom');
      for( var i = 0; i < scrollToBottom.length; i++ ) {
        scrollToBottom[i].scrollTop = scrollToBottom[i].scrollHeight;
      }

      $('.blog-post-share-links .toggle-link').click(function() {
        $(this).closest('ul').toggleClass('active');
      });
    },

    initScrollbar: function($el) {
      $el.perfectScrollbar($el[0].dataset);
    },

    sidebar: function() {
      var self = this;
      if( document.body.classList.contains('sidebar-expand') )
      $('.side-menu').metisMenu({ preventDefault: true });
      $('.side-menu').on('show.metisMenu',function() {
        $('.site-sidebar.scrollbar-enabled').perfectScrollbar('destroy');
        self.initScrollbar( $('.site-sidebar.scrollbar-enabled') );
      });
      this.sidebarToggle();
			this.rightSidebarToggle();
      this.sidebarUserToggle();
      this.chatSidebar();
    },

    setMenu: function(){
      var self = this;
      var width = window.innerWidth > 0 ? window.innerWidth:screen.width;
      var $body = $("body");
      $('.site-sidebar.scrollbar-enabled').perfectScrollbar('destroy').removeClass('ps');

      if (width < 961) {
        $('.side-menu').metisMenu({ preventDefault: true });
      }
      else if (width > 960 && width < 1170 && initBodyClass == "sidebar-expand") {
        $(".site-sidebar").show();
        $body.removeClass("sidebar-expand");
        $body.addClass("sidebar-collapse");
      }
      else if (width >= 1170 && initBodyClass == "sidebar-expand") {
        $(".site-sidebar").show();
        $body.removeClass("sidebar-collapse");
        $body.addClass("sidebar-expand");
        Unifato.initScrollbar( $('.site-sidebar.scrollbar-enabled') );
      }
      else if ($body.hasClass("sidebar-expand")) {
        $(".site-sidebar").show();
        Unifato.initScrollbar( $('.site-sidebar.scrollbar-enabled') );
      }
      else if ( document.body.classList.contains('sidebar-horizontal') ) {
        $(".site-sidebar").show();
        $('.side-menu').metisMenu('dispose');
      }
      else {
        $(".site-sidebar").show();
      }
    },

    sidebarToggle: function() {
      var self = this;
      $(".sidebar-toggle a").on("click",function(){
        var width = window.innerWidth > 0 ? window.innerWidth : screen.width;
				var $body = $("body");
        $('.site-sidebar.scrollbar-enabled').perfectScrollbar('destroy').removeClass('ps');

        if (width < 961) {
          $(".site-sidebar").toggle();
        }
        else if ($body.hasClass("sidebar-expand")) {
          $body.removeClass("sidebar-expand");
          $body.addClass("sidebar-collapse");
          $(".side-user > a").removeClass("active");
          $(".side-user > a").siblings(".side-menu").hide();
          $('.side-menu .sub-menu').css('height', 'auto');
          $('.side-menu').metisMenu('dispose');
        }
        else if ($body.hasClass("sidebar-collapse")) {
          $body.removeClass("sidebar-collapse");
          $body.addClass("sidebar-expand");
          self.initScrollbar( $('.site-sidebar.scrollbar-enabled') );
          $('.side-menu').metisMenu({ preventDefault: true });
        }

        Unifato.contentHeight();
        if( width > 961 ) {
          $(document).trigger("SIDEBAR_CHANGED_WIDTH");
        }
      });

    },

    rightSidebarToggle : function() {
			$(".right-sidebar-toggle").on("click",function(e) {
        $('.dropdown-toggle[aria-expanded="true"]').dropdown('toggle');
				$('body').toggleClass('right-sidebar-expand');
        return false;
			});

      document.addEventListener('click', function(event) {
        var $rightSidebar = document.getElementsByClassName('right-sidebar')[0],
            $chatPanel = document.getElementsByClassName('chat-panel')[0];
        var isInsideContainer = $rightSidebar.contains( event.target ) || $chatPanel.contains(event.target);
        if( !isInsideContainer ) {
          document.body.classList.remove('right-sidebar-expand');
          $chatPanel.hidden = 'hidden';
        }
      });
		},

    sidebarUserToggle: function() {
      $(".side-user > a").on("click",function(){
        if ($('body').hasClass("sidebar-collapse") === false) {
          $(this).toggleClass("active");
          $(this).siblings(".side-menu").toggle();
        }
      });
    },

    chatSidebar: function() {
      var el = $('[data-plugin="chat-sidebar"]');
      if( !el.length ) return;
      var chatList = el.find('.chat-list');
      this.chatPanel();
      chatList.each(function(index) {
        var $this = $(this);
        $(this).find('.list-group a').on('click', function() {
          $this.find('.list-group a.active').removeClass('active');
          $(this).addClass('active');
          var el = $('.chat-panel');
          if(!el.length) return;
          el.removeAttr('hidden');

          // For Scroll to Bottom
          var messages = el.find('.messages');
          messages[0].scrollTop = messages[0].scrollHeight;
          if( messages[0].classList.contains('scrollbar-enabled') ) {
            messages.perfectScrollbar('update');
          }

          el.find('.user-name').html( $(this).data('chat-user'));
        });
      });
    },

    chatPanel: function() {
      var el = $('.chat-panel');
      if(!el.length) return;

      // Close Button
      el.find('.close').on('click', function(){
        el.attr('hidden', true);
        el.find('.panel-body').removeClass('hide');
      });

      // Minimize Button
      el.find('.minimize').on('click', function(){
        el.find('.card-block').attr('hidden', !el.find('.card-block').attr('hidden') );
        if( el.find('.card-block').attr('hidden') === 'hidden' )
        $(this).find('.material-icons').html('expand_less');
        else
        $(this).find('.material-icons').html('expand_more');
      });

    },

    enableMagnificPopup: function() {
      var el = $('[data-toggle="lightbox"], [data-toggle="lightbox-gallery"]');
      if(!el.length) return;
      el.each(function() {
        var $this = $(this),
            src = $this.data('src'),
            type = $this.data('type'),
            defaults = {},
            options = $this.data('plugin-options') !== undefined ? $this.data('plugin-options') : {},
            lightboxClass = $this.data('lightbox-class') !== undefined ? $this.data('lightbox-class') : "";

        if( $this.data('toggle') === "lightbox" ) {
          defaults = {
            type: type,
            callbacks: {
              beforeOpen: function() {
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated ' + this.st.el.attr('data-effect') );
              }
            }
          };
          options = $.extend( {}, defaults, options);
          $this.magnificPopup(options);
        }

        else if( $this.data('toggle') === "lightbox-gallery" ) {
          defaults = {
            type: type,
            delegate: 'a',
            gallery: {
              enabled: true,
            },
            callback: {
              beforeOpen: function() {
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated ' + this.st.el.attr('data-effect') );
              }
            }
          };
          options = $.extend( {}, defaults, options);
          $this.magnificPopup(options);
        }
      });
    },

    enableScrollbar: function() {
      var el = $('.scrollbar-enabled, .dropdown-list-group ');
      if(!el.length) return;
      el.each(function(index){

        var $this = $(this);
        var options = {
          wheelSpeed: 0.5
        };
        if( this.classList.contains('suppress-x') ) options.suppressScrollX = true;
        if( this.classList.contains('suppress-y') ) options.suppressScrollY = true;
        $this.perfectScrollbar(options);

        if($this.parent().parent().hasClass('dropdown-card')) {
          $(document).on('shown.bs.dropdown',$this.parent().parent(), function(){
            $this.perfectScrollbar('update');
          });
        }

        $(document).on('show.metisMenu, hide.metisMenu', function() {
          $this.perfectScrollbar('update');
        });

        if ( this.classList.contains('scroll-to-bottom') ) {
          this.scrollTop = this.scrollHeight;
          $this.perfectScrollbar('update');
        }

      });
    },

    inputFocus: function() {
      var el = $('input:not([type=checkbox]):not([type=radio]), textarea');
      if( !el.length ) return;

      el.each(function() {
        var $this = $(this),
            self = this;

        var hasValueFunction = function() {
          if( self.value.length > 0 ) {
            self.parentNode.classList.add('input-has-value');
            $(self).closest('.form-group').addClass('input-has-value');
          }
          else {
            self.parentNode.classList.remove('input-has-value');
            $(self).closest('.form-group').removeClass('input-has-value');
          }
        };

        hasValueFunction(this);
        $this.on('input', hasValueFunction);

        $this.focusin(function() {
          this.parentNode.classList.add('input-focused');
          $this.closest('.form-group').addClass('input-focused');
        });
        $this.focusout(function() {
          this.parentNode.classList.remove('input-focused');
          $this.closest('.form-group').removeClass('input-focused');
        });

        $this.find('.remove-focus').on('click',function() {
          $this.emit('focusout');
        });
      });
    },

    enableTooltip: function() {
      $('[data-toggle="tooltip"]').tooltip();
    },

    enableMailbox: function() {
      this.enableMailboxInbox();
    },

    enableMailboxInbox: function() {
      var el = $('.mail-inbox');
      if( !el.length ) return;
      var MailBox = {
        init: function() {
          this.selectAll();
        },
        selectAll: function() {
          var selectAll = el.find('.mail-inbox-select-all input');
          selectAll.on('change', function() {
            var allCheckboxes = el.find('.mail-list .mail-select-checkbox input[type="checkbox"]');
            for( var i = 0; i < allCheckboxes.length; i++ ) {
              allCheckboxes[i].checked = selectAll[0].checked;
            }
          });
        }
      };
      MailBox.init();
    },

    enableRadioCheckbox: function() {
      var input = document.getElementsByTagName('input');
      for( var i = 0; i < input.length; i++ ) {
        if( input[i].type === 'checkbox' ) {
          if( input[i].checked === true ) {
            input[i].parentNode.classList.add('checkbox-checked');
          }
          input[i].addEventListener('change', function() {
            if( this.checked === true ) {
              this.parentNode.classList.add('checkbox-checked');
            } else {
              this.parentNode.classList.remove('checkbox-checked');
            }
          });
        }
      }
    },

    enableValidation: function() {
      if( typeof $.validate === 'function' ) {
        $.validate({
          modules: 'security, date',
          errorMessageClass: 'invalid-feedback',
          errorElementClass: 'is-invalid',
        });
      }

      this.enableFieldLengthIndicator();
    },

    enableFieldLengthIndicator: function() {
      var el = $('.field-length-indicator');
      if( !el.length ) return;
      el.each(function() {
        var $this = $(this),
            target = $this.data('length-target');

        $(target).restrictLength( $this.find('.indicator') );
      });
    },

    enableSweetAlert: function() {
      if( typeof swal === 'function' ) {
        swal.setDefaults({
          buttonsStyling: false, // disables plugn styles for buttons
          cancelButtonClass: 'btn btn-default',
          confirmButtonClass: 'btn btn-info'
        });
      }

      var el = $('.modal-alert');
      if( !el.length ) return;
      el.each(function() {
        var $this = $(this);
        var options = {};

        if ( $this.data('title') !== undefined ) options.title = $this.data('title');
        if ( $this.data('text') !== undefined ) options.text = $this.data('text');

        if ( $this.data('type') !== undefined ) {
          options.type = $this.data('type');

          switch( $this.data('type') ) {
            case 'success': options.confirmButtonClass = 'btn btn-success'; break;
            case 'warning': options.confirmButtonClass = 'btn btn-warning'; break;
            case 'error': options.confirmButtonClass = 'btn btn-danger'; break;
            default: options.confirmButtonClass = 'btn btn-info';
          }
        } else {
          options.confirmButtonClass = 'btn btn-info';
        }

        if ( $this.data('button-text') !== undefined ) options.confirmButtonText = $this.data('button-text');

        $this.click(function() {
          swal(options);
        });
      });
    },

    enableTodo: function() {
      var el = document.getElementsByClassName('todo-widget');
      if( !el.length ) return;
      for( var i = 0; i < el.length; i++ ) {
        var todo1 = new Todo( el[i] );
      }
    },

    enableTwitterWidget: function() {
      var el = document.getElementsByClassName('twitter-widget');
      if ( !el.length ) return;
      for( var i = 0; i < el.length; i++) {
        var options = JSON.parse( JSON.stringify( el[i].dataset )).pluginOptions;
        if ( options === undefined ) options = {};
        var twitter = new TwitterWidget( el[i], options );
      }
    },

    enableFacebookWidget: function() {
      var el = document.getElementsByClassName('facebook-widget');
      if ( !el.length ) return;
      for( var i = 0; i < el.length; i++) {
        var options = JSON.parse( JSON.stringify( el[i].dataset )).pluginOptions;
        if ( options === undefined ) options = {};
        var facebook = new FacebookWidget( el[i], options );
      }
    },

    enableVectorMaps: function() {
      var el = $('[data-toggle="vector-map"]');
      if ( !el.length ) return;
      var defaults = {
        map: 'world_en',
        backgroundColor: null,
        borderColor: "#ffffff",
        color: '#999999',
        hoverOpacity: 0.8,
        selectedColor: '#777777',
        enableZoom: true,
        showTooltip: true,
        normalizeFunction: 'polynomial',
        onLabelShow: function(event, label, code) {
          var mapValues = $(this)[0].mapValues,
            $this = $(this),
            place = label[0].innerHTML;
          if( mapValues !== undefined) {
            var value = $(this)[0].mapValues[code];
            if(value!==undefined ) {
              value = $(this)[0].mapValues[code];
              if($this.data('plugin-options').label !== undefined) {
                label[0].innerHTML = $this.data('plugin-options').label.replace('%p', place).replace('%v', value);
              }
              else
                label[0].innerHTML = label[0].innerHTML + ":  " + value;
            }
            else if(value===undefined) {
              if($this.data('plugin-options').label !== undefined) {
                label[0].innerHTML = $this.data('plugin-options').labelNaN.replace('%p', place);
              }
              else
                label[0].innerHTML = 'NaN';
            }
          }
          else if( $this.data('plugin-options').label !== undefined ) {
            label[0].innerHTML = $this.data('plugin-options').label.replace('%p',place);
          }
        },
      };
      el.each(function(index) {
        var $this = $(this),
          mapOptions = $this.data('plugin-options'),
          instance = null,
          options = $.extend({}, defaults, mapOptions);

        if ( this.unifato === undefined )
        this.unifato = {};
        instance = this.unifato;
        if(typeof(options.valuesSrcFile) !== 'undefined') {
          $.ajax({
            url: options.valuesSrcFile,
            dataType: "json",
            success: function(result) {
              options.values = result;
              $this[0].mapValues = result;
              instance.vmap = $this.vectorMap(options);
            },
          });
        }
        else {
          instance.vmap = $this.vectorMap(options);
        }
      });
    },

    enableGoogleMaps: function() {
      var el = $('[data-toggle="google-map"]');
      if( !el.length ) return;
      var maps = 0;
      el.each(function(index) {
        var $this = $(this),
          instance = null,
          options = $(this).data('plugin-options');

        maps++;
        $this.attr('id', 'gmaps-' + maps );
        var defaults = {
          el: "#gmaps-" + maps
        };

        if ( this.unifato === undefined )
        this.unifato = {};
        instance = this.unifato;

        // Map Markers
        if( $this.has('.map-marker').length !== 0 )
        {
          options.markers = [];
          var markers = $this.find('.map-marker');
          markers.each(function(index){
            var markerOptions = $(this).data('plugin-options');
            if( $(this).has('.content').length !== 0 ) {
              markerOptions.infoWindow = {};
              markerOptions.infoWindow.content = $(this).find('.content').html();
            }
            options.markers.push(markerOptions);
          });
        }

        // Map Overlays
        if( $this.has('.map-overlays').length !== 0 )
        {
          options.overlays = [];
          var overlays = $this.find('.map-overlays');
          overlays.each(function(index){
            var overlayOptions = $(this).data('plugin-options');
            overlayOptions.content = $(this).html();
            overlayOptions.content = overlayOptions.content.trim();
            options.overlays.push(overlayOptions);
          });
        }

        // Map Path
        if( $this.has('.map-path').length !== 0 )
        {
          options.path = [];
          var paths = $this.find('.map-path');
          paths.each(function(index){
            var pathOptions = $(this).data('plugin-options');
            options.path.push(pathOptions);
          });
        }

        // Map Route
        if( $this.has('.map-route').length !== 0 )
        {
          options.routes = [];
          var routes = $this.find('.map-route');
          routes.each(function(index){
            var routeOptions = $(this).data('plugin-options');
            options.routes.push(routeOptions);
          });
        }

        // Map Polygon
        if( $this.has('.map-polygon').length !== 0 )
        {
          options.polygon = [];
          var polygons = $this.find('.map-polygon');
          polygons.each(function(index){
            var polygonOptions = $(this).data('plugin-options');
            options.polygon.push(polygonOptions);
          });
        }

        // Map Style 
        if( $this.has('.map-style').length !== 0 )
        {
          var styles = JSON.parse( $this.find('.map-style').html() );
          options.styles = styles;
          //map.addStyle({
            //styledMapName:"Styled Map",
            //styles: styles,
            //mapTypeId: "map_style"  
          //});
          //map.setStyle("map_style");
        }

        // Initialize Maps
        options = $.extend({}, defaults, options);
        var map = new GMaps(options);
        instance.gmap = map;
        var i = 0;

        if( options.styles !== undefined ) {
          map.addStyle({
            styledMapName:"Styled Map",
            styles: options.styles,
            mapTypeId: "map_style"  
          });
          map.setStyle("map_style");
        }

        // Adding Markers to Map
        if(options.markers !== undefined)
        {
          for(i=0; i<options.markers.length; i++ )
            map.addMarker(options.markers[i]);
        }

        // Adding Overlays to Map
        if(options.overlays !== undefined)
        {
          for(i=0; i < options.overlays.length; i++ )
            map.drawOverlay(options.overlays[i]);
        }

        // Adding Path to Map
        if(options.path !== undefined)
        {
          for(i=0; i < options.path.length; i++ )
            map.drawPolyline(options.path[i]);
        }

        // Adding Routes to Map
        if(options.routes !== undefined)
        {
          for(i=0; i < options.routes.length; i++ )
            map.drawRoute(options.routes[i]);
        }

        // Adding Path to Map
        if(options.polygon !== undefined)
        {
          for(i=0; i < options.polygon.length; i++ )
            map.drawPolygon(options.polygon[i]);
        }
      });
    },

    enableFullCalendar: function() {
      var el = $('[data-toggle="fullcalendar"]');
      if( !el.length ) return;
      this.enableFullCalendarEvents();
      window.ThemeFullCalendar = {};
      var showContentInModal = function(calEvent, instance) {
        window.ThemeFullCalendar.EventEditMode = calEvent;
        var eventModal = $('#eventEditModal');
        eventModal.find('input[name="event-name"]').val(calEvent.title);
        var classNames = calEvent.className;
        for(var i=0; i<classNames.length; i++) {
          if(classNames[i].startsWith('bg-')) {
            var bg = classNames[i].substr(3);
            eventModal.find('select[name="event-bg"]').val(bg);
            var s = eventModal.find('select[name="event-bg"]').val();
            break;
          }
        }
      };
      var defaults = {
        header: {
          left: "prev,next,today",
          center: "title",
          right: "month,agendaWeek,agendaDay"
        },
        editable: true,
        droppable: true,
        eventLimit: true,
        navLinks: true,
        drop: function() {
          if ($('#drop-remove').is(':checked')) {
            $(this).remove();
          }
        },
        eventClick: function(calEvent,jsEvent, view) {
          $("#eventEditModal").modal('show');
          showContentInModal(calEvent);
        },
        dayClick: function(date,jsEvent, view) {
          $("#eventAddModal").modal('show');
          window.ThemeFullCalendar.EventAddMode = date;
        }
      };
      el.each(function(index){
        var $this = $(this),
          calendarOptions = $this.data('plugin-options'),
          instance = null,
          options = {};

        if( this.unifato === undefined )
          this.unifato = {};
        instance = this.unifato;

        if(calendarOptions.eventsSrc!==undefined) {
          $.ajax({
            url: calendarOptions.eventsSrc,
            dataType: "json",
            success: function(result) {
              options = $.extend({}, defaults, calendarOptions);
              options.events = result.events;
              var fullcalendar = $this.fullCalendar(options);
              instance.fullcalendar = fullcalendar[0];
            },
          });
        }
        else {
          options = $.extend({}, defaults, calendarOptions);
          var fullcalendar = $this.fullCalendar(options);
          instance.fullcalendar = fullcalendar[0];
        }

        var eventModal =
          '<div class="modal fade" id="eventEditModal" tabindex="-1" role="dialog">' +
            '<div class="modal-dialog" role="document">'+
              '<div class="modal-content">'+
                '<div class="modal-header">'+
                  '<h4 class="modal-title">Edit Event</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                  '<label for="eventName">Event Name</label>'+
                  '<input class="form-control mr-b-10" name="event-name" type="text" />'+
                  '<label for="eventType">Event Type</label>'+
                  '<select name="event-bg" class="form-control">'+
                    '<option value="danger">Danger</option>'+
                    '<option value="success">Success</option>'+
                    '<option value="info">Info</option>'+
                    '<option value="warning">Warning</option>'+
                    '<option value="color-scheme">Color Scheme</option>'+
                    '<option value="primary">Primary</option>'+
                    '<option value="pink">Pink</option>'+
                    '<option value="violet">Violet</option>'+
                    '<option value="purple">Purple</option>'+
                    '<option value="teal">Teal</option>'+
                    '<option value="slate">Slate</option>'+
                    '<option value="grey">Grey</option>'+
                    '<option value="persian-blue">Persian Blue</option>'+
                    '<option value="cerize-red">Cerize Red</option>'+
                    '<option value="mustard">Mustard</option>'+
                    '<option value="gray-light">Gray Light</option>'+
                  '</select>'+
                '</div>'+
                '<div class="modal-footer">'+
                  '<button class="btn mr-auto delete-btn btn-danger">Delete</button>'+
                  '<button class="btn save-btn btn-success">Save</button>'+
                  '<button class="btn btn-default" data-dismiss="modal">Cancel</button>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'
        ;

        if( !$('#eventEditModal').length ) {
          $('body').append(eventModal);
          var $eventEditModal = $('#eventEditModal');
          $eventEditModal.find('.delete-btn').click(function(){
            var eventId = window.ThemeFullCalendar.EventEditMode._id;
            $this.fullCalendar('removeEvents',[eventId]);
            $eventEditModal.modal('hide');
          });
          $eventEditModal.find('.save-btn').click(function(){
            var eventE = window.ThemeFullCalendar.EventEditMode;
            eventE.title = $eventEditModal.find('[name="event-name"]').val();
            eventE.className = 'bg-' + $eventEditModal.find('select[name="event-bg"]').val();
            $this.fullCalendar('updateEvent',eventE);
            $eventEditModal.modal('hide');
            window.ThemeFullCalendar.EventEditMode = null;
          });
        }

        var eventAddModal =
          '<div class="modal fade" id="eventAddModal" tabindex="-1" role="dialog">'+
            '<div class="modal-dialog" role="document">'+
              '<div class="modal-content">'+
                '<div class="modal-header">'+
                  '<h4 class="modal-title">Add Event</h4>'+
                '</div>'+
                '<div class="modal-body">'+
                  '<label for="eventName">Event Name</label>'+
                  '<input class="form-control mr-b-10" name="event-name" type="text" />'+
                  '<label for="eventType">Event Type</label>'+
                  '<select name="event-bg" class="form-control">'+
                    '<option value="danger">Danger</option>'+
                    '<option value="success">Success</option>'+
                    '<option value="info">Info</option>'+
                    '<option value="warning">Warning</option>'+
                    '<option value="color-scheme">Color Scheme</option>'+
                    '<option value="primary">Primary</option>'+
                    '<option value="pink">Pink</option>'+
                    '<option value="violet">Violet</option>'+
                    '<option value="purple">Purple</option>'+
                    '<option value="teal">Teal</option>'+
                    '<option value="slate">Slate</option>'+
                    '<option value="grey">Grey</option>'+
                    '<option value="persian-blue">Persian Blue</option>'+
                    '<option value="cerize-red">Cerize Red</option>'+
                    '<option value="mustard">Mustard</option>'+
                    '<option value="gray-light">Gray Light</option>'+
                  '</select>'+
                '</div>'+
                '<div class="modal-footer">'+
                  '<button class="btn save-btn btn-success">Save</button>'+
                  '<button class="btn btn-default" data-dismiss="modal">Cancel</button>'+
                '</div>'+
              '</div>'+
            '</div>'+
          '</div>'
        ;

        if( !$('#eventAddModal').length ) {
          $('body').append(eventAddModal);
          var $eventAddModal = $('#eventAddModal');
          $eventAddModal.find('.save-btn').click(function(){
            var event = {};
            event.title = $eventAddModal.find('input[name="event-name"]').val();
            event.className = 'bg-' + $eventAddModal.find('select[name="event-bg"]').val();

            if( window.ThemeFullCalendar.EventAddMode !== undefined && window.ThemeFullCalendar.EventAddMode !== null) {
              event.start = window.ThemeFullCalendar.EventAddMode._d;
              $this.fullCalendar('addEventSource',[event]);
              $eventAddModal.modal('hide');
              window.ThemeFullCalendar.EventAddMode = null;
            }
            else if( window.ThemeFullCalendar.EventAddListMode !== undefined && window.ThemeFullCalendar.EventAddListMode !== null) {
              var $target = window.ThemeFullCalendar.EventAddListMode.target;
              var element = '<div class="fc-event ' + event.className + '"><i class="feather feather-check color-white ' + event.className + '"></i>' + '<span class="fc-event-text">' + event.title + '</span></div>';
              $target.find('.fc-events').append(element);
              $eventAddModal.modal('hide');
              window.ThemeFullCalendar.EventAddListMode = null;
              Unifato.enableFullCalendarEvents();
            }
          });
        }
      });
    },

    enableFullCalendarEvents: function() {
      var el = $('[data-toggle="fullcalendar-events"]');
      if( !el.length ) return;
      el.each(function(index){
        var $this = $(this);
        var target = $(this).data('target');
        var events = $this.find('.fc-event');

        events.each(function(){
          $(this).data('event', {
            title: $.trim($(this).find('.fc-event-text').text()),
            stick: true,
            className: $(this).attr('class')
          });
          $(this).draggable({
            zIndex: 999,
            revert: true,
            revertDuration: 0
          });
        });

        $this.find('.fc-add-event').click(function(){
          $('#eventAddModal').modal('show');
          window.ThemeFullCalendar.EventAddListMode = { target: $this };
        });
      });
    },

    enableClndr: function() {
      var el = $('[data-toggle="clndr"]');
      if( !el.length ) return;
      el.each(function(){
        var $this = $(this);
        var $template = $this.find('script.template').html();
        var events = {};
        events.events = [];
        var instance = null;
        if( this.unifato === undefined )
          this.unifato = {};
        instance = this.unifato;

        if($this.find('.events').length) events = JSON.parse($this.find('.events').html().trim());
        instance.clndr = $this.clndr({
          template: $template,
          userTouchEvents: true,
          events: events.events,
          extras: {
            selectedDay: {},
          },
          clickEvents: {
            click: function(target) {
              this.options.extras.selectedDay = target;
              this.render();
            },
          },
          ready: function() {
            $this.find('.today').trigger('click');
          }
        });
      });
    },

    enableDataTables: function() {
      var el = $('[data-toggle="datatables"]');
      if ( !el.length ) return;
      var defaults = {
        responsive: true,
      };
      el.each(function(index) {
        var $this = $(this),
            options = $(this).data('plugin-options');
        if (options === null )
          options = {};

        if( this.unifato === undefined )
          this.unifato = {};

        options = $.extend({},defaults,options);
        this.unifato.datatable = $this.DataTable(options);
      });
    },

    enableFootable: function(){
      var el = $('[data-toggle="footable"]');
      if( !el.length ) return;
      el.each(function(){
        var $this = $(this),
            instance = null;

        if ( this.unifato === undefined )
          this.unifato = {};

        instance = this.unifato;

        if( $this.data('row-src')!== undefined && $this.data('column-src') === undefined ) {
          instance.footable = $this.footable({
            "rows": $.get('assets/js/row.json'),
          });
        }
        else if( $this.data('row-src') !== undefined && $this.data('column-src') !== undefined ) {
          instance.footable = $this.footable({
            "rows": $.get('assets/js/row.json'),
            "columns": $.get('assets/js/column.json'),
          });
        }
        else {
          instance.footable = $this.footable();
        }
      });
    },

    enableTableEditable: function() {
      var el = $('.table-editable, .table-editable-inline');
      if(!el.length) return;
      el.each(function(){
        var $this = $(this);
        var columns = $this.find('th[data-editable]');
        var columnsList = [];
        var identifier = [ $this.find('th[data-identifier]').index(), $this.find('th[data-identifier]').html() ];
        var instance = null;
        if( this.unifato === undefined )
          this.unifato = {};
        this.unifato.tabledit = this;
        columns.each(function(){
          columnsList.push([ $(this).index(), $(this).html() ]);
        });
        if( $this.hasClass('table-editable-inline') ) {
          $this.Tabledit({
            editButton: false,
            removeButton: false,
            columns: {
              editable: columnsList,
              identifier: identifier,
            }
          });
        }
        else {
          $this.Tabledit({
            columns: {
              editable: columnsList,
              identifier: identifier,
            }
          });
        }
      });
    },

    enableCountUp: function() {
      var el = document.body.getElementsByClassName('counter');

      var defaults = {
        useEasing: true,
        useGrouping: true,
      };

      if( !el.length ) return;

      function decimalPlaces(num) {
        var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        if (!match) { return 0; }
        return Math.max(
          0,
          // Number of digits right of decimal point.
          (match[1] ? match[1].length : 0)
          // Adjust for scientific notation.
          - (match[2] ? +match[2] : 0));
      }

      var counterInstanceArr = [];

      for(var i = 0; i < el.length; i++ ) {
        var counterEl = el[i];
        counterEl.id = 'counter-' + i;

        var options = counterEl.dataset;
        options = $.extend({}, defaults, options);

        var startVal = counterEl.dataset.startval !== undefined ? counterEl.dataset.startval : 0;
        var endVal = parseFloat(counterEl.innerHTML);

        var decimals = Math.max( decimalPlaces(startVal), decimalPlaces(endVal) );

        var counter = new CountUp( counterEl.id, startVal, endVal, decimals, 3, options);

        if (!counter.error) counterInstanceArr.push( counter );
        else console.error(counter.error);
      }

      $(document).on('PACE_DONE', function() {
        for( var j = 0; j < counterInstanceArr.length; j++ ) {
          counterInstanceArr[j].start();
        }
      });

      for( var i = 0; i < counterInstanceArr.length; i++ ) {
        counterInstanceArr[i].start();
      }
    },

    enableRangeSlider: function() {
      var el = $('input[data-toggle="rangeslider"]');
      if(!el.length) return;
      el.each(function() {
        var $this = $(this);
        if( this.unifato === undefined )
          this.unifato = {};

        $this.ionRangeSlider();
        this.unifato.ionRangeSlider = $this.data('ionRangeSlider');
      });
    },

    enableSortable: function() {
      var el = $('.sortable');
      if( !el.length ) return;
      el.each(function() {
        var $this = $(this);
        if( this.unifato === undefined )
          this.unifato = {};
        $this.sortable();
        this.unifato.sortable = $this.data('ui-sortable');
      });
    },

    enableNestedSortable: function() {
      var el = $('.dd');
      if( !el.length ) return;
      var defaults = {
      };
      el.each( function() {
        var $this = $(this),
            options = $this.data('plugin-options');
        options = $.extend({}, defaults, options);

        if( this.unifato === undefined )
          this.unifato = {};

        $this.nestable(options);
        this.unifato.nestable = $this.data('nestable');
      });
    },

    enableTimelineLoadMoreBtn: function() {
      var el = $('.timeline .load-more-btn');
      if( !el.length ) return;
      el.each(function(){
        var $this = $(this),
            url = $this.data('url');
        $this.on('click', function() {
          $this.addClass('loading');
          $this.addClass('disabled');
          $.ajax({
            url: url,
          }).done(function(data) {
            // just to show loading effect
            setTimeout(function() {
              $this.before(data);
              $this.removeClass('loading');
              $this.removeClass('disabled');
            }, 1000);
          }).fail(function() {
            alert("Couldn't load Timeline Content");
            $this.removeClass('loading');
          });
        });
      });
    },

    enableCarousel: function() {
      var el = document.getElementsByClassName('carousel');
      if( !el.length ) return;
      var defaults = {
        responsive: [
          {
            breakpoint: 720,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }, {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      };
      for( var i = 0; i < el.length; i++ ) {
        var $this = $(el[i]),
            options = $this.data('plugin-options');
        options = $.extend({}, defaults, options);
        var sl = $this.slick(options);

        window.addEventListener('resize', function() {
          sl.slick('resize');
        });

        $(document).on('SIDEBAR_CHANGED_WIDTH', function() {
          sl.slick('resize');
          sl.slick('slickNext');
        });
      };
    },

    enableMedia: function() {
      var el = $('video, audio');
      if(!el.length) return;
      el.each(function() {
        var $this = $(this);
        if( this.unifato === undefined )
          this.unifato = {};
        $this.mediaelementplayer({
          pluginPath: 'https://cdnjs.com/libraries/mediaelement/',
          shimScriptAccess: 'always'
        });
        if( this.tagName === 'VIDEO' ) {
          $this.on('playing', function() {
            $this.closest('.mejs__container').addClass('mejs__video--playing');
          });
          $this.on('ended', function() {
            $this.closest('.mejs__container').removeClass('mejs__video--playing');
          });
        }
        this.unifato.mediaelementplayer = $this.data('mediaelementplayer');
      });
    },

    enableInputMask: function() {
      var el = $('[data-masked-input]');
      if(!el.length) return;
      $.mask.definitions.h = "[A-Fa-f0-9]";
      $.mask.definitions['~']='[+-]';
      el.each(function() {
        var $this = $(this),
            mask = $this.data('masked-input');
        $this.mask(mask);
      });
    },

    enableDropify: function() {
      var el = $('[data-toggle="dropify"]');
      if(!el.length) return;
      el.each(function() {
        var $this = $(this);
        if( this.unifato === undefined )
          this.unifato = {};
        $this.dropify();
        this.unifato.dropify = $this.data('dropify');
      });
    },

    enableDropzone: function() {
      var el = $('[data-toggle="dropzone"]');
      if(!el.length) return;
      Dropzone.prototype.defaultOptions.addRemoveLinks = true;
      var defaults = {};
      el.each( function() {
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.dropzone(options);
        this.unifato.dropzone = this.dropzone;
        $this.addClass('dropzone');
      });
    },

    enableClockPicker: function() {
      var el = $('.clockpicker');
      if(!el.length) return;
      var defaults = {
        donetext: 'Done',
      };
      el.each(function() {
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.clockpicker(options);
        this.unifato.clockpicker = $this.data('clockpicker');
      });
    },

    enableColorPicker: function() {
      var el = $('.colorpicker');
      if(!el.length) return;
      var defaults = {
        preferredFormat: "rgb",
        showInput: true,
        change: function(color) {
          var $this = $(this);
          $this.parent().find('input').val( color );
          $this.find('i').css( 'background', color );
        },
      };
      el.each(function() {
        var $this = $(this),
            options = $this.data('plugin-options'),
            value = $this.find('input').val();
        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        options.color = value;
        $this.find('.input-group-addon').spectrum(options).find('i').css('background', value);
        $this.find('input').click( function(e) {
          $this.find('.input-group-addon').spectrum('toggle');
          return false;
        });
      });
    },

    enableDateRangePicker: function() {
      var el = $('.daterange');
      if( !el.length ) return;
      var defaults = {
        locale: {
          format: 'MMMM D',
        },
      };
      el.each(function(){
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.daterangepicker(options);
        this.unifato.daterangepicker = $this.data('daterangepicker');
      });
    },

    enablePredefinedDateRangePicker: function() {
      var $el = $('.predefinedRanges');
      if ( !$el.length ) return;
      var defaults = {
        locale: {
          format: 'MMMM-D',
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        opens: "left",
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      };
      $el.each( function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        var $this = $(this);
        var options = $this.data('plugin-options');
        options = $.extend({}, defaults, options);
        function cb(start, end) {
          $this.find('span').html(start.format(options.locale.format) + ' - ' + end.format(options.locale.format));
        }

        if( this.unifato === undefined )
          this.unifato = {};

        $this.daterangepicker(options, cb);
        this.unifato.daterangepicker = $this.data('daterangepicker');
        cb(start, end);
      });
    },

    enableDatePicker: function() {
      var el = $('.datepicker');
      if( !el.length ) return;
      var defaults = {
      };
      el.each(function(){
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.datepicker(options);
        this.unifato.datepicker = $this.data('datepicker');
      });
    },

    enableSelect2: function() {
      var el = $('[data-toggle="select2"]');
      if(!el.length) return;
      el.each( function() {
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        $this.select2(options);
        this.unifato.select2 = $this.data('select2');
      });
    },

    enableSwitchery: function() {
      var elems = document.getElementsByClassName('js-switch');
      if( !elems.length ) return;
      var defaults = {
        secondaryColor: '#ddd',
      };
      for(var i=0; i < elems.length; i++ ) {
        var dataset = JSON.parse(JSON.stringify(elems[i].dataset));
        dataset = $.extend({}, defaults, dataset);
        var jsSwitch = new Switchery(elems[i], dataset);
        if( elems[i].unifato === undefined )
          elems[i].unifato = {};

        elems[i].unifato.switchery = jsSwitch;
      }

    },

    enableTouchspin: function() {
      var el = $('[data-toggle="touchspin"]');
      if(!el.length) return;
      var defaults = {
        verticalupclass: '',
        verticaldownclass: ''
      };
      el.each(function() {
        var $this = $(this),
            options = $this.data('plugin-options');

        if(options===undefined) options = {};
        options = $.extend({}, defaults, options);
        $this.TouchSpin(options);
      });
    },

    enableMultiSelect: function() {
      var el = $('[data-toggle="multiselect"]');
      if(!el.length) return;
      this.enableMultiSelectBtns();
      el.each(function() {
        var $this = $(this);
        if( this.unifato === undefined )
          this.unifato = {};
        this.unifato.multiselect = $this.multiSelect();
      });
    },

    enableMultiSelectBtns: function() {
      var el = $('[data-multiselect-target]');
      if(!el.length) return;
      el.each(function() {
        var $this = $(this),
            $targetData = $this.data('multiselect-target'),
            $method = $this.data('multiselect-method'),
            $event = $this.data('event');

        var $target = $( $targetData );
        $this.on( $event, function(e) {
          e.preventDefault();

          switch ( $method ) {
            case "addOption":
              $target.multiSelect( 'addOption', { value: 'test', text: 'test', index: 0, nested: 'optgroup_label' });
              break;
            default:
              $target.multiSelect( $method );
          }
        });
      });
    },

    enableTinyMCE: function() {
      this.enableTinyMCEInline();
      var el = $('[data-toggle="tinymce"]');
      if(!el.length) return;
      var defaults = {
        skin: "lightgray",
      };
      el.each(function() {
        var $this = $(this),
            options = $this.data('plugin-options');


        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);

        $this.tinymce(options);
      });
    },

    enableTinyMCEInline: function() {
      var el = $('[data-toggle="tinymce-inline"]');
      if( !el.length ) return;
      var defaults = {
        skin: "lightgray",
        inline: true,
        theme: "inlite",
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste'
        ],
      };
      el.each(function() {
        var $this = $(this),
            $html = $this.html(),
            options = $this.data('plugin-options');

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.tinymce(options);
      });
    },

    enableBootstrapWysiwyg: function() {
      this.enableTinyMCEInline();
      var el = $('[data-toggle="wysiwyg"]');
      if(!el.length) return;
      var defaults = {
      };
      el.each(function() {
        var $this = $(this),
            options = $this.data('plugin-options');

        if( this.unifato === undefined )
          this.unifato = {};

        if( options === undefined ) options = {};
        options = $.extend({}, defaults, options);
        $this.wysihtml5(options);
        this.unifato.wysihtml5 = $this.data('wysihtml5');
      });
      $('[data-wysihtml5-dialog]').on('hidden.bs.modal', function(){
        $('.modal-backdrop').remove();
      });
    },

    enableCircleProgress: function() {
      var el = $('[data-toggle="circle-progress"]');
      if( !el.length ) return;
      el.each(function() {
        $(this).circleProgress();
      });
    },

    enableSparkline: function() {
      var el = $('[data-toggle="sparklines"]');
      if( !el.length ) return;
      el.each(function() {
        $(this).sparkline('html', { enableTagOptions: true });
      });
    },
  };

  document.addEventListener('DOMContentLoaded', function() {
    Pace.options = {
      ajax: {
        ignoreURLs: [
          'assets/vendors/theme-widgets/getTwitterFeed', 
          'assets/vendors/theme-widgets/getFacebookFeed'
        ],
      }
    }
    Unifato.init();
    Unifato.setMenu();
  });

  window.addEventListener('resize', Unifato.setMenu);
  window.addEventListener('resize', Unifato.contentHeight);
})(jQuery);
