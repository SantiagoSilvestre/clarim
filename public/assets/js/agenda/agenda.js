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
      //googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

      // US Holidays
      events: '/clarim/eventos',

      eventClick: function(info) {
        info.jsEvent.preventDefault();
        $("#salvarEvent").prop('disabled', true);
        var data = info.event.extendedProps.data;
        var stringData  = retornaDataFormat(data);
        let hstart = getHorario(info.event.start.toLocaleString());
        let hend = getHorario(info.event.end.toLocaleString());
        $("#id").val(info.event.id);
        $('#title').val(info.event.title);
        $('#dataEdit').val(stringData);
        $('#mtime1').val(info.event.extendedProps.time1);
        $('#gol1').val(info.event.extendedProps.gol1);
        $('#mtime2').val(info.event.extendedProps.time2);
        $('#gol2').val(info.event.extendedProps.gol2);
        $("#start").val(hstart);
        $("#end").val(hend);
        $('#visualizar').modal('show');
      },

      selectable: true,
      select: function(info) {

        var dataEvent = info.start.toLocaleString();
       
        $.ajax({
          type: "POST",
          url: "/clarim/buscarHorarios",
          data: {
            'dataEvent': dataEvent
          },
          error: function error(data) {
            console.log(data);
        },
          success: function (data) {
            $("#horario").empty();
            var horarios = JSON.parse(data);
            horarios.forEach(element => {
              $("#horario").append('<option value='+element.id+'>'+element.horario+'</option>');   
            });
          }
        });

        //alert('Ínicio do evento ' + info.start.toLocaleString());
        $("#dataEvent").val(info.start.toLocaleString());
        $("#cadastrar").modal('show');
      },

      loading: function(bool) {
        document.getElementById('loading').style.display =
          bool ? 'block' : 'none';
      }

    });

    calendar.render();
    
    $("#cadEvent").on('click', function(event) {
   
        var title = $("#titulo").val();
        let horario = $("#horario").val();
        let time1 = $("#time1").val();
        let time2 = $("#time2").val();
        let dataEvent = $("#dataEvent").val();
      event.preventDefault();
      $.ajax({
        type: "POST",
        url: "/clarim/cadEventos",
        data: {
          'title': title,
          'horario': horario,
          'time1': time1,
          'time2': time2,
          'dataEvent': dataEvent
        }, 
        error: function error(data) {
          console.log(data);
      },
        success: function (retorna) {
            if (retorna['sit']) {
                $("#msg-cad").html(retorna['msg']);
                //location.reload();
            } else {
                $("#msg-cad").html(retorna['msg']);
            }
        }
      });
    });

    $("#editEvent").on('click', function(event) {
      event.preventDefault();
      $("#title").removeAttr('readonly', 'readonly');
      $("#mtime1").removeAttr('readonly', 'readonly');
      $("#mtime2").removeAttr('readonly', 'readonly');
      $("#gol1").removeAttr('readonly', 'readonly');
      $("#gol2").removeAttr('readonly', 'readonly');
      $("#salvarEvent").prop('disabled', false);
    });

    $("#salvarEvent").on('click', function(event) {
      var title = $("#title").val();
      let time1 = $("#mtime1").val();
      let time2 = $("#mtime2").val();
      let gol1 = $("#gol1").val();
      let gol2 = $("#gol2").val();
      let id = $("#id").val();
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "/clarim/salvaEventos",
      data: {
        'title': title,
        'gol1': gol1,
        'time1': time1,
        'time2': time2,
        'gol2': gol2,
        'id' : id
      }, 
      error: function error(data) {
        console.log(data);
    },
      success: function (retorna) {

          
          if (retorna['sit']) {
              $("#msg-salv").html(retorna['msg']);
              //location.reload();
          } else {
              $("#msg-salv").html(retorna['msg']);
          }
          
      }
    });
    });
      
  });

  function retornaDataFormat(data) {
    var arrayData =  data.split(" ");
    var dataSepara = arrayData[0].split("-");
    let cont = dataSepara.length;
    var string = "";
    while (cont > 0) {
      if(string.length == 0) {
        string = dataSepara[cont -1];
      } else {
        string = string +"/"+dataSepara[cont -1];
      }
      cont --;
    }
    return string;
  }

  function getHorario(horario) {
    let array_hora = horario.split(" ");
    return array_hora[1];
  }
