<?php
	session_start();	
	if(!isset($_SESSION['usuario']))
		header('Location: index.php?erro=1');
?>
<!-- jquery - link cdn -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- script local -->
<script src="calendario.js"></script>

<!-- bootstrap - link cdn -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- css local -->
<link rel="stylesheet" href="calendario.css">

<!------ Include the above in your HEAD tag --------->

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Compartilhamento de Contatos</title>

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

<script>

	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		/*  className colors
		
		className: default(transparent), important(red), chill(pink), success(green), info(blue)
		
		*/		
		
		  
		/* initialize the external events
		-----------------------------------------------------------------*/
	
		$('#external-events div.external-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	
	
		/* initialize the calendar
		-----------------------------------------------------------------*/
		var lembretes;
		$.ajax({
			url: 'get_eventos.php',
			success: function(data){
				lembretes = JSON.parse(data);
				var calendar =  $('#calendar').fullCalendar({
				header: {
					left: 'title',
					center: 'agendaDay,agendaWeek,month',
					right: 'prev,next today'
				},
				editable: true,
				firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
				selectable: true,
				defaultView: 'month',
				
				axisFormat: 'h:mm',
				columnFormat: {
					month: 'ddd',    // Mon
					week: 'ddd d', // Mon 7
					day: 'dddd M/d',  // Monday 9/7
					agendaDay: 'dddd d'
				},
				titleFormat: {
					month: 'MMMM yyyy', // September 2009
					week: "MMMM yyyy", // September 2009
					day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
				},
				allDaySlot: false,
				selectHelper: true,
				select: function(start, end, allDay) {
					
					var title = prompt('Título do Evento:');
					if (title) {
						if(ad_periodo.checked){//Altera data 'end' do evento
							if(allDay){
								var temp = prompt('Dias de Duração do Evento:', '1');
								var duracao = duracao = Number(temp);
								if(!duracao){
									while(temp = prompt('Digite um número válido de Dias:', '1')){
										duracao =  Number(temp);
										if(duracao) break;
									}
																
								}
								if(duracao > 0 ){
									duracao--;
								}
								fim = Date.parse(start);		
								duracao *= 86400000;
								fim += duracao;
								end = new Date(fim);
								alert(end);	
							} else{
								var temp = prompt('Horas de Duração do Evento:', '1');
								var duracao = duracao = Number(temp);
								if(!duracao){
									while(temp = prompt('Digite um número válido de Horas:', '1')){
										duracao =  Number(temp);
										if(duracao) break;
									}
															
								}
								
								fim = Date.parse(start);		
								duracao *= 3600000;
								fim += duracao;
								end = new Date(fim);
								//alert(end);	
							}
							
						}
						
						
						
						$.ajax({
							url: 'registra_lembrete.php',
							method: 'POST',
							data: {
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							success: function(data){
								if(data != '0'){
									//alert(data);
									calendar.fullCalendar('renderEvent',
									{
										id: data,
										title: title,
										start: start,
										end: end,
										allDay: allDay
									},
									false // make the event "stick"
							
						);
								}
							}
						});
					}
					calendar.fullCalendar('unselect');
				},
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped
				
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
					
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
					
					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;
					
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}
					
				},
				eventDrop: function(info){
					//alert(info.id);
					$.ajax({
						url: 'modifica_lembretes.php',
						method: 'POST',
						data:{
								inicio:info.start,
								fim:info.end,
								id:info.id
							},
						success: function(i){
							alert(i);
						}
					});
				},
				
				events: lembretes ? lembretes : [],			
			});
			}
		});
		
		
		
		
	});

</script>
<style>

	body {
	    margin-bottom: 40px;
		margin-top: 0px;
		text-align: center;
		font-size: 14px;
		font-family: 'Roboto', sans-serif;
		}
		
	#wrap {
		width: 1100px;
		margin: 0 auto;
		}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;
		}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
		}
		
	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
		}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
		}

	#calendar {
/* 		float: right; */
        margin: 0 auto;
		width: 900px;
		background-color: #FFFFFF;
		  border-radius: 6px;
        box-shadow: 0 1px 2px #C3C3C3;
		-webkit-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
-moz-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
		}

</style>
</head>
<body style="background-image: linear-gradient(to left, white, lightgray);">

	<!-- Static navbar -->
	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<img src="http://localhost/agenda_3.0/imagens/agenda.png" />
			<a href="../meus_dados.php">
			<?php
					echo 'Bem vindo(a) '. $_SESSION['usuario'];
			?>
			</a>
		</div>

		
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="#">
					<input type="checkbox" name="periodo" id="id_periodo">	
					<lable>Adicionar Preriodo</lable>
				</a>
			</li>
			<li><a href="../home.php">Home</a></li>
			<li><a href="../sair.php">Sair</a></li>
			</ul>
		</div><!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">
		
		<div class="col-md-12">
			<div id='wrap'>
				<div id='calendar'></div>
				<div style='clear:both'></div>
			</div>
		
		</div>
		
	</div>	
	
	<div id="teste">oi</div>
</body>
</html>
<script>
	ad_periodo = document.getElementById('id_periodo');
</script>

