@extends('layouts.app')

@section('content')
			
			<div class="row align-items-start">
				<div class="col" style='background-color:#707070;'>
					<b>Pagador</b>
					<form action='step2' method='post'>
					{{ csrf_field() }}
					<div class="form-group row" >
						<div class="form-group col-md-6">
							<label for="documentPayer" class="col-sm-2 col-form-label-sm">Documento</label>
							<div class="col-sm-10">
								<input id='documentPayer' name='documentPayer' value="{{$info['payer']->document}}" type="text" class="form-control form-control-sm" placeholder="Ingrese documento" required>
								@if ($errors->has('documentPayer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('documentPayer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="documentTypePayer" class="col-sm-2 col-form-label-sm">Tipo_De_Documento</label>
							<div class="col-sm-10">
								<select id='documentTypePayer' name='documentTypePayer' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione tipo de documento...</option>
								  <option value="CC" @if($info['payer']->documentType == 'CC') selected @endif >Cédula Ciudadanía</option>
								  <option value="CE" @if($info['payer']->documentType == 'CE') selected @endif >Cédula Extranjería</option>
								  <option value="TI" @if($info['payer']->documentType == 'TI') selected @endif >Tarjeta Identidad</option>
								  <option value="PPN" @if($info['payer']->documentType == 'PPN') selected @endif >Pasaporte</option>
								  <option value="NIT" @if($info['payer']->documentType == 'NIT') selected @endif >Número Identificación Tributaria</option>
								  <option value="SSN" @if($info['payer']->documentType == 'SSN') selected @endif >Social Security Number</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="firstNamePayer" class="col-sm-2 col-form-label-sm">Nombres</label>
							<div class="col-sm-10">
								<input id='firstNamePayer' name='firstNamePayer' type="text" value="{{$info['payer']->firstName}}" class="form-control form-control-sm" placeholder="Ingrese nombres" required>
								@if ($errors->has('firstNamePayer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('firstNamePayer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="lastNamePayer" class="col-sm-2 col-form-label-sm">Apellidos</label>
							<div class="col-sm-10">
								<input id='lastNamePayer' name='lastNamePayer' type="text" value="{{$info['payer']->lastName}}" class="form-control form-control-sm" placeholder="Ingrese apellidos" required>
								@if ($errors->has('lastNamePayer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('lastNamePayer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="col" style='background-color:#D7D7D7;'>
					<b>Comprador</b>
					<div class="form-group row" >
						<div class="form-group col-md-6">
							<label for="documentBuyer" class="col-sm-2 col-form-label-sm">Documento</label>
							<div class="col-sm-10">
								<input id='documentBuyer' name='documentBuyer' value="{{$info['buyer']->document}}" type="text" class="form-control form-control-sm" placeholder="Ingrese documento" required>
								@if ($errors->has('documentBuyer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('documentBuyer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="documentTypeBuyer" class="col-sm-2 col-form-label-sm">Tipo_De_Documento</label>
							<div class="col-sm-10">
								<select id='documentTypeBuyer' name='documentTypeBuyer' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione tipo de documento...</option>
								  <option value="CC" @if($info['buyer']->documentType == 'CC') selected @endif >Cédula Ciudadanía</option>
								  <option value="CE" @if($info['buyer']->documentType == 'CE') selected @endif >Cédula Extranjería</option>
								  <option value="TI" @if($info['buyer']->documentType == 'TI') selected @endif >Tarjeta Identidad</option>
								  <option value="PPN" @if($info['buyer']->documentType == 'PPN') selected @endif >Pasaporte</option>
								  <option value="NIT" @if($info['buyer']->documentType == 'NIT') selected @endif >Número Identificación Tributaria</option>
								  <option value="SSN" @if($info['buyer']->documentType == 'SSN') selected @endif >Social Security Number</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="firstNameBuyer" class="col-sm-2 col-form-label-sm">Nombres</label>
							<div class="col-sm-10">
								<input id='firstNameBuyer' name='firstNameBuyer' value="{{$info['buyer']->firstName}}" type="text" class="form-control form-control-sm" placeholder="Ingrese nombres" required>
								@if ($errors->has('firstNameBuyer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('firstNameBuyer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="lastNameBuyer" class="col-sm-2 col-form-label-sm">Apellidos</label>
							<div class="col-sm-10">
								<input id='lastNameBuyer' name='lastNameBuyer' value="{{$info['buyer']->lastName}}" type="text" class="form-control form-control-sm" placeholder="Ingrese apellidos" required>
								@if ($errors->has('lastNameBuyer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('lastNameBuyer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class='col' style='background-color:#B0B0B0;'>
					<b>Pago</b>
					<div>
						<button id='pse' type="button" class="btn btn-primary">PSE</button>
						<button id='card' type="button" class="btn btn-primary">TARJETA</button>
					</div>
					<div id='interface1' class="form-group row" style='visibility:collapse;' >
						@if ($info['wserror'] == 2)
							<div class="alert alert-danger">
								No se pudo obtener la lista de entidades financieras,
								<br>por favor intente más tarde
							</div>
						@endif
					</div>
					<div id='interface2' class="form-group row" style='visibility:collapse;' >
						<div class="form-group col-md-5">
							<label for="bankInterface" class="col-sm-2 col-form-label-sm">Tipo_de_Interfaz</label>
							<div class="col-sm-10">
								<select id='bankInterface' name='bankInterface' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione...</option>
								  <option value="1">Personas</option>
								  <option value="2">Empresas</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-7">
							<label for="bankCode" class="col-sm-2 col-form-label-sm">Banco</label>
							<div class="col-sm-60">
								<select id='bankCode' name='bankCode' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione...</option>
								  @foreach( $info['banks'] as $bank )
								  <option value="{{$bank->getbankCode()}}" {{-- @if ( $bank->getbankCode() == 1022 ) selected @endif --}} >{{$bank->getbankName()}}</option>
								  @endforeach
								</select>
							</div>
						</div>
					</div>
					<div id='payinfo' class="form-group row" style='visibility:collapse;' >
						<div class="form-group col-md-5">
							<label for="reference" class="col-sm-2 col-form-label-sm">Referencia</label>
							<div class="col-sm-10">
								<select id='reference' name='reference' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione...</option>
								  <option value="P">Pago</option>
								  <option value="F">Factura</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-5">
							<label for="totalAmount" class="col-sm-2 col-form-label-sm">Cantidad</label>
							<div class="col-sm-10">
								<select id='totalAmount' name='totalAmount' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione...</option>
								  <option value="1000">$1.000</option>
								  <option value="5000">$5.000</option>
								  <option value="10000">$10.000</option>
								  <option value="100000">$100.000</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-3">
							<button id='go1' type="button" class="btn btn-primary">Enviar</button>
						</div>
						<!--<div class="form-group col-md-3">
							<button id='go2' type="submit" class="btn btn-primary">Enviar</button>
						</div>-->
						<div class="form-group col-md-9">
							<div id='go-alert' class="alert alert-danger" role="alert" style='display:none;'>
							</div>
						</div>
					</div>
					<input type='hidden' id='buyer' name='buyer' value="{{$info['buyer']->id}}">
					<input type='hidden' id='payer' name='payer' value="{{$info['payer']->id}}">
					</form>
				</div>
			</div>
				</div>
			</div>
			<div id='result2' class="row align-items-start" style='padding-top:20px;'></div>
			<div id='result' class="row align-items-start" style='padding-top:20px;'>
				<!--<div class="col" style='background-color:#707070;'>
					<b>Pagador</b>
					<div class="form-group row" >
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
					</div>
				</div>
				<div class="col" style='background-color:#D7D7D7;'>
					<b>Comprador</b>
					<div class="form-group row" >
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
					</div>
				</div>
				<div class='col' style='background-color:#B0B0B0;'>
					<b>Pago</b>
					<div class="form-group row" >
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
						<div class="form-group col-md-6">
							Clave: Valor
						</div>
					</div>
					</form>
				</div>-->
			</div>
@endsection