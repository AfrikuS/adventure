
Vehicle Info
<p></p>
State: {{ $vehicle->status }}
<p></p>damage: {{ $vehicle->damage_percent }} %
<p></p>
<p></p>
<ul>
    <li>acceleration: {{ $vehicle->acceleration }}</li>
    <li>stability:    {{ $vehicle->stability }}</li>
    <li>mobility:     {{ $vehicle->mobility }}</li>
    <li>fuel:         {{ $vehicle->fuel_level }}</li>
</ul>
<p></p>
<p></p>

{{--@if($raid != null)--}}
{{--{{ link_to_route('drive_raid_page', 'Рейд') }}--}}
{{--@endif--}}

