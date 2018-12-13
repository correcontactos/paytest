$(document).ready(function(){
	
	$('#pse').click(function(){
		$('#interface1').css('visibility','visible');
		$('#interface1').fadeOut(8000);
		$('#interface2').css('visibility','visible');
		$('#payinfo').css('visibility','visible');
	});
	
	$('#card').click(function(){
		$('#interface1').css('visibility','collapse');
		$('#interface2').css('visibility','collapse');
		$('#payinfo').css('visibility','collapse');
		alert('Modo de pago NO habilitado');
	});
	
	$('#go1').click(function(){
		
		var result='';
		
		if($('#bankInterface').val() == '')
			result += '<br> - Tipo de Interfaz';
		
		if($('#bankCode').val() == '')
			result += '<br> - Banco';
		
		if($('#reference').val() == '')
			result += '<br> - Referencia';
		
		if($('#totalAmount').val() == '')
			result += '<br> - Cantidad';
		
		if(result != '')
		{
			// $('#go-alert').css('visibility', 'visible');
			$('#go-alert').html('Debe seleccionar : '+ result);
			$('#go-alert').fadeIn(1000);
			$('#go-alert').fadeOut(5000);
		}
		else
		{
			var data = '_token='+$('[name="_token"]').val();
			data += '&bankInterface='+$('#bankInterface').val();
			data += '&bankCode='+$('#bankCode').val();
			data += '&reference='+$('#reference').val();
			data += '&totalAmount='+$('#totalAmount').val();
			data += '&payer='+$('#payer').val();
			data += '&buyer='+$('#buyer').val();
			
			$.ajax({
				method: 'POST',
				url: '../../step2',
				data: data
			})
			.done(function(msg){
				$('#result').html('');
				$('#result').html(msg.result);
				$('#result2').html('');
				$('#result2').html(msg.result2);
				
				if( msg.result3.returnCode == 'SUCCESS')
					$(location).attr('href', msg.result3.bankURL);				
			})
			;
		}
	});
});
