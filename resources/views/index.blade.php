@extends('layouts.app')

@section('content')
			
			<div class="row align-items-start">
				<div class="col" style='background-color:#707070;'>
					<b>Pagador</b>
					<form action='savePersons' method='post'>
					{{ csrf_field() }}
					<div class="form-group row" >
						<div class="form-group col-md-6">
							<label for="documentPayer" class="col-sm-2 col-form-label-sm">Documento</label>
							<div class="col-sm-10">
								<input id='documentPayer' name='documentPayer' value="{{old('documentPayer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese documento" required>
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
							<label for="documentPayer" class="col-sm-2 col-form-label-sm">Tipo_De_Documento</label>
							<div class="col-sm-10">
								<select id='documentTypePayer' name='documentTypePayer' class="form-control form-control-sm" required>
								  <option value="" selected>Seleccione tipo de documento...</option>
								  <option value="CC" @if(old('documentTypePayer') == 'CC') selected @endif >Cédula Ciudadanía</option>
								  <option value="CE" @if(old('documentTypePayer') == 'CE') selected @endif >Cédula Extranjería</option>
								  <option value="TI" @if(old('documentTypePayer') == 'TI') selected @endif >Tarjeta Identidad</option>
								  <option value="PPN" @if(old('documentTypePayer') == 'PPN') selected @endif >Pasaporte</option>
								  <option value="NIT" @if(old('documentTypePayer') == 'NIT') selected @endif >Número Identificación Tributaria</option>
								  <option value="SSN" @if(old('documentTypePayer') == 'SSN') selected @endif >Social Security Number</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="firstNamePayer" class="col-sm-2 col-form-label-sm">Nombres</label>
							<div class="col-sm-10">
								<input id='firstNamePayer' name='firstNamePayer' type="text" value="{{old('firstNamePayer')}}" class="form-control form-control-sm" placeholder="Ingrese nombres" required>
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
								<input id='lastNamePayer' name='lastNamePayer' type="text" value="{{old('lastNamePayer')}}" class="form-control form-control-sm" placeholder="Ingrese apellidos" required>
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
					<div class="form-group row">
						<div class="form-group col-md-4">
							<label for="companyPayer" class="col-sm-2 col-form-label-sm">Compañía</label>
							<div class="col-sm-10">
								<input id='companyPayer' name='companyPayer' type="text" value="{{old('companyPayer')}}" class="form-control form-control-sm" placeholder="Ingrese compañía">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="emailAddressPayer" class="col-sm-2 col-form-label-sm">Email</label>
							<div class="col-sm-10">
								<input id='emailAddressPayer' name='emailAddressPayer' value="{{old('emailAddressPayer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese email" required>
								@if ($errors->has('emailAddressPayer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('emailAddressPayer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="addressPayer" class="col-sm-2 col-form-label-sm">Dirección</label>
							<div class="col-sm-10">
								<input id='addressPayer' name='addressPayer' value="{{old('addressPayer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese dirección">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-4">
							<label for="cityPayer" class="col-sm-2 col-form-label-sm">Ciudad</label>
							<div class="col-sm-10">
								<input id='cityPayer' name='cityPayer' value="{{old('cityPayer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese ciudad">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="provincePayer" class="col-sm-2 col-form-label-sm">Provincia</label>
							<div class="col-sm-10">
								<input id='provincePayer' name='provincePayer' value="{{old('provincePayer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese provincia">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="countryPayer" class="col-sm-2 col-form-label-sm">País</label>
							<div class="col-sm-10">
								<select id='countryPayer' name='countryPayer' class="form-control form-control-sm">
								  <option value="" selected>Seleccione país...</option>
								  <option value="CO" @if(old('countryPayer') == 'CO') selected @endif >COLOMBIA</option>
								  <option value="CL" @if(old('countryPayer') == 'CL') selected @endif >CHILE</option>
								  <option value="CU" @if(old('countryPayer') == 'CU') selected @endif >CUBA</option>
								  <option value="AR" @if(old('countryPayer') == 'AR') selected @endif >ARGENTINA</option>
								  <option value="EC" @if(old('countryPayer') == 'EC') selected @endif >ECUADOR</option>
								  <option value="PE" @if(old('countryPayer') == 'PE') selected @endif >PERU</option>
								  <option value="PY" @if(old('countryPayer') == 'PY') selected @endif >PARAGUAY</option>
								  <option value="BR" @if(old('countryPayer') == 'BR') selected @endif >BRASIL</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="phonePayer" class="col-sm-2 col-form-label-sm">Teléfono</label>
							<div class="col-sm-10">
								<input id='phonePayer' name='phonePayer' type="text" value="{{old('phonePayer')}}" class="form-control form-control-sm" placeholder="Ingrese teléfono">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="mobilePayer" class="col-sm-2 col-form-label-sm">Célular</label>
							<div class="col-sm-10">
								<input id='mobilePayer' name='mobilePayer' type="text" value="{{old('mobilePayer')}}" class="form-control form-control-sm" placeholder="Ingrese célular">
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
								<input id='documentBuyer' name='documentBuyer' value="{{old('documentBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese documento" required>
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
								  <option value="CC" @if(old('documentTypeBuyer') == 'CC') selected @endif >Cédula Ciudadanía</option>
								  <option value="CE" @if(old('documentTypeBuyer') == 'CE') selected @endif >Cédula Extranjería</option>
								  <option value="TI" @if(old('documentTypeBuyer') == 'TI') selected @endif >Tarjeta Identidad</option>
								  <option value="PPN" @if(old('documentTypeBuyer') == 'PPN') selected @endif >Pasaporte</option>
								  <option value="NIT" @if(old('documentTypeBuyer') == 'NIT') selected @endif >Número Identificación Tributaria</option>
								  <option value="SSN" @if(old('documentTypeBuyer') == 'SSN') selected @endif >Social Security Number</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="firstNameBuyer" class="col-sm-2 col-form-label-sm">Nombres</label>
							<div class="col-sm-10">
								<input id='firstNameBuyer' name='firstNameBuyer' value="{{old('firstNameBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese nombres" required>
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
								<input id='lastNameBuyer' name='lastNameBuyer' value="{{old('lastNameBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese apellidos" required>
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
					<div class="form-group row">
						<div class="form-group col-md-4">
							<label for="companyBuyer" class="col-sm-2 col-form-label-sm">Compañía</label>
							<div class="col-sm-10">
								<input id='companyBuyer' name='companyBuyer' value="{{old('companyBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese compañía">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="emailAddressBuyer" class="col-sm-2 col-form-label-sm">Email</label>
							<div class="col-sm-10">
								<input id='emailAddressBuyer' name='emailAddressBuyer' value="{{old('emailAddressBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese email" required>
								@if ($errors->has('emailAddressBuyer'))
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->get('emailAddressBuyer') as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="addressBuyer" class="col-sm-2 col-form-label-sm">Dirección</label>
							<div class="col-sm-10">
								<input id='addressBuyer' name='addressBuyer' value="{{old('addressBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese dirección">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-4">
							<label for="cityBuyer" class="col-sm-2 col-form-label-sm">Ciudad</label>
							<div class="col-sm-10">
								<input id='cityBuyer' name='cityBuyer' value="{{old('cityBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese ciudad">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="provinceBuyer" class="col-sm-2 col-form-label-sm">Provincia</label>
							<div class="col-sm-10">
								<input id='provinceBuyer' name='provinceBuyer' value="{{old('provinceBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese provincia">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="countryBuyer" class="col-sm-2 col-form-label-sm">País</label>
							<div class="col-sm-10">
								<select id='countryBuyer' name='countryBuyer' class="form-control form-control-sm">
								  <option value="" selected>Seleccione país...</option>
								  <option value="CO" @if(old('countryBuyer') == 'CO') selected @endif >COLOMBIA</option>
								  <option value="CL" @if(old('countryBuyer') == 'CL') selected @endif >CHILE</option>
								  <option value="CU" @if(old('countryBuyer') == 'CU') selected @endif >CUBA</option>
								  <option value="AR" @if(old('countryBuyer') == 'AR') selected @endif >ARGENTINA</option>
								  <option value="EC" @if(old('countryBuyer') == 'EC') selected @endif >ECUADOR</option>
								  <option value="PE" @if(old('countryBuyer') == 'PE') selected @endif >PERU</option>
								  <option value="PY" @if(old('countryBuyer') == 'PY') selected @endif >PARAGUAY</option>
								  <option value="BR" @if(old('countryBuyer') == 'BR') selected @endif >BRASIL</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="phoneBuyer" class="col-sm-2 col-form-label-sm">Teléfono</label>
							<div class="col-sm-10">
								<input id='phoneBuyer' name='phoneBuyer' value="{{old('phoneBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese teléfono">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="mobileBuyer" class="col-sm-2 col-form-label-sm">Célular</label>
							<div class="col-sm-10">
								<input id='mobileBuyer' name='mobileBuyer' value="{{old('mobileBuyer')}}" type="text" class="form-control form-control-sm" placeholder="Ingrese célular">
							</div>
						</div>
					</div>	  
					<button id='buyer' type="submit" class="btn btn-primary">Siguiente</button>
					</form>
				</div>
			</div>
@endsection