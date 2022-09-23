$(function() {

    var currentDate; // Holds the day clicked when adding a new event
    var currentEvent; // Holds the event object when editing an event
    $('#color').colorpicker(); // Colopicker
    var base_url=baseurl; // Here i define the base_url
    // Fullcalenda
    var initialLocaleCode = 'en';
    if(localStorage.getItem('myCal'))  initialLocaleCode = localStorage.getItem('myCal');

    function fetcheventdata() {
		var httpRequest = new XMLHttpRequest();
		httpRequest.open('GET',base_url+'events/getEvents'); // 
		httpRequest.send();
		httpRequest.responseText;
	}
	
	//ok thanks. bye bye
	

    var REPEAT_MONTHLY = 3;
    var REPEAT_YEARLY = 4;
    $('#calendar').fullCalendar({
        locale:initialLocaleCode,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
		
		//you see return events. 
        // Get all events stored in database
        eventLimit: true, // allow "more" link when too many events
        events: base_url+'events/getEvents',
        selectable: true,
        selectHelper: true,
        editable: true, // Make the event resizable true   
        /*dayRender: function( date, cell ) {
		
			var eventdata = $('#calendar').fullCalendar('clientEvents').length ? $('#calendar').fullCalendar('clientEvents') : fetcheventdata(); //this its one function for get all events. but not return
			console.log(events); //But this its null or empty
			//Start of a day timestamp
			var dateTimestamp = date.hour(0).minutes(0);
			var recurringEvents = new Array();
				//find all eventdata with monthly repeating flag, having id, repeating at that day few months ago  
				var monthlyEvents = eventdata.filter(function (event) {
					return event.event_repeat === REPEAT_MONTHLY && event.id && moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'months', true) % 1 == 0
				});
				//find all eventdata with monthly repeating flag, having id, repeating at that day few years ago  
				var yearlyEvents = eventdata.filter(function (event) {
					return event.event_repeat === REPEAT_YEARLY && event.id && moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'years', true) % 1 == 0
				});
				recurringEvents = monthlyEvents.concat(yearlyEvents);
				$.each(recurringEvents, function(key, event) {
				var timeStart = moment(event.start);  
				var currentDate = $('#calendar').fullCalendar('getDate');
				var calDate = currentDate.format('DD.MM.YYYY');
				console.log(calDate);
				//Refething event fields for event rendering 
				var eventData = {
					id: event.id,
					allDay: event.allDay,
					title: event.title,
					description: event.description,
					start: date.hour(timeStart.hour()).minutes(timeStart.minutes()).format("YYYY-MM-DD"),
					end: event.end ? event.end.format("YYYY-MM-DD") : "",
					url: event.url,
					className: 'scheduler_basic_event',
					repeat: event.event_repeat
				};
		
				//Removing events to avoid duplication
				$('#calendar').fullCalendar( 'removeEvents', function (event) {
					return eventData.id === event.id && moment(event.start).isSame(date, 'day');      
				});
				//Render event
				$('#calendar').fullCalendar('renderEvent', eventData, true);
			}); 
		  },*/
        select: function(start, end) {
            $('#start_date').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            $('#end_date').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            $('#start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            // Open modal to add event
            modal({
                // Available buttons when adding
                buttons: {
                    add: {
                        id: 'add-event', // Buttons id
                        css: 'btn-success', // Buttons class
                        label: 'Add' // Buttons label
                    }
                },
                title: 'Add Event' // Modal title
            });
        },

        eventDrop: function(event, delta, revertFunc,start,end) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end) {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }
            $.post(base_url+'events/dragUpdateEvent',  'id='+event.id+'&start='+start+'&end='+end+'&'+crsf_token+'='+crsf_hash, function(result){
                $('.alert').addClass('alert-success').text('Event updated successful');
                $('.modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                hide_notify();
            });
        },

        eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }
            $.post(base_url+'events/dragUpdateEvent',  'id='+event.id+'&start='+start+'&end='+end+'&'+crsf_token+'='+crsf_hash, function(result){
                $('.alert').addClass('alert-success').text('Event updated successful');
                $('.modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                hide_notify();
            });
        },
        // Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view) {
            var tooltip = '<div class="event-tooltip"><strong>Título: ' + calEvent.title + '</strong><br>Obs: '+ calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        },

        // Handle Existing Event Click
        eventClick: function(calEvent, jsEvent, view) {
            // Set currentEvent variable according to the event clicked in the calendar
            currentEvent = calEvent;
            // Open modal to edit or delete event
            modal({
                // Available buttons when editing
                buttons: {
                    delete: {
                        id: 'delete-event',
                        css: 'btn-danger',
                        label: 'Delete'
                    },
                    update: {
                        id: 'update-event',
                        css: 'btn-success',
                        label: 'Update'
                    }
                },
                title: 'Edit Event "' + calEvent.title + '"',
                event: calEvent
            });
        }
    });
    // Prepares the modal window according to data passed

    function modal(data) {
        // Set modal title
        $('.modal-title').html(data.title);
        // Clear buttons except Cancel
        $('.modal-footer button:not(".btn-default")').remove();
        // Set input values
        $('#title').val(data.event ? data.event.title : '');
        $('#description').val(data.event ? data.event.description : '');
        $('#color').val(data.event ? data.event.color : '#3a87ad');
        $('#event_type').val(data.event ? data.event.event_type : '0');
		$('#event_repeat').val(data.event ? data.event.event_repeat : '0');
		$('#event_associated').val(data.event ? data.event.event_associated : '0');
        if (data.event) {
            $('#start_date').val(data.event.start ? data.event.start._i : '0');
            $('#end_date').val(data.event.end ? data.event.end._i : '0');
        }
        $('#employee_id').val(data.event ? data.event.employee_id : '0');
        // Create Butttons
        $.each(data.buttons, function(index, button){
            $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
        })
        //Show Modal
        $('.modal').modal('show');
    }
    // Handle Click on Add Button
    $('.modal').on('click', '#add-event',  function(e){
        if(validator(['title', 'description'])) {
            $.post(base_url+'events/addEvent',
				'title='+$('#title').val()+'&description='+$('#description').val()+'&event_type='+$('#event_type').val()+'&event_repeat='+$('#event_repeat').val()+'&event_associated='+$('#event_associated').val()+'&employee_id='+$('#employee_id').val()+'&color='+$('#color').val()+'&start='+$('#start').val()+'&end='+$('#end').val()+'&'+crsf_token+'='+crsf_hash , function(result){
				var result = JSON.parse(result)
				$('.alert').addClass('alert-success').text(result.message);
				$('.modal').modal('hide');
				$('#calendar').fullCalendar("refetchEvents");
				hide_notify();
			});
        }
    });

    // Handle click on Update Button

    $('.modal').on('click', '#update-event',  function(e){
        if(validator(['title', 'description'])) {
            $.post(base_url+'events/updateEvent',  'id='+currentEvent.id+'&title='+$('#title').val()+'&description='+$('#description').val()+'&event_type='+$('#event_type').val()+'&event_repeat='+$('#event_repeat').val()+'&event_associated='+$('#event_associated').val()+'&employee_id='+$('#employee_id').val()+'&color='+$('#color').val()+'&'+crsf_token+'='+crsf_hash, function(result){
                $('.alert').addClass('alert-success').text('Event updated successful');
                $('.modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                hide_notify();
            });
        }
    });

    $.each($.fullCalendar.locales, function (localeCode) {
        $('#lang-selector').append(
            $('<option/>')
                .attr('value', localeCode)
                .prop('selected', localeCode == initialLocaleCode)
                .text(localeCode)
        );
    });

    // when the selected option changes, dynamically change the calendar option
    $('#lang-selector').on('change', function () {
        if (this.value) {
            $('.calendar').fullCalendar('option', 'locale', this.value);
            localStorage.setItem('myCal', this.value);
        }
    });

//hide color
    $("#link_to_cal").change(function ()
    {
        $('#hidden_div').show();
    });
	
    // Handle Click on Delete Button
    $('.modal').on('click', '#delete-event',  function(e){
        $.get(base_url+'events/deleteEvent?id=' + currentEvent.id, function(result){
            $('.alert').addClass('alert-success').text('Event deleted successful !');
            $('.modal').modal('hide');
            $('#calendar').fullCalendar("refetchEvents");
            hide_notify();
        });
    });

    function hide_notify()
    {
        setTimeout(function() {$('.alert').removeClass('alert-success').text('');
        }, 2000);
    }
	
    // Dead Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function(index, element){
            if($.trim($('#' + element).val()) == '') 
				errors++;
        });
        if(errors) {
            $('.error').html('Please insert title and description');
            return false;
        }
        return true;
    }
	
    $('#attendances').fullCalendar({
        locale:initialLocaleCode,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        // Get all events stored in database
        eventLimit: true, // allow "more" link when too many events
        events: base_url+'user/getAttendances',
        selectable: false,
        selectHelper: false,
        editable: false, // Make the event resizable true
        select: function(start,end) {
            $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
            $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
        },
		// Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view) {
            var tooltip = '<div class="event-tooltip"><strong>Título: ' + calEvent.title + '</strong><br>Obs: '+ calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        }
    });

    $('#holidays').fullCalendar({
        locale:initialLocaleCode,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        // Get all events stored in database
        eventLimit: true, // allow "more" link when too many events
        events: base_url+'user/getHolidays',
        selectable: false,
        selectHelper: false,
        editable: false, // Make the event resizable true
        select: function(start,end) {
            $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
            $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
        },
		// Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view) {
            var tooltip = '<div class="event-tooltip"><strong>Título: ' + calEvent.title + '</strong><br>Obs: '+ calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        }
    });

	$('#faults').fullCalendar({
        locale:initialLocaleCode,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        // Get all events stored in database
        eventLimit: true, // allow "more" link when too many events
        events: base_url+'user/getFaults',
        selectable: false,
        selectHelper: false,
        editable: false, // Make the event resizable true
        select: function(start,end) {
            $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
            $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
        },
		// Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view) {
            var tooltip = '<div class="event-tooltip"><strong>Título: ' + calEvent.title + '</strong><br>Obs: '+ calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        }
    });

	$('#vacations').fullCalendar({
        locale:initialLocaleCode,
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        // Get all events stored in database
        eventLimit: true, // allow "more" link when too many events
        events: base_url+'user/getVacations',
        selectable: false,
        selectHelper: false,
        editable: false, // Make the event resizable true
        select: function(start,end) {
            $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
            $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
        },
		// Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view) {
            var tooltip = '<div class="event-tooltip"><strong>Título: ' + calEvent.title + '</strong><br>Obs: '+ calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                $('.event-tooltip').css('top', e.pageY + 10);
                $('.event-tooltip').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        }
    });
});



