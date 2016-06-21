@extends('layouts.app')

@section('title', 'Profile Page')
@section('head')
    @parent
@endsection

@section('center')

<dl>
    <dt>Profile LINKS</dt>
    <dd>{{ link_to_route('work_shop_page', 'Shop') }}</dd>
    <dd>{{ link_to_route('work_orders_page', 'Orders list') }}</dd>
    <dd>{{ link_to_route('work_teamorders_page', 'TeamOrders list') }}</dd>
{{--    <dd>{{ link_to_route('work_mine_page', 'Работы под добыче ресурсов') }}</dd>--}}
    <dd>{{ link_to_route('work_show_privateteam_page', 'My TEam', ['id' => 1]) }}</dd>
</dl>
<dl>
    <dt>TEAMS</dt>
    <dd>{{ link_to_route('work_privateteams_page', 'Teams LIST') }}</dd>
</dl>

<p></p>

<br>В этом разделе добываются ресрсы.
<br>ОДни из них добываются напрямую, изнедр земли. Для добычи других нужен спец инвернтарь, инструменты
<br>Другие получаются путем обработки\очищения\расщепления одного или нескольких других ресурсов
<br>Третьи синтезируются на основе вторых и первых.
<br><br>
<br>    Для получения ресурса нужны станки, инструменты, расходный материал, и пр. инстрментарий.
<br>    Всего наименований ресурсов 20 шт.
<br>    Самый ценный - кристально чистая вода.
<p>

<p>Шаро-обрабатывающий завод
<p>Работы по обработке.
<p> Из шаров делают кубики. Их используют подведении газа \ отопления



@endsection

