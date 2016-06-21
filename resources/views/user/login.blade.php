@extends('lfm.layout')

@section('head')
    @parent
@endsection

@section('content')
    {{--@section('navbar')--}}
        {{--@parent--}}
    {{--@endsection--}}

			<div class="main-content">
				<div class="wrap">
					<div class="greeting">
						<h2>Welcome to LFM Alumni space</h2>
						<p>You can here register as a former LFM student and have access to LFM alumni database.</p>
					</div>

					<div class="two-cols cf">
						<div class="col">
							<p class="small">
								Already have an account?
							</p>
							<h2>Log in here</h2>
							{{--<form class="login">--}}
                            {!! Form::open(['action' => ['Lfm\AuthController@signIn'], 'class' => 'login']) !!}
								<div class="form-group has-success has-feedback">
									<label for="inputEmail1">Email</label>
									<input type="email" class="form-control" id="inputEmail1" value="asdfaf@adsfasf.ru" />
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
								</div>
								<div class="form-group has-success has-feedback">
									<label for="inputName">Name</label>
									<input type="text" class="form-control" id="inputName" value="Ivan" name="name"/>
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
								</div>
								<div class="form-group has-error has-feedback">
									<label for="inputPass">Password</label>
									<input type="password" class="form-control" id="inputPass" name="password" />
									<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
								</div>

								<div class="checkbox">
									<label>
										<input type="checkbox">Remember me</label>
								</div>
								
								<div class="form-inline">
									{{--<button type="submit" class="btn btn-default" id="login_btn" disabled="disabled">Log in</button>--}}
                                    {!! Form::submit('Log in', array('class' => 'btn btn-default', 'id' => 'login_btn')) !!}
									<div class="error-message form-group"><p>Please, fill “Password” fields</p></div>
								</div>
							{{--</form>--}}
                            {!! Form::close() !!}

                        </div>
						<div class="col">
							<p class="small">
								Don’t have an account?
							</p>
							<h2><a href="#">Register now</a></h2>
						</div>
					</div>

				</div>
			</div>
@endsection
