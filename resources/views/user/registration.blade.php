@extends('lfm.layout')

@section('head')
    @parent
@endsection

@section('content')
		<div id="page">
			<header class="navbar">
				<div class="wrap">
					<a class="logo">LFM</a>
				</div>
			</header>

			<div class="main-content">
				<div class="wrap">
					
					<h2>Registration</h2>
					<p class="inst">
						Please, fill following fields and wait some time for our welcome e-mail
					</p>

					{{--<form class="registration">--}}
                    {!! Form::open(['action' => ['Lfm\AuthController@signUp'], 'class' => 'registration']) !!}

                        <fieldset>
							<h5>Fill your Identity:</h5>
							<div class="form-group has-success has-feedback">
								<label for="firstname">First Name</label>
								<input type="text" class="form-control" id="firstname" value="Ivan">
								<span aria-hidden="true" class="glyphicon glyphicon-ok form-control-feedback"></span>
							</div>
							<div class="form-group form-group has-error has-feedback">
								<label for="name">Name</label>
								<input type="text" class="form-control" id="name" name="name" value="Test">
								<span aria-hidden="true" class="glyphicon glyphicon-remove form-control-feedback"></span>
							</div>
							<div class="form-group">
								<label for="inputEmail2">Email address</label>
								<input type="email" class="form-control" id="inputEmail2">
							</div>
							<div class="form-group short">
								<label for="bacyear">Bac year</label>
								<select class="form-control deco" id="bacyear" name="year">
									<option>1998</option>
									<option>2005</option>

								</select>
							</div>
						</fieldset>
						<fieldset>
							<h5>Fill your studies:</h5>
							<div class="form-group">
								<label for="country">Country</label>
								<select class="form-control deco" name="country">
									<option>Nigeria</option>
									<option>Zimbabwe</option>
								</select>
							</div>
							<div class="form-group">
								<label for="studyfield">Study field</label>
								<input type="text" class="form-control" id="studyfield">
							</div>
							<div class="form-group">
								<label for="branch">Teaching organisation branch</label>
								<input type="text" class="form-control" id="branch">
							</div>
						</fieldset>
						<fieldset class="last">
							<h5>Fill your Job:</h5>
							<div class="form-group">
								<label for="bacyear">Industry</label>
								<select class="form-control deco" name="industry">
									<option>Engineering</option>

								</select>
							</div>
							<div class="form-group">
								<label for="workcountry">Country of work</label>
								<select class="form-control deco" name="workcountry">
									<option>Somali</option>
								</select>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox">
									i agree with terms of service</label>
							</div>
						</fieldset>
						<div class="form-inline">
							{{--<button class="btn btn-default" type="submit" id="send_btn" disabled="disabled">Send</button>--}}
                            {!! Form::submit('Send', array('class' => 'btn btn-default', 'id' => 'send_btn')) !!}
							<div class="error-message form-group"><p>Please, fill “Country of work and Industry” fields</p></div>
						</div>
                    {!! Form::close() !!}
					{{--</form>--}}

				</div>
			</div>

		</div>
@endsection

