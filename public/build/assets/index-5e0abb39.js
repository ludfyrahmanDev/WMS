(function(){$(".full-calendar").each(function(){new Calendar(this,{plugins:[interactionPlugin,dayGridPlugin,timeGridPlugin,listPlugin],droppable:!0,headerToolbar:{left:"prev,next today",center:"title",right:"dayGridMonth,timeGridWeek,timeGridDay,listWeek"},initialDate:"2021-01-12",navLinks:!0,editable:!0,dayMaxEvents:!0,events:[{title:"Vue Vixens Day",start:"2021-01-05",end:"2021-01-08"},{title:"VueConfUS",start:"2021-01-11",end:"2021-01-15"},{title:"VueJS Amsterdam",start:"2021-01-17",end:"2021-01-21"},{title:"Vue Fes Japan 2019",start:"2021-01-21",end:"2021-01-24"},{title:"Laracon 2021",start:"2021-01-24",end:"2021-01-27"}],drop:function(e){$("#checkbox-events").length&&$("#checkbox-events")[0].checked&&($(e.draggedEl).parent().remove(),$("#calendar-events").children().length==1&&$("#calendar-no-events").removeClass("hidden"))}}).render()})})();
