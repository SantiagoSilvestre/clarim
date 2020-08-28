document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listYear'
      },

      displayEventTime: false, // don't show the time column in list view

      // THIS KEY WON'T WORK IN PRODUCTION!!!
      // To make your own Google API key, follow the directions here:
      // http://fullcalendar.io/docs/google_calendar/
      googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

      // US Holidays
      events: '/clarim/eventos',
      //events: 'en.usa#holiday@group.v.calendar.google.com',

      eventClick: function(info) {
        info.jsEvent.preventDefault();

        $('#visualizar #id').text(info.event.id);
        $('#visualizar #title').text(info.event.title);
        $('#visualizar #start').text(info.event.start.toLocaleString());
        $('#visualizar #end').text(info.event.end.toLocaleString());
        $('#visualizar').modal('show');
      },

      selectable: true,
      select: function(info) {
        //alert('Ínicio do evento ' + info.start.toLocaleString());
        $("#cadastrar").modal('show');
      },

      loading: function(bool) {
        document.getElementById('loading').style.display =
          bool ? 'block' : 'none';
      }

    });

    calendar.render();
  });