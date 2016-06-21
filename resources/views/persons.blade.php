@extends('layouts.app')

@section('title', 'Page Theatre index')
@section('head')
    @parent
    <script src="{{ asset('js/react-15.0.1/build/react.js')  }}"></script>
    <script src="{{ asset('js/react-15.0.1/build/react-dom.js')  }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-lg-5">

                Актеры театра
                <p>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th># </th>
                        <th>Роль</th>
                        <th>Исполняет</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($actors as $index => $actor)
                        <tr>
                            <td>{{ $index+1  }}</td>
                            <td>{{ $actor->name }}</td>
                            <td>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {!! $actors->render() !!}
            </div><!--/span-->

            <div class="col-lg-5">
                Автокомплит
                <p>
                    {!! Form::open(['action' => ['ApiTheatreController@autocomplete'], 'method' => 'GET']) !!}
                    {!! Form::text('q', '', ['id' =>  'q', 'placeholder' =>  'Enter name']) !!}
                    {!! Form::hidden('id_value', '', ['id' =>  'q_id']) !!}
                    {!! Form::submit('Search', array('class' => 'button expand')) !!}
                    {!! Form::close() !!}
            </div><!--/span-->

            <div class="col-lg-2">
                hghghgh

            </div><!--/span-->
        </div><!--/row-->



    </div><!--/.fluid-container-->



@endsection


@section('scripts')
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
//        $(function()
//        {
            $( "#q" ).autocomplete({
                source: "/api/theatre/search/autocomplete",
                minLength: 2,
                select: function(event, ui) {
                    $('#q').val(ui.item.value);
                    $('#q_id').val(ui.item.id);
                }
            });
//        });
    </script>
@endsection